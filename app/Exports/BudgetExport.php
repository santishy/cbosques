<?php

namespace App\Exports;

use App\Budget;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
class BudgetExport implements FromView
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    use Exportable;
    public function view():View
    {
        $budgets = Budget::BudgetReportWithItems()->get();
        return view('exports.general',['budgets'=>$budgets,
                                       'items_total'=>Budget::totalItemsOfEachBudget($budgets)]);
    }
    
}
