<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Budget;
use App\Cycle;
use App\Rules\ValidateConcept;
use App\Http\Resources\NewBudget;
use App\Http\Resources\BudgetsCollection;
use Illuminate\Support\Facades\DB;
use App\Specification;
class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return new BudgetsCollection(Cycle::find(session('cycle')->id)->budgets()->where('cycle_id',session('cycle')->id)->paginate(25));
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
        Validator::make($request->all(),[
          'concept' => ['required',new ValidateConcept('App\Budget')],
          'qty' => 'required|Numeric'
        ],[
          'required' => 'El campo es requerido',
          'number' => 'El campo ingresado debe de ser un número.',
        ])->validate();
        $budget = Budget::create([
          'cycle_id' => session('cycle')->id
        ]);
        $budget->specification()->create([
          'concept' => $request->concept,
          'qty' => $request->qty,
          'cycle_id' => session('cycle')->id,
        ]);
        DB::commit();
        return new NewBudget($budget);
      }catch(Exception $ex){
        DB::rollback();
        return $ex;
      }

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
        'concept' => "required|validateConceptUpdate:App\Budget,$request->specification_id",
        'qty' => 'required|Numeric'
      ],[
        'required' => 'El campo es requerido',
        'number' => 'El campo ingresado debe de ser un número.',
        'validate_concept_update' => 'El concepto ya existe dentro de la base de datos.',
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
        try{
          DB::beginTransaction();
          $budget = Budget::find($id);
          specification::whereIn('specificationable_id', $budget->items()->select('id')->get())
                       ->where('specificationable_type','App\Item')
                       ->delete();
          $budget->specification()->delete();
          $budget->delete();
          DB::commit();
          return response()->json(['budget'=>$budget]);
        }catch(Exception $err){
          DB::rollback();
          return $err;
        }

    }
}
