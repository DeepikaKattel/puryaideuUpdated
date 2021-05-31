<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//riders tracking
Route::get('/', function () {
    return view('admin/login');
});


Auth::routes();
Route::get('/logout', 'HomeController@logout')->name('logout');

//authenticate different users
Route::post('login/customer', 'Auth\LoginController@loginCustomer');
Route::post('login/rider', 'Auth\LoginController@loginRider');
Route::post('login/admin', 'Auth\LoginController@loginAdmin');
Route::middleware(['approved'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
Route::middleware(['admin'])->group(function () {

    Route::get('chartjs', 'HomeController@chartjs');

    Route::get('/users_unapproved', 'UserController@unapproved')->name('admin.unapproved');
    Route::post('/users/{rider_id}/approve', 'UserController@approve')->name('admin.approve');

    Route::resource('/users', 'UserController');
    Route::get('/users/destroy/{id}', 'UserController@destroy')->name('u.destroy');

    Route::resource('/vehicleType', 'VehicleTypeController');
    Route::get('/vehicleType/destroy/{id}', 'VehicleTypeController@destroy')->name('v.destroy');
    Route::get('statusVT{id}', 'VehicleTypeController@status')->name('statusVT');


    Route::resource('/vehicle', 'VehicleController');
    Route::get('/vehicle/destroy/{id}', 'VehicleController@destroy')->name('ve.destroy');
    Route::get('statusV{id}', 'VehicleController@status')->name('statusV');

    Route::resource('/planType', 'PlanTypeController');
    Route::get('/planType/destroy/{id}', 'PlanTypeController@destroy')->name('p.destroy');

    Route::resource('/price', 'PriceController');
    Route::get('/price/destroy/{id}', 'PriceController@destroy')->name('pr.destroy');

    Route::resource('/plan', 'PlanController');
    Route::get('/plan/destroy/{id}', 'PlanController@destroy')->name('pl.destroy');
    Route::get('statusPl{id}', 'PlanController@status')->name('statusPl');

    Route::resource('/banner', 'BannersController');
    Route::get('/banner/destroy/{id}', 'BannersController@destroy')->name('ba.destroy');
    Route::get('statusB{id}', 'BannersController@status')->name('statusB');

    Route::get('/riders','RiderController@index')->name('riders.index');
    Route::get('statusR{id}', 'RiderController@status')->name('statusR');
    Route::get('license/{id}', 'RiderController@show')->name('license.show');
    Route::get('/rider/destroy/{id}', 'RiderController@destroy')->name('ri.destroy');

    Route::resource('/booking', 'BookingController');
    Route::get('statusB{id}', 'BookingController@status')->name('statusB');

    Route::get('/chart','HomeController@chart')->name('chart');


});
Route::get('/approval', 'HomeController@approval')->name('approval');
Route::get('/admin/dashboard', 'HomeController@admin')->name('admin/dashboard');
Route::get('/admin/login', 'Auth\LoginController@admin')->name('admin/login');
Route::get('/rider/login', 'Auth\LoginController@rider')->name('rider/login');

Route::post('register/rider', 'RiderController@rider')->name('rider.register');

Route::get('/map','UserController@map');
