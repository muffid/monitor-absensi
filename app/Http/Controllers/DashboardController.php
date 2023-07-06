<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
  
   public function index(){
    if(session()->has('role')){
        if(session()->get('role') === 'admin'){
            return redirect()->route('admin');
        }else{
            return redirect()->route('user');
        }
    }else{
        return redirect()->route('welcome');
    }
   }
}
