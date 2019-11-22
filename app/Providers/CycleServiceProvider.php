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
      // if(!isset(session('cycle')->id))
      //    session(['cycle'=>Cycle::getActiveCycle()]);
    }
}
