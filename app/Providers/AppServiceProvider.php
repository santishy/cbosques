<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Validator;
use App\Specification;
use DB;
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
      DB::statement("SET lc_time_names = 'es_ES'");
      Carbon::setLocale('es');
      Validator::extend('validateDateRange', function ($attribute, $value, $parameters, $validator) {
          return Carbon::create($value,'America\Mexico_City')->lessThan($parameters[0]);
      });
      /**
      *
      *Valida el campo concepto de la tabla polimorfica
      *
      *paramters[0] = 'model', parameters[1] = specifications.id
      */
      Validator::extend('validateConceptUpdate',function($attribute, $value, $parameters, $validator){
        return Specification::where([
                                      ['specificationable_type',$parameters[0]],
                                      ['cycle_id',session('cycle')->id],
                                      ['concept',$value],
                                      ['id','!=',$parameters[1]]
                                      ])->doesntExist();
      });
    }
}
