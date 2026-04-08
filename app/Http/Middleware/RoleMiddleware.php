<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
if(!$request->user()){
return response()->json(['messege'=>'login dulu ya'],401);
}
if($request->user()->role !== $role){
return response()->json(['messege'=>'akses di tolak']);
}
        return $next($request);
    }
}
