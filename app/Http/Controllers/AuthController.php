<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RolesCollection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisteredUser;

class AuthController extends Controller
{
    public function __construct(){
      $this->middleware('jwt')->except('login');
      $this->middleware('roles:admin')->except('login');
    }
    public function register(Request $request){

       Validator::make($request->all(), [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
          'roles' => ['required'],
          'department_id' => 'required'
      ],[
        'required' => 'El campo es requerido',
        'unique' => 'Este registro ya existe en la base de datos',
        'string' => 'Todos los campos deben ser cadenas de texto',
        'confirmed' => 'La contraseña no coincide con la confirmación',
        'min' => 'La contraseña debe tener como minímo ocho caracteres'
      ])->validate();
      try{
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roles = json_decode($request->roles);
        $user->roles()->attach($roles);
        $user->departments()->attach($request->department_id);
        Notification::send($user,new RegisteredUser($request->password));
        DB::commit();
        return $user;
      }catch (\Exception $e) {
        DB::rollback();
        return $e;
      }


      //return $this->login($request);
    }
    public function login(Request $request){
      $credentials = request(['email', 'password']);
      if (!$token = auth()->setTTL(180)->attempt($credentials)) {
          return response()->json(['error' => 'Unauthorized',401]);
      }
      return $this->respondWithToken($token);
    }

    public function respondWithToken($token){
      $authUser = auth()->user();
      return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' =>$authUser,
            'roles' => $authUser->roles->pluck('name'),
        ]);
    }
    public function me(){
      try{
        return response()->json([
          auth()->user()
        ]);
      }catch(JWTException $e){
        return response()->json(['error'=>'OCURRIO UN ERROR CON LA SESION',500]);
      }

    }
    public function payload(){
      return response()->json([auth()->payload()]);
    }
    public function logout(){
      auth()->logout();
      return response()->json(['message' => 'Sesión Finalizada']);
    }
    public function refresh(){
      return response()->json([$this->respondWithToken(auth()->refresh())]);
    }
}
