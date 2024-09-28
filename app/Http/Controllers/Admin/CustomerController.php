<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Show customerpage
    function customerPage():View{
        return view('pages.customerPage');
    }
    // Show Customer list
    public function customers(){
        $customers = User::where('role', 'customer')->get();

        return response()->json($customers);
    }
    // Create a Customer
    function CustomerCreate(Request $request){
        
        return User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'phone_number'=>$request->input('phone_number'),
            'address'=>$request->input('address'),
            'password'=>$request->input('password'),
            'role' => 'customer',
            
        ]);
    }
    // View Single Customer Details (including Rental History)
    public function show($id){
        $customer = User::with('rentals.car')->where('id', $id)->where('role', 'customer')->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }
    // Update Customer Details
    public function update(Request $request, $id){
        // Find the customer by ID
        $customer = User::where('id', $id)->where('role', 'customer')->firstOrFail();

        // Validation for updating fields
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update customer details
        $customer->update($request->only(['name', 'email', 'phone_number', 'address']));

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer]);
    }

    // Delete a Customer
    public function delete($id){
        $customer = User::where('id', $id)->where('role', 'customer')->firstOrFail();

        // Delete the customer and their rental history
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }

    public function customerRental($id){
        $rentals = Rental::with(['car', 'user']) // Eager load both car and user
        ->where('user_id', $id)
        ->get();

        return response()->json($rentals);
    }
}
