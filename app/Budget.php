<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Budget extends Model
{
  protected $fillable = ['cycle_id'];

  public function specification(){
    return $this->morphOne('App\Specification','specificationable');
  }
  public function items(){
    return $this->hasMany(Item::class);
  }
}
