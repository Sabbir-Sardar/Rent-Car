<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;


class RentalsController extends Controller
{
   

    public function userRental($customerId)
{
    $rentals = Rental::with('car')
    ->where('user_id', $customerId)
    ->get();

return view('pages.homePage', compact('rentals'));
}

public function deleteRental(Request $request, $id) {
    $rental = Rental::find($id);
    if ($rental) {
        $car = Car::findOrFail($rental->car_id);
   $car->availability = 1;  // Set availability to 0
    $car->save();  
    // Delete the 
        $rental->delete();
        return redirect()->back()->with('success', 'Rental deleted successfully');
    }
    return redirect()->back()->with('error', 'Rental not found');
}

}
