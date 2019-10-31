<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Specification;
class Cycle extends Model{
  protected $fillable = ['finalized_at','initialized_at','active','created_at'];
  protected $dates = ['initialized_at','finalized_at'];
  public function budgets(){
    return $this->hasMany(Budget::class);
  }
  public function items(){
    return $this->hasManyThrough('App\Item','App\Budget');
  }
  public static function getActiveCycle(){
    return Cycle::where('active',1)->first();
  }
}
