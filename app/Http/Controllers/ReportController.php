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
    public function pdfGeneral(){
      $budgets = $this->general();
      $now = Carbon::now()->format('d-m-Y');
      $pdf = \PDF::loadView('reports.general',
                            ['budgets'=>$budgets,
                            'items_total'=>$this->totalItemsOfEachBudget($budgets),
                            'date' => $now]);
      return $pdf->download('reporte-general.pdf');
    }
    public function totalItemsOfEachBudget($budgets){
      $total = array();
      foreach ($budgets as $budget) {
        $total[$budget->id]=0;
        foreach($budget->items as $item)
          $total[$budget->id]+= $item->specification->qty ;
      }
      return $total;
    }
    public function quotations(Request $request){
      if(!$request->has('month'))
        $request->month = Carbon::now()->month;
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byMonth($request->month)->get());
    }
    public function pdfQuotesOfTheMonth(Requeste $request){
      $quotations = $this->quotations($request);
      $pdf = \PDF::loadView('reports.quotations',compact('quoatations'));
      return $pdf->download('ReporteCotizacionesAutorizadas');
    }
    public function quotationsByDates(Request $request){
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byDates($request->all())->get());
    }
}
