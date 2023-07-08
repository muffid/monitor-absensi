<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $credentials['username'];
        $password = $credentials['password'];

  

        $user = user::where('username', $username)->first();
        if ($user) {
            if ($user->password === $password && $user->username === $username) {
                session()->put('role', $user->role);
                session()->put('id',$user->id);
                return redirect()->route('dashboard');
            }
        }
        $request->session()->flash('fail', 'Login Failed');
        return redirect()->route('welcome');
    }
}
