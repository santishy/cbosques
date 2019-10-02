<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DepartmentItem;
use App\Rules\ValidateQuoteAmount;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    public function store(Request $request){

      // return DepartmentItem::find($request->department_item_id)->item->specification->qty;
    
      Validator::make($request->all(),[
        'department_item_id' => 'exists:department_item,id|required',
        'qty' => ['Numeric','required',new validateQuoteAmount($request->department_item_id)],
        'archive' => ['file'],
        'description' => ['required'],
        'iva' => ['required','Boolean'],
      ])->validate();
      return $request->all();
    }
}
