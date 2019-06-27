<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Auth API
Route::post('auth/login', 'API\AuthController@authenticate');
Route::post('auth/register', 'API\AuthController@register');
Route::get('auth/me', 'API\AuthController@me');

Route::group(['namespace' => 'API\V1'], function () {

  // User Profile
  Route::get('customer-details', 'CustomerDetailController@show');
  Route::get('customer-details/models', 'CustomerDetailController@models');
  Route::get('customer-details/updates', 'CustomerDetailController@updates');
  Route::put('customer-details', 'CustomerDetailController@update');

  Route::get('programmer-details', 'ProgrammerDetailController@show');
  Route::get('programmer-details/models', 'ProgrammerDetailController@models');
  Route::get('programmer-details/updates', 'ProgrammerDetailController@updates');
  Route::put('programmer-details', 'ProgrammerDetailController@update');

  // Model
  Route::get('models', 'ModelController@index');
  Route::get('models/popular', 'ModelController@popular');
  Route::get('models/{id}', 'ModelController@show');
  Route::get('models/search', 'ModelController@search');
  Route::post('models', 'ModelController@store');
  Route::put('models/{id}', 'ModelController@update');
  Route::delete('models/{id}', 'ModelController@destroy');

  // Model Review
  Route::get('models/{model_id}/reviews', 'ModelReviewController@index');
  Route::get('model-reviews/{id}', 'ModelReviewController@show');
  Route::post('models/{model_id}/reviews', 'ModelReviewController@store');

  // Model Update
  Route::get('updates', 'ModelUpdateController@index');
  Route::post('models/{model_id}/updates', 'ModelUpdateController@store');
  Route::post('verify-update', 'ModelUpdateController@verify');
});

Route::get('file', function (Request $request) {
  $filepath = $request->query('filepath');
  return response()->download($filepath);
});
