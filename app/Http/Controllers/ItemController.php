<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use App\Http\Resources\ItemsCollection;
use App\Rules\ValidateQty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidateConcept;
use App\Item;
use App\Http\Resources\NewItem;
use App\Http\Resources\QuotationsCollection;
use App\Events\ItemInsert;
use App\Specification;
use App\Events\UpdatedItem;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
      $this->middleware('roles:admin',['except'=>'index']);
    }
    public function index(Request $request)
    {
        $budget = Budget::find($request->budget_id);
        return new ItemsCollection($budget->items()->orderBy('id','desc')->paginate(25));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try{
        DB::beginTransaction();
        $this->validateFormData($request);
        $item = Item::create([
          'budget_id' => $request->budget_id,
          'cycle_id' => session('cycle')->id,
        ]);
        $item->specification()->create([
          'concept' => $request->concept,
          'qty' => $request->qty,
          'cycle_id' => session('cycle')->id,
        ]);
        event(new ItemInsert($item));
        DB::commit();
        return new NewItem($item);
      }catch(Exception $ex){
        DB::rollback();
        return $ex;
      }
    }
    /**
    *
    *Valida los campos concept y qty
    *
    */
    public function validateFormData($request){
      Validator::make($request->all(),[
        'concept' => ['required',new ValidateConcept('App\Item')],
        'qty' => ['required','Numeric',new ValidateQty($request->budget_id)],
        'budget_id' => 'required'
      ],[
        'required' => 'El campo es requerido',
        'number' => 'El campo ingresado debe de ser un número.',
      ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }
    public function quotations(Item $item){
      $quotations=new QuotationsCollection($item->quotations()->where('status','ACEPTADO')->get());
      return $quotations;
    }
    public function pdfQuotations($id){
      $quotations=$this->quotations(Item::find($id));
      
      $pdf = \PDF::loadView('reports.quotations',compact('quotations'));
      return $pdf->download('reporte.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $item = Item::with(['specification','budget'])->find($id);
      Validator::make($request->all(),[
        'id' => "required|exists:items",
        'concept' => "required|validateConceptUpdate:App\Item,$request->specification_id",
        'qty' => ['required','Numeric',new ValidateQty($request->budget_id,$item)],
      ],[
        'required' => 'El campo es requerido',
        'number' => 'El campo ingresado debe de ser un número.',
        'validate_concept_update' => 'El concepto ya existe dentro de la base de datos.',
      ])->validate();
      event(new UpdatedItem($item,$request->qty)); // Ajusta la cantidad en el Budget (cuenta mayor) segun la modificacion
      /*Specification::where('id',$request->specification_id)
                                      ->update(['concept' => $request->concept,
                                                'qty' => $request->qty]);
                                                */
      $item->specification->concept = $request->concept;
      $item->specification->qty = $request->qty;
      $item->specification->save();
      $item->save();
      return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          DB::beginTransaction();
          $item = Item::find($id);
          $item->specification->delete();
          $item->delete();
          DB::commit();
          return response()->json(['item' => $item ]);
        }catch(Exception $err){
          return response()->json(['error' => $err]);
        }
    }
}
