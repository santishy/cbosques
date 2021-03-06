<?php

namespace App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Events\QuotationCreated;
use App\Events\UpdatedQuotation;
use Illuminate\Support\Facades\DB;

class Quotation extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['qty','status','iva','total','description','item_id','user_id','archive','department_id'];
    protected $dispatchesEvents=['created' => QuotationCreated::class,
                                  'updating' => UpdatedQuotation::class,];
    public $message;

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
      return $this->belongsTo('App\Item');
    }
    public function itemSpecification(){
      return $this->hasOneThrough('App\Specification','App\Item','id','specificationable_id','item_id','id');
    }
    public function iva(){
      if($this->iva){
        return 0;
      }
      return $this->qty * 0.16;
    }
    public function total(){
      return $this->qty + $this->iva();
    }
    public static function currentCycleQuotes(){
      return Quotation::where('cycle_id',session('cycle')->id)->where('status','ACEPTADO');
    }
    public function scopeByMonth($query,$month){
      return $query->whereMonth('created_at', $month);
    }
    public function scopeByDates($query,$date){
      return $query->whereBetween(DB::raw('Date(created_at)'),[$date['initialDate'],$date['finalDate']]);
    }
    public function files(){
      return $this->hasMany(File::class);
    }
}
