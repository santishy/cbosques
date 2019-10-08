<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $guarded = ['id'];
    public function parentable()
    {
        return $this->morphTo();
    }
    public function user(){
      return $this->belongsTo('App\User');
    }
    public function department(){
      return $this->belongsTo('App\Department');
    }
    public function item(){
      return $this->belongsTo('App\User');
    }
    public function itemSpecification(){
      return $this->hasOneThrough('App\Specification','App\Item','id','specificationable_id','item_id','id');
    }
    
}
