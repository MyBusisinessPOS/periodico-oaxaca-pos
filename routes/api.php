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

Route::post('register', 'App\Http\Controllers\API\AuthenticationAPIController@register');
Route::post('login', 'App\Http\Controllers\API\AuthenticationAPIController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', 'App\Http\Controllers\API\AuthenticationAPIController@logout');
    Route::get('profile', 'App\Http\Controllers\API\AuthenticationAPIController@profile');

    //
    Route::resource('plans', 'App\Http\Controllers\API\PlanAPIController');
    Route::resource('subscriptions', 'App\Http\Controllers\API\SubscriptionAPIController');
});
