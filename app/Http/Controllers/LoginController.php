<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'judul' => 'Login',
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // GUARD ADMIN
        if (Auth::guard('admin')->attempt($credentials)) {

            if (Auth::guard('admin')->user()->status == 0) {
                Auth::guard('admin')->logout();
                return back()->with('error', 'User belum aktif');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('backend.beranda'));
        }

        return back()->with('error', 'Login Gagal');
    }

    public function logoutBackend(Request $request)
    {
        // logout ADMIN saja
        Auth::guard('admin')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('backend.login')
            ->with('success', 'Logout admin berhasil');
    }
}
