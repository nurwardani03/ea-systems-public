<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bagian; // model Bagian tetap
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebUserLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('web_user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegisterForm()
    {
        // Ambil semua data bagian (dari tabel 'bagian')
        $bagians = Bagian::all();
        return view('web_user.register', compact('bagians'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'bagian_id'  => 'required|integer|exists:bagian,id',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'       => $request->name,
            'bagian_id'  => intval($request->bagian_id), // konversi ke integer jaga-jaga
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
