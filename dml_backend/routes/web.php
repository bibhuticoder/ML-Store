<?php

use Illuminate\Http\Request;

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

// App landing Page
Route::get('/', function () {
  return view('welcome');
});

// Login and Register
Auth::routes();

// Programmer
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/manage-credits', 'DashboardController@manageCredits')->name('manage-credits');
Route::post('/verify-payment', 'DashboardController@verifyPayment');
Route::resource('models', 'ModelController');

// models CRUD
// Stats
// Profile
