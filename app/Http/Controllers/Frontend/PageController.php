<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
class PageController extends Controller
{
    public function frontPage()
    {
        $availableCars = Car::where('availability', 1)->get();
    return view('pages.homePage', compact('availableCars'));
    }

    public function userProfile(Request $request)
    {
        $profile = User::where('id', $request->id)->first();
    return view('pages.homePage',compact('profile'));
    }
    
}
