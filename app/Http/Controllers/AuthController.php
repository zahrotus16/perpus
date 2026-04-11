<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status === 'inactive') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi admin.']);
            }

            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'member_id' => 'required|string|unique:users,member_id',
            'phone'     => 'required|string|regex:/^[0-9]+$/|max:20',
            'gender'    => 'required|in:L,P',
            'address'   => 'required|string',
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'member_id' => $request->member_id,
            'phone'     => $request->phone,
            'gender'    => $request->gender,
            'address'   => $request->address,
            'password'  => Hash::make($request->password),
            'role'      => 'anggota',
            'status'    => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->isPetugas()) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'kepala') {
            return redirect()->intended(route('kepala.dashboard'));
        } else {
            return redirect()->intended(route('user.dashboard'));
        }
    }
}
