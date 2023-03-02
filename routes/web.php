<?php

use App\Http\Controllers\SubscriptionController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('publications', 'App\Http\Controllers\PublicationController');
    Route::resource('sign-documents', 'App\Http\Controllers\SignDocumentController');
    Route::resource('signs', 'App\Http\Controllers\SignController');
    Route::post('signs/sign-document', 'App\Http\Controllers\SignController@signDocument')->name('sign-file');
    Route::resource('admin-subscriptions', 'App\Http\Controllers\AdminSubscriptionController');
    Route::resource('calendars', 'App\Http\Controllers\CalendarController');
    Route::get('calendar/events', 'App\Http\Controllers\CalendarController@getEvents')->name('calendar-events');
    Route::resource('orders', 'App\Http\Controllers\OrderController');
});

Route::prefix('subscribe')->name('subscribe.')->group(function () {
    Route::get('/', [SubscriptionController::class, 'show'])->name('show');
    Route::post('/', [SubscriptionController::class, 'store'])->name('store');
});
