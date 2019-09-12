<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Specification;
class Cycle extends Model{
  protected $fillable = ['finalized_at','active','created_at'];

  public function budgets(){
    return $this->hasMany(Budget::class);
  }
}
