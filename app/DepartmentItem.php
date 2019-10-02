<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentItem extends Model
{
    protected $fillable = ['item_id','department_id'];
    protected $table = 'department_item';

    public function item(){
      return $this->belongsTo('App\Item');
    }
}
