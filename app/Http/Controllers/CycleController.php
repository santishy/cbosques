<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cycle;
use Illuminate\Support\Facades\Validator;
use App\Rules\DateGreaterThan;
use App\Events\CycleInsert;
use App\Http\Resources\Cycle as CycleCollection;
use App\Rules\UpdateCycleDate;
use Carbon\Carbon;
use App\Http\Resources\ItemsCollection;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function  __construct(){
      $this->middleware(['cycle'])->except(['store']);
    }
    public function index()
    {
        return  new CycleCollection(Cycle::all());
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
    public function items(){
      return new ItemsCollection(session('cycle')->items()->get());

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
        $validator= Validator::make($request->all(),[
          'initialized_at' => ['required','date',new DateGreaterThan,"validateDateRange:$request->finalized_at"],
          'finalized_at' => ['required','date',new DateGreaterThan]
        ],[
          'required' => 'El campo es requerido',
          'date' => 'Formato incorrecto, fecha invalida'
        ])->validate();
        $request['active'] = 1;
        $cycle = Cycle::create($request->except('_token'));
        event(new CycleInsert($cycle));
        $cycle->created=$cycle->created_at->format('y-m-d');
        return response()->json($cycle);
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

      $validator= Validator::make($request->all(),[
        'initialized_at' => ['required','date',"validateDateRange:$request->finalized_at",new UpdateCycleDate($id)],
        'finalized_at' => ['required','date',new UpdateCycleDate($id)]
      ],[
        'required' => 'El campo es requerido',
        'date' => 'Formato incorrecto, fecha invalida'
      ])->validate();
      $cycle = Cycle::where('id',$id)->update($request->except('_token','editing'));
      return $cycle;
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
