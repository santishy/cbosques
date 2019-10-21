<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Cycle;

class CycleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       //session(['cycle'=>Cycle::where('active',1)->first()]);
    }
}
