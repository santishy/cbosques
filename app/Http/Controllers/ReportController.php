<?php

namespace App\Http\Controllers;
use App\Budget;
use App\Quotation;
use Illuminate\Http\Request;
use App\Http\Resources\QuotationsCollection;
use Carbon\Carbon;
use App\Exports\BudgetExport;
use App\Exports\QuotationsExport;


class ReportController extends Controller
{
    public function general(){
      return Budget::BudgetReportWithItems()->get();
    }
    public function exportGeneral(BudgetExport $budgetExport){
      libxml_use_internal_errors(true);
      return $budgetExport->download('budgets.xlsx');
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
      $request = $this->setMonth($request);
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byMonth($request->month)->get());
    }
    public function pdfQuotesOfTheMonth(Request $request){
      $quotations = $this->quotations($request);
      $date = Carbon::now()->format('d-m-Y');
      $month = Carbon::createFromFormat('!m',$this->setMonth($request)->month)->isoFormat('MMMM');
      $pdf = \PDF::loadView('reports.quotations',compact(['quotations','date','month']));
      return $pdf->download('ReporteCotizacionesAutorizadas.pdf');
    }
    public function exportQuotesOfTheMonth(Request $request){
      $quotations = $this->quotations($request);
      $month = Carbon::createFromFormat('!m',$this->setMonth($request)->month)->isoFormat('MMMM');
      return (new QuotationsExport)->setQuotations($quotations)->download("$month.xlsx");
    }
    public function setMonth($request){
      if(!$request->has('month'))
        $request->month = Carbon::now()->month;
      return $request;
    }
    public function quotationsByDates(Request $request){
      return new QuotationsCollection(Quotation::currentCycleQuotes()->byDates($request->all())->get());
    }
    public function ExportQuotationsByDates(Request $request){
      $quotations = $this->quotationsByDates($request);
      return (new QuotationsExport)->setQuotations($quotations)->download("$request->initialDate a $request->finalDate.xlsx");
    }
    public function pdfQuotationsByDates(Request $request){
      $quotations = $this->quotationsByDates($request);
      $date = Carbon::now()->format('d-m-Y');
      $initialDate = Carbon::createFromFormat('Y-m-d',$request->initialDate)->isoFormat('dddd, Do MMMM YYYY');
      $finalDate =  Carbon::createFromFormat('Y-m-d',$request->finalDate)->isoFormat('dddd, Do MMMM YYYY');
      $pdf = \PDF::loadView('reports.quotations',compact(['quotations','date','initialDate','finalDate']));
      return $pdf->download('ReporteCotizacionesAutorizadas.pdf');
    }

}
