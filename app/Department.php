<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];
    public function items(){
      return $this->belongsToMany(Item::class);
    }
}
