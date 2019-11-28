<?php

namespace App\Http\Controllers;
use App\Budget;
use App\Quotation;
use Illuminate\Http\Request;
use App\Http\Resources\QuotationsCollection;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function general(){
      return Budget::BudgetReportWithItems()->get();
    }
    public function quotations(Request $request){
      if(!$request->has('month'))
        $request->month = Carbon::now()->month;
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byMonth($request->month)->get());
    }
    public function quotationsByDates(Request $request){
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byDates($request->all())->get());
    }
}
