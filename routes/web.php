<?php

use Illuminate\Support\Facades\Storage;


Route::get('/hola',function(){
  dd(session('cycle')[0]['id']);
});

Route::get('/archivo',function(){
  return Storage::disk('public')->download('quotations/HMnniag3u5DxNHApB4SfxobGTX4Uajg0vCCI3Pvo.docx');
});
Route::get('/', 'HomeController@index');
