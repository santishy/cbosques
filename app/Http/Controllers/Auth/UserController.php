<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Quotation;
use App\Http\Resources\UserResource;
use App\Http\Resources\QuotationsCollection;
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
        'email' => ["unique:users,email,$user->id","email"]
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
    public function quotations(){
      if(Auth::user()->hasRoles(['admin','autorizador']))
        return new QuotationsCollection(Quotation::orderBy('id','desc')->paginate(25));
      return new QuotationsCollection(Auth::user()->quotations()->orderBy('id','desc')->paginate(25));
    }
    public function destroy($id){
      return response()->json(['delete'=>User::findOrFail($id)->delete()]);
    }

}
