<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
  protected $fillable = ['budget_id','cycle_id'];
  public function specification(){
    return $this->morphOne(Specification::class,'specificationable');
  }
  public function budget(){
    return $this->belongsTo(Budget::class);
  }
  public function departments(){
    return $this->morphToMany(Department::class,'departmentable');
  }
}
