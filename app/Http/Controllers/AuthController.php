<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    public function __construct(){
      $this->middleware('jwt')->except('login');
    }

    public function login(Request $request){
      $credentials = request(['email', 'password']);
      if (!$token = auth()->attempt($credentials)) {
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
