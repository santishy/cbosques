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
  Route::post('register','AuthController@register');
});
Route::namespace('Auth')->group(function () {
  Route::get('users/items','UserController@items');
  Route::get('users/quotations','UserController@quotations');
  Route::resource('users','UserController');
});
Route::group([
  'middleware' => 'jwt'
],function(){
  Route::put('cycles/select-cycle','CycleController@selectCycle');
  Route::get('cycles/items','CycleController@items');
  Route::resource('cycles','CycleController');
  Route::get('budgets/quotations/{budget}','BudgetController@quotations');
  Route::resource('budgets','BudgetController');
  Route::get('items/quotations/{item}','ItemController@quotations');
  Route::resource('items','ItemController');
  Route::resource('specifications','SpecificationController');
  Route::resource('departments','DepartmentController');
  Route::get('department/items','DepartmentController@items');
  Route::post('department-item/store','DepartmentItemController@store');
  Route::delete('department-item/{department_id}','DepartmentItemController@destroy');
  Route::get('notifications','NotificationsController@index');
  Route::get('notifications/unreadNotifications','NotificationsController@unreadNotifications');
  Route::get('notifications/allRead','NotificationsController@allRead');
  Route::put('notifications/{id}','NotificationsController@read');
  Route::delete('notifications/{id}','NotificationsController@destroy');
  Route::get('quotations','QuotationController@index');
  Route::post('quotations','QuotationController@store');
  Route::put('quotations/{quotation}','QuotationController@update');
  Route::get('quotations/{quotation}','QuotationController@show');
  Route::get('quotations/download/{archive}','QuotationController@download');
  Route::get('roles','RoleController@index');
  Route::get('reports/general','ReportController@general');
});
