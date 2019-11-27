<?php

namespace App\Http\Controllers;
use App\Budget;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function general(){
      return Budget::BudgetReportWithItems()->get();
    }
}
