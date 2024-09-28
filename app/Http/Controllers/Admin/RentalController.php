<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\View\View;
use App\Mail\AdminBookingMail;
use App\Mail\CustomerBookingMail;
use Illuminate\Support\Facades\Mail;

class RentalController extends Controller
{
    function rentalPage():View{
        return view('pages.rentalPage');
    }
    public function rentalsList()
{
    // Retrieve rentals with customer and car details
    $rentals = Rental::with(['user', 'car'])->get();

    return response()->json($rentals);
}
    
        // Mark the car as unavailable if booking is successful
        public function store(Request $request)
        {
            // Validate the incoming request data
            $validated = $request->validate([
                'car_id' => 'required|exists:cars,id',
                'rental_start_date' => 'required|date|after_or_equal:today',
                'rental_end_date' => 'required|date|after_or_equal:rental_start_date', // Allow same day for start and end
            ]);
        
            // Fetch the car details
            $car = Car::find($validated['car_id']);
        
            // Check for conflicting bookings across all cars
            $conflictingBookings = Rental::where('car_id', $car->id)
                ->where(function ($query) use ($validated) {
                    // Check for overlapping bookings
                    $query->whereBetween('start_date', [$validated['rental_start_date'], $validated['rental_end_date']])
                          ->orWhereBetween('end_date', [$validated['rental_start_date'], $validated['rental_end_date']])
                          ->orWhere(function ($query) use ($validated) {
                              $query->where('start_date', '<=', $validated['rental_start_date'])
                                    ->where('end_date', '>=', $validated['rental_end_date']);
                          });
                })->exists();
        
            // If there are conflicting bookings, return an error
            if ($conflictingBookings) {
                return response()->json(['success' => false, 'message' => 'This car is not available during the selected dates.']);
            }
        
            // Calculate the total cost based on days and rent price
            $startDate = Carbon::parse($validated['rental_start_date']);
            $endDate = Carbon::parse($validated['rental_end_date']);
            $days = $startDate->diffInDays($endDate) + 1; // Allow one day booking
        
            // Ensure days are at least 1 for pricing
            if ($days < 1) {
                return response()->json(['success' => false, 'message' => 'Invalid booking duration.']);
            }
        
            $totalCost = $car->daily_rent_price * $days;
        
            // Create the booking record
            $rental = Rental::create([
                'user_id' => auth()->id(),
                'car_id' => $validated['car_id'],
                'start_date' => $validated['rental_start_date'],
                'end_date' => $validated['rental_end_date'],
                'total_cost' => $totalCost,
            ]);

           
        
            // Mark the car as unavailable if booking is successful
            if ($rental) {
                // Update the car's availability to 0
                $car->availability = 0;  // Set availability to 0
                $car->save();  

                $bookingDetails = [
                    'customer_name' => auth()->user()->name,
                    'car_name' => $car->name,
                    'start_date' => $validated['rental_start_date'],
                    'end_date' => $validated['rental_end_date'],
                    'total_cost' => $totalCost
                ];

                Mail::to('admin@mail.com')->send(new AdminBookingMail($bookingDetails));

                // Optionally, send the same email to the customer
                Mail::to(auth()->user()->email)->send(new CustomerBookingMail($bookingDetails));


            return response()->json(['success' => true, 'message' => 'Booking successful!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Booking failed. Please try again.']);
        }
        
    }



    public function getBookingDetails($id)
    {
        $rental = Rental::with(['car'])->find($id);
        return response()->json($rental);
    }

    public function updateBooking(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
    ]);

    // Check for date conflicts
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $bookingId = $id;

    $conflictingBookings = Rental::where('id', '!=', $bookingId)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })
        ->exists();

    if ($conflictingBookings) {
        return response()->json(['success' => false, 'message' => 'Date conflict: The selected dates overlap with an existing booking.'], 422);
    }

    // Update the booking data
    $booking = Rental::find($id);
    $booking->start_date = $request->input('start_date');
    $booking->end_date = $request->input('end_date');
    $booking->save();

    // Return a JSON response
    return response()->json(['success' => true, 'message' => 'Booking updated successfully']);
}

public function delete($id){
   
    $rental = Rental::where('id', $id)->firstOrFail();
    $car = Car::findOrFail($rental->car_id);
   $car->availability = 1;  // Set availability to 0
    $car->save();  
    // Delete the customer and their rental history
    $rental->delete();

    return response()->json(['message' => 'Customer deleted successfully']);
}
}
