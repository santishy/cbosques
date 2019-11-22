<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentItemController extends Controller
{
  public function __construct(){
    $this->middleware(['roles:admin','cycle']);
  }
    public function store(Request $request){
      Validator::make($request->all(),[
        'department_id' => ['required',Rule::unique('departmentables')->where(function($query) use ($request){
                                return $query->where('departmentable_id',$request->item_id)->where('departmentable_type','App\Item');
                              })],
        'item_id' => ['required'],],
      [
        'required' => 'El campo es requerido',
        'unique' => 'Ya existe esta cuenta en el departamento',
      ])->validate();
      Department::find($request->department_id)->items()->attach($request->item_id);
      return response()->json(['success'=>true]);
    }
    public function destroy(Request $request,$department_id){
      Validator::make($request->all(),[
        'department_id' =>'required',
        'item_id' => 'required'
      ],
      [
        'required' => 'El campo es requerido'
      ]);
      $department = Department::find($department_id);
      if($department)
        return $department->items()->detach($request->item_id);
      return;
    }
}
