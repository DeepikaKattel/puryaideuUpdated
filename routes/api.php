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
Route::post('user_login', 'Api\LoginController@login');
Route::get('user_logout', 'Api\LoginController@logout')->middleware('auth:api');
Route::get('auth/google', 'Api\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Api\LoginController@handleGoogleCallback');
