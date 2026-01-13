<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('frontend.login');
    }

    public function showRegister()
    {
        return view('frontend.register');
    }

    public function register(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email|unique:customer,email',
        'no_hp' => 'required|string|max:20',
        'password' => 'required|confirmed|min:4',
    ]);

    $customer = Customer::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'password' => Hash::make($request->password),
        'status' => 1,
    ]);

    Auth::guard('customer')->login($customer);

    return redirect()->route('home')
        ->with('success', 'Registrasi berhasil, selamat datang!');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

            $customer = Auth::guard('customer')->user();
            $customer->update(['status' => 1]);

            return redirect()->route('home')
                ->with('success', 'Selamat datang, ' . $customer->nama . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        request()->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Berhasil logout');
    }
}
