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
        if(!session('cycle')->id)
          return response()->json(['data'=>[],'error' => 'No existe el ciclo']);
         return $next($request);
    }
}
