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
use App\Http\Resources\QuotationsCollection;
use App\Http\Resources\QuoteResource;
use App\Mail\BudgetCreated;
use Illuminate\Database\Eloquent\Builder;
use App\File;

class QuotationController extends Controller
{
    public function __constructor(){
      $this->middleware(['roles:admin,autorizador'])->except(['store']);
    }
    public function index(){
      return new QuotationsCollection(Quotation::with(['user','files'])->where('cycle_id',session('cycle')->id)->orderBy('id','desc')->paginate(25));
    }
    public function store(Request $request){
      $this->validateQuote($request);
      $attachments = $request->archive;
      foreach($attachments as $attachment){
        $attachment->store('quotations');
      }
      try {
      //  $this->authorize('store',new Quotation); PENSAR BIEN EN LA VALIDACION PARA LOS TRES TIPOS DE USERS 2
        DB::beginTransaction();
        $quotation = new Quotation($request->except('archive'));
        /*
        *
        *Aqui guardo el iva, lo comente por que asi se me pidio.
        */
      //  $quotation->iva = (boolean) $request->iva;
        $attachments = $request->archive;
        $quotation->cycle_id = session('cycle')->id;
        $quotation->user_id = Auth::user()->id;
        $quotation->status="PENDIENTE";
        $quotation->save();
        foreach ($attachments as $attachment) {
          File::create(['name'=>$attachment->store('quotations'),
                        'quotation_id'=>$quotation->id]);
        }
        DB::commit();
        return response()->json(['quotation' => $quotation]);
      } catch (\Exception $e) {
        DB::rollback();
        return $e;
      }
    }

    public function validateQuote($request){
      Validator::make($request->all(),[
        'description' => 'required',
        //'iva' => 'required',
        'item_id' => 'exists:items,id|required',
        'department_id' => 'exists:departments,id',
        'qty' => ['Numeric','required',new validateQuoteAmount($request->item_id,(boolean)$request->iva)],

      ],['required'=>'El campo es requerido',
         'exists'=>'El campo no existe en la base de datos',
         'numeric' => 'El campo debe ser númerico',
         'file' => 'El campo debe contener un archivo'])->validate();
    }

    public function show(Quotation $quotation){
      return new QuoteResource($quotation);
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
      $this->authorize('update',$quotation);
      Validator::make($request->all(),[
        'item_id' => 'exists:items,id|required',
        'qty' => ['Numeric','required',new validateQuoteAmount($request->item_id,$request->iva,$request->status)],
        'status' => ['required'],
      ],['required'=>'El campo es requerido',
         'exists'=>'El campo no existe en la base de datos',
         'numeric' => 'El campo debe ser númerico',
         'file' => 'El campo debe contener un archivo'])->validate();
      try {
        DB::beginTransaction();
      //  $quotation->message = $request->message;
        /*
        *Aquí comento el iva por que asi se me pidio
        *
        */
        //$quotation->iva = $request->iva; // Aqui lo agrego, para la hora de sacar el total con el nuevo iva lo incluya o excluya dependiendo el caso.
        $quotation->qty = $request->qty;
        $quotation->status = $request->status;
        $quotation->total = $quotation->total();
        $quotation->save();
        DB::commit();
        return response()->json(['quotation' => new QuoteResource($quotation)]);
      }catch (\Exception $e) {
        DB::rollback();
        return $e;
      }
    }
    public function email(){
      $quotation = Quotation::find(1);
      return (new BudgetCreated($quotation,'notifiable'))->render();
    }
}
