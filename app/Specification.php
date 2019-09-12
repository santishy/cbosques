<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $fillable = ['cycle_id','specificationable_id','specificationable_type','concept','qty'];

    public function specificationable(){
      return $this->morphTo();
    }
}
