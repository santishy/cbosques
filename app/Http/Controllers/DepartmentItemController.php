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
        'department_id' => ['required',Rule::unique('department_item')->where(function($query) use ($request){
                                return $query->where('item_id',$request->item_id);
                              })],
        'item_id' => ['required'],],
      [
        'required' => 'El campo es requerido',
        'unique' => 'Ya existe esta cuenta en el departamento',
      ])->validate();
      return Department::find($request->department_id)->items()->attach($request->item_id);
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
