<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{
    // Show list of cars
    
    function carPage():View{
        return view('pages.carPage');
    }

    // Show form to create a new car
  
   
    function carList(Request $request)
    {
       
        return Car::all();
    }
    public function show($id)
{
    $car = Car::findOrFail($id);
    return response()->json($car);
}

    public function carCreate(Request $request)
    {
        // Validation of inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'car_type' => 'required|string|max:255',
            'daily_rent_price' => 'required|numeric|min:0',
            'availability' => 'required|in:1,0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if available
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $file_name = time() . '-' . $img->getClientOriginalName();
            $img_url = "uploads/{$file_name}";

            // Move file to public/uploads folder
            $img->move(public_path('uploads'), $file_name);
        } else {
            $img_url = null;  // Default null if no image
        }

        // Save car to database
        Car::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'car_type' => $request->input('car_type'),
            'daily_rent_price' => $request->input('daily_rent_price'),
            'availability' => $request->input('availability'),
            'image' => $img_url,
        ]);

        return response()->json(['message' => 'Car created successfully'], 201);
    }

 

    // Update car details
    public function update(Request $request, Car $car)
    {
        // Validation of inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'car_type' => 'required|string|max:255',
            'daily_rent_price' => 'required|numeric|min:0',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Update the car's attributes
        $car->name = $request->input('name');
        $car->brand = $request->input('brand');
        $car->model = $request->input('model');
        $car->year = $request->input('year');
        $car->car_type = $request->input('car_type');
        $car->daily_rent_price = $request->input('daily_rent_price');
        $car->availability = $request->input('availability');
    
        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
    
            // Handle new image upload
            $img = $request->file('image');
            $file_name = time() . '-' . $img->getClientOriginalName();
            $img_url = "uploads/{$file_name}";
    
            // Move file to public/uploads folder
            $img->move(public_path('uploads'), $file_name);
    
            // Update the image path
            $car->image = $img_url;
        }
    
        // Save the updated car details
        $car->save();
    
        return response()->json(['message' => 'Car updated successfully'], 200);
    }



function delete(Request $request)
    {
        
        $id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Car::where('id',$id)->delete();

    }
}
