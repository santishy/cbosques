<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Http\Resources\QuotationsCollection;
use App\Item;

class QuoteBudgetExport implements FromView
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    use Exportable;
    public $item;
    public function setItem($id){
      $this->item = Item::find($id);
      return $this;
    }
    public function view() : View
    {
        $quotations = new QuotationsCollection($this->item->quotations()->where('status','ACEPTADO')->get());
        return view('reports.tables.quotations',compact('quotations'));
    }
}
