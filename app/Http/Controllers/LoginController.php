<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    
    public function user()
    {
        return view('users.index');
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);
    
        $field = 'nik'; 
    
        $user = null;
        if ($field === 'nik') {
            $user = Auth::attempt(['nik' => $credentials['nik'], 'password' => $credentials['password']]);
        }
    
        if ($user) {
            if (auth()->user()->is_admin) {

                return redirect()->route('users.index')->with('loginSuccess', 'Login berhasil!');
            } else {

                Auth::logout();
                return redirect('https://sites.google.com/view/tanamann5/home?authuser=0');
            }
        }
    
        return back()->with('loginError', 'Login Gagal!');
    }
    
    
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/login');
    }
}