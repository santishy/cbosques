<?php



Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/hola',function(){
  dd(session('cycle')[0]['id']);
});
