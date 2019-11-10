<?php

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

Route::get('/hola',function(){
  $now = Carbon::now();
  echo $now;
  echo $now->addMonths(2);
});

Route::get('/archivo',function(){
  return Storage::disk('public')->download('quotations/HMnniag3u5DxNHApB4SfxobGTX4Uajg0vCCI3Pvo.docx');
});
Route::get('/', 'HomeController@index');

Route::get('/quotations/email','QuotationController@email');
