<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\CarsController;
use App\Http\Controllers\Frontend\RentalsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RentalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [PageController::class, 'frontPage'])->name('frontpage');
Route::get('/admin', [UserController::class, 'adminLayout'])->name('admin')->middleware('auth');



// Frontend Rental Cars manage routes
Route::get('/rentals', [CarsController::class, 'viewAllRentals'])->name('view.all.rentals');
Route::post('/searchCars', [CarsController::class, 'searchCars'])->name('searchCars');
Route::get('/getCarTypesAndBrands', [CarsController::class, 'getCarTypesAndBrands'])->name('getCarTypesAndBrands');
Route::get('/filter-cars', [CarsController::class, 'filterCars'])->name('filter.cars');

// Frontend User Profile,Rental list manage routes
Route::get('/userProfile/{id}', [PageController::class, 'userProfile'])->name('userProfile')->middleware('auth');
Route::get('/userRental/{customerId}', [RentalsController::class, 'userRental'])->name('userRental')->middleware('auth');
Route::delete('/deleteRental/{id}', [RentalsController::class, 'deleteRental'])->name('deleteRental')->middleware('auth');

//Admin Customer Manage Routes
Route::get('/customers', [CustomerController::class, 'customers'])->middleware('auth'); // View all customers
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware('auth');
Route::get('/customers/{id}', [CustomerController::class, 'show'])->middleware('auth'); // View single customer details (including rental history)
Route::put('/customers/{id}', [CustomerController::class, 'update'])->middleware('auth'); // Update customer details
Route::delete('/customers/{id}', [CustomerController::class, 'delete'])->middleware('auth'); // Delete customer
Route::get('/customerPage',[CustomerController::class,'customerPage'])->middleware('auth');
Route::get('/customerRental/{id}', [CustomerController::class, 'customerRental'])->name('customerRental')->middleware('auth'); //show customer page

//Admin Car Manage Routes
Route::get('/cars', [CarController::class, 'carPage'])->middleware('auth'); //show car page
Route::get('/carList', [CarController::class, 'carList'])->middleware('auth'); // View all cars
Route::get('/cars/{id}', [CarController::class, 'show'])->name('car.show')->middleware('auth'); //Show Car details by id
Route::post("/carCreate",[CarController::class,'carCreate'])->middleware('auth'); //Create a new car
Route::put('/cars/{car}', [CarController::class, 'update'])->middleware('auth'); //Update car by id
Route::post("/delete",[CarController::class,'delete'])->middleware('auth'); //delete car

//Admin Rental Manage Routes
Route::get('/rentalPage',[RentalController::class,'rentalPage'])->middleware('auth'); 
Route::get('/rentalsList', [RentalController::class, 'rentalsList'])->middleware('auth');
Route::post('/book-car', [RentalController::class, 'store'])->name('book.car')->middleware('auth');
Route::get('/get-booking-details/{id}', [RentalController::class, 'getBookingDetails'])->middleware('auth');//Show Rental details by id
Route::put('/update-booking/{id}', [RentalController::class, 'updateBooking'])->middleware('auth');
Route::delete('/rentals/{id}', [RentalController::class, 'delete'])->middleware('auth'); // Delete Rentals

Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware('auth');
Route::get("/summary",[DashboardController::class,'Summary'])->middleware('auth');






require __DIR__.'/auth.php';
