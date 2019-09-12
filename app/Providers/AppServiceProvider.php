<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Validator::extend('validateDateRange', function ($attribute, $value, $parameters, $validator) {
          return Carbon::create($value,'America\Guadalajara')->lessThan($parameters[0]);
      });
    }
}
