<?php

namespace App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Events\QuotationCreated;

class Quotation extends Model
{
    protected $guarded = ['id'];

    protected $dispatchesEvents=['created' => QuotationCreated::class];

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
