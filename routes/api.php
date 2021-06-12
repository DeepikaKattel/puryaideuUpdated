<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user_register', 'Api\RegisterController@register');
//Route::post('user_login', 'Api\LoginController@login');
Route::post('send_sms','Api\RegisterController@store');
Route::post('verify_user','Api\RegisterController@verifyContact');

//User
Route::get('user_logout', 'Api\LoginController@logout')->middleware('auth:api');
Route::get('user_detail', 'Api\LoginController@user')->middleware('auth:api');
Route::get('user_history', 'Api\LoginController@history')->middleware('auth:api');
Route::put('user_update/{id}','Api\LoginController@update')->middleware('auth:api');
Route::post('specific_user','Api\LoginController@user_id');


//Booking
Route::post('user_booking','Api\BookingController@store')->middleware('auth:api');
Route::get('statusB{id}', 'Api\BookingController@status')->name('statusB');
Route::get('statusCancel{id}', 'Api\BookingController@cancel_rider')->name('statusCancel');
Route::get('statusOfRider{id}', 'BookingController@statusRider')->name('statusOfRider');
Route::get('estimated_price','Api\BookingController@estimated_price')->middleware('auth:api');

Route::post('location_riders','Api\AvailableRidersController@store');
Route::get('available_riders','Api\AvailableRidersController@available_riders');
Route::post('rider_register', 'Api\AvailableRidersController@rider');

Route::get('auth/google', 'Api\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Api\LoginController@handleGoogleCallback');


//Route::get('phone/verify', 'Api\PhoneVerificationController@show')->name('phoneverification.notice');
//Route::post('phone/verify', 'Api\PhoneVerificationController@verify')->name('phoneverification.verify');
//Route::post('build-twiml/{code}', 'Api\PhoneVerificationController@buildTwiMl')->name('phoneverification.build');
