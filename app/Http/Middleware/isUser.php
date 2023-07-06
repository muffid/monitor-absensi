<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isUser
{
  
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('role')){
            if ($request->session()->get('role') === 'user') {
                return $next($request);        
            } else {
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->route('welcome');
        }
    }
}
