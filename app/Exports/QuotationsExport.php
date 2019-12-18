<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;

class QuotationsExport implements FromView
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    use Exportable;
    public $quotations;

    public function setQuotations($quotations){
      $this->quotations = $quotations;
      return $this;
    }
      public function view() : View
    {
        return view('reports.tables.quotations',['quotations'=>$this->quotations]);
    }
}
