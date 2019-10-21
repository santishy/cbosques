<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\UpdatedItem;
class Specification extends Model
{
    protected $fillable = ['cycle_id','specificationable_id','specificationable_type','concept','qty'];
  //  protected $dispatchEvents=['updating'=>UpdatedItem::class];
    public function specificationable(){
      return $this->morphTo();
    }
}
