<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DepartmentItem;
use App\Rules\ValidateQuoteAmount;
use Illuminate\Support\Facades\Validator;
use App\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\DatabaseNotification;

class QuotationController extends Controller
{
    public function store(Request $request){
      $this->validateQuote($request);
      try {
        DB::beginTransaction();
        $quotation = new Quotation($request->all());
        $quotation->archive = $request->file('archive')->store('quotations');
        $quotation->cycle_id = session('cycle')->id;
        $quotation->user_id = Auth::user()->id;
        $quotation->status="PENDIENTE";
        $quotation->save();
        DB::commit();
        return response()->json(['quotation' => $quotation]);
      } catch (\Exception $e) {
        DB::rollback();
        return $e;
      }
    }

    public function validateQuote($request){
      Validator::make($request->all(),[
        'item_id' => 'exists:items,id|required',
        'department_id' => 'exists:departments,id',
        'qty' => ['Numeric','required',new validateQuoteAmount($request->item_id)],
        'archive' => ['file'],
        'description' => ['required'],
        'iva' => ['required','Boolean'],
      ])->validate();
    }

    public function show(Quotation $quotation){
      return $quotation;
    }
    /**
    *
    *Link para descargar la imagen desde el navegador o archivo XD
    */
    public function download(Request $request){
      return \Storage::download('quotations/'.$request->archive);
    }
    /**
    *
    *Cambia el status de la cotización y se ejecutan eventos:
    * 1) NotifyUserAboutUpdatedQuotation que esta en App\Quotation, se activa events:updated
    */
    public function update(Request $request,Quotation $quotation){
      Validator::make($request->all(),[
        'qty' => ['Numeric','required',new validateQuoteAmount($request->item_id)],
        'status' => 'required'
      ]);
      try {
        DB::beginTransaction();
        $quotation->message = $request->message;
        $quotation->update(['status'=> $request->status]);
        $notification = DatabaseNotification::find($request->notification_id);
        $notification->data = $quotation;
        $notification->save();
        DB::commit();
        return response()->json(['quotation' => $quotation]);
      }catch (\Exception $e) {
        DB::rollback();
        return $e;
      }
    }
}
