<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Jika ada user yang is_admin = false maka akan diredirect ke ‘/dashboard’ 
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
