<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function __construct(){
      $this->middleware('jwt')->except('login');
    }
    public function register(Request $request){

       Validator::make($request->all(), [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
      ],[
        'required' => 'El campo es requerido',
        'unique' => 'Este registro ya existe en la base de datos',
        'string' => 'Todos los campos deben ser cadenas de texto',
        'confirmed' => 'La contraseña no coincide',
        'min' => 'La contraseña debe tener como minímo ocho caracteres'
      ])->validate();
      return User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
      ]);

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
      return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
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
