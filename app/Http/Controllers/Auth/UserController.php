<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Quotation;
use App\Budget;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ItemsThroughDepartmentsCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\QuotationsCollection;
use App\Rules\DepartmentAssociatedWithTheUser;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
      return new UsersCollection(User::with(['roles'=>function($query){
        $query->select('roles.name','roles.id','display_name');
      }])->get());
    }
    public function update(Request $request,User $user){
      Validator::make($request->all(),[
        'column' => ['required'],
        'value' => ['required'],
      ],[
        'required' => 'El campo es requerido',
      ])->validate();
      switch ($request->column) {
        case 'name':
          return $this->setName($request,$user);
          break;
        case 'email':
          return  $this->setEmail($request,$user);
          break;
        case 'department_id':
          return $this->setDepartments($request,$user);
          break;
        default:
          return $this->setRoles($request,$user);
          break;
      }

    }
    public function setName($request,$user){
     $user->name=$request->value;
     $user->save();
     return new UserResource($user);
    }
    public function setEmail($request,$user){
      Validator::make([$request->column => $request->value],[
        'email' => ["unique:users,email,$user->id","email"],
      ],
      [
        'email' => 'No es un email valido',
        'unique' => 'El email ya existe en la base de datos'
        ])->validate();
      $user->email = $request->value;
      $user->save();
      return new UserResource($user);
    }
    public function setRoles($request,$user){
      $user->roles()->toggle([$request->value]);
      return new UserResource($user);
    }
    public function setDepartments($request,$user){
      $user->departments()->detach();
      $user->departments()->toggle([$request->value]);
      return new UserResource($user);
    }
    public function quotations(){
      if(Auth::user()->hasRoles(['admin','autorizador']))
        return new QuotationsCollection(Quotation::with('files')->orderBy('id','desc')->paginate(25));
      return new QuotationsCollection(Auth::user()->quotations()->with('files')->orderBy('id','desc')->paginate(25));
    }
    public function destroy($id){
      return response()->json(['delete'=>User::findOrFail($id)->delete()]);
    }
    public function items(){
      return new ItemsThroughDepartmentsCollection(Auth::user()->itemsThroughDepartmentsAssigned());

      /*
      *
      *Si no tuviera la columna cycle_id en items, utilizaria esta consulta
      */
      // return Auth::user()->departments()->with(['items'=>function($query){
      //
      //     $query->whereHas('budget',function (Builder $query) { // si tiene la relacion i cumple con la condicion
      //       $query->where('cycle_id',session('cycle')->id);
      //     })->with(['specification']);
      //
      //   }])->get();
    }
}
