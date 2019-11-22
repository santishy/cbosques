<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];
    public function items(){
      return $this->morphedByMany(Item::class,'departmentable');
    }
    public function scopeCurrentCycle($query){
      return $query->where('cycle_id',session('cycle')->id);
    }

}
