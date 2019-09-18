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
use App\Events\ItemInsert;
use App\Specification;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $budget = Budget::find($request->budget_id);
        return new ItemsCollection($budget->items()->paginate(25));
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
          'budget_id' => $request->budget_id
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
      Validator::make($request->all(),[
        'concept' => "required|validateConceptUpdate:App\Item,$request->specification_id",
        'qty' => ['required','Numeric',new ValidateQty($request->budget_id)],
      ],[
        'required' => 'El campo es requerido',
        'number' => 'El campo ingresado debe de ser un número.',
        'validateConceptUpdate' => 'El concepto ya existe dentro de la base de datos.',
      ])->validate();
      $specification = Specification::where('id',$request->specification_id)
                                      ->update(['concept' => $request->concept,
                                                'qty' => $request->qty]);
      return $specification;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
