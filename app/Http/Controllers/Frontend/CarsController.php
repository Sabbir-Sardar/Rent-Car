<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;

class CarsController extends Controller
{
    public function getAllCars()
{
    $cars = Car::where('availability', 1)->get();
    return view('pages.homePage', compact('cars'));
}
public function getAvailableCars()
{
    $cars = Car::where('availability', 1)->get();
    return response()->json($cars);
}
public function getCarTypesAndBrands(): JsonResponse
{
    // Fetch unique car types and brands
    $carTypes = Car::select('car_type')->distinct()->pluck('car_type');
    $carBrands = Car::select('brand')->distinct()->pluck('brand');

    return response()->json([
        'car_types' => $carTypes,
        'car_brands' => $carBrands,
    ]);
}
public function searchCars(Request $request)
{
    // Retrieve the search parameters from the request
    $carType = $request->input('car_type');
    $brand = $request->input('brand');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Step 1: Fetch all cars that match the criteria (optional carType and brand filters)
    $cars = Car::when($carType, function($query) use ($carType) {
                    // Apply car_type filter only if provided
                    return $query->where('car_type', $carType);
                })
                ->when($brand, function($query) use ($brand) {
                    // Apply brand filter only if provided
                    return $query->where('brand', $brand);
                })
                ->get();

    // Step 2: Filter out cars that are already booked in the specified date range
    $availableCars = $cars->filter(function($car) use ($startDate, $endDate) {
        $existingRentals = Rental::where('car_id', $car->id)
            ->where(function($query) use ($startDate, $endDate) {
                // Check for overlapping rental dates
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhereRaw('? BETWEEN start_date AND end_date', [$startDate])
                      ->orWhereRaw('? BETWEEN start_date AND end_date', [$endDate]);
            })
            ->exists();
        
        // Return true if no existing rentals are found in that date range
        return !$existingRentals;
    });

    // Step 3: Return the filtered available cars to a Blade view
    return view('pages.homePage', compact('availableCars'));
}

public function viewAllRentals()
    {
        // Fetch all available cars for rental
        $availableCars = Car::where('availability', 1)->get(); // Assuming '1' means available

        // Pass the cars data to the view
        return view('pages.homePage', compact('availableCars'));
    }
    public function filterCars(Request $request)
    {
        // Retrieve the filter option from the query parameters
        $filter = $request->query('filter');

        // Start with a base query
        $query = Car::where('availability', 1);

        // Apply filter conditions based on the selected filter
        if ($filter === 'price_low_high') {
            $query->orderBy('daily_rent_price', 'asc');
        } elseif ($filter === 'price_high_low') {
            $query->orderBy('daily_rent_price', 'desc');
        } elseif ($filter === 'latest') {
            $query->orderBy('year', 'desc');
        }

        // Get the filtered cars
        $cars = $query->get();

        // Return the filtered cars as JSON
        return response()->json($cars);
    }

}
