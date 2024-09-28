<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;

class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard');
    }
    function Summary(Request $request):array{

        $car= Car::all()->count();
        $availableCar= Car::where('availability', 1)->count();
        $user= User::where('role', 'customer')->count();
        $rental=Rental::all()->count();
        $total_earn= Rental::all()->sum('total_cost');
        

        return[
            'car'=> $car,
            'availableCar'=> $availableCar,
            'user'=> $user,
            'rental'=> $rental,
            'total_earn'=> round($total_earn,2),
           
        ];
    }
}
