<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => 'Kode captcha tidak sesuai, silakan coba lagi.',
        ]);

        $role = Role::where('name', 'masyarakat')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        Auth::login($user);

        logActivity('Registrasi akun', 'Autentikasi', 'User baru "'. $user->name .'" (' . $user->email . ') mendaftar.', $user->id);

        return redirect()->route('masyarakat.dashboard');
    }
}
