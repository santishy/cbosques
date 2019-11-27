<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Budget extends Model
{
  protected $fillable = ['cycle_id'];

  public function specification(){
    return $this->morphOne('App\Specification','specificationable');
  }
  public function items(){
    return $this->hasMany(Item::class);
  }
  public function quotations(){
    return $this->hasManyThrough(Quotation::class,Item::class);
  }
  public static function BudgetReportWithItems(){
    //return Budget::sum('qty')->with(['items.specification']);
    return  Budget::with(['specification','items'=>function($query){
                          $query->with('specification')->withCount(Budget::quotationsCount());
                        }])
                        ->withCount(Budget::quotationsCount())
                        ->where('cycle_id',session('cycle')->id);
  }
  public static function quotationsCount(){
    return ['quotations'=>function(Builder $query){
      $query->where('status','ACEPTADO');
    },'quotations as total'=>function(Builder $query){
      $query->select(DB::raw('SUM(total)'))->where('status','ACEPTADO');
    }];
  }
}
