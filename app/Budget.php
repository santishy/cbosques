<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Query\Builder;
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

    return  Budget::with(['specification','items'=>function($query){
                          $query->with('specification')
                                // ->withCount(['specification as items_total'=>function(Builder $query){
                                //   $query->select(DB::raw('SUM(qty)'));
                                // }])
                                ->withCount(Budget::quotationsCount());
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
  public function itemsWithSpecificationFromBudgets(){
    return  $this->with('items.specification');
  }
  public static function totalItemsOfEachBudget($budgets){
    $total = array();
    foreach ($budgets as $budget) {
      $total[$budget->id]=0;
      foreach($budget->items as $item)
        $total[$budget->id]+= $item->specification->qty ;
    }
    return $total;
  }
}
