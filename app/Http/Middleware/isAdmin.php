<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('role')){
            if ($request->session()->get('role') === 'admin') {
                return $next($request);        
            } else {
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->route('welcome');
        }
    }
}
