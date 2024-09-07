<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $title = 'login';
        return view('auth.login', compact('title'));
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid email or password']);
        }
        return redirect()->route('dashboard');
    }

    public function register()
    {
        $title = 'register';
        return view('auth.register', compact('title'));
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users',
            'jabatan' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'role' => 'pegawai',
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
