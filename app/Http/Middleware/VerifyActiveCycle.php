<?php

namespace App\Http\Middleware;

use Closure;
use App\Cycle;

class VerifyActiveCycle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //protected $except = ['api/cycles/*','api/cycles'];
    public function handle($request, Closure $next)
    {
        if(!isset(session('cycle')->id))
        {
          session(['cycle'=>Cycle::getActiveCycle()]);
          //return response()->json(['data'=>[],'error' => 'No existe el ciclo']);
        }

         return $next($request);
    }
}
