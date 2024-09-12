<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
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
            'login' => 'required', // Bisa email atau nip
            'password' => 'required',
        ]);

        // Cek apakah input login berupa email atau nip
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        // Ambil hanya login dan password
        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password'),
        ];
        // dd($credentials);
        try {
            //code...
            if (!Auth::attempt($credentials)) {
                return back()->withErrors(['login' => 'Invalid email, NIP, or password']);
            }

            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }

        // Coba login
    }

    public function register()
    {
        $title = 'register';
        $divisi = Divisi::get();
        return view('auth.register', compact('title', 'divisi'));
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users',
            'jabatan' => 'required',
            'pangkat' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'divisi_id' => 'required',
        ]);
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'role' => 'pegawai',
            'divisi_id' => $request->divisi_id,
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
