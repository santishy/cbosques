<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
  'prefix' => 'auth',
  'middleware'=>'api'
],function(){
  Route::post('login','AuthController@login')->name('login');
  Route::post('logout', 'AuthController@logout')->name('logout');
  Route::post('refresh', 'AuthController@refresh')->name('refresh');
  Route::post('me', 'AuthController@me')->name('me');
});

Route::resource('cycles','CycleController');
Route::resource('budgets','BudgetController');
Route::resource('items','ItemController');
