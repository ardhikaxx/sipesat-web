<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view("auth.login");
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
            "captcha" => ["required", "captcha"]
        ], [
            "captcha.captcha" => "Kode captcha tidak sesuai, silakan coba lagi."
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $role = auth()->user()->role->name;
            logActivity('Login berhasil', 'Autentikasi', 'User "' . auth()->user()->name . '" masuk ke sistem.');
            return redirect()->route($role . ".dashboard");
        }

        return back()->withErrors(["email" => "Kredensial tidak cocok."])->onlyInput("email");
    }

    public function logout(Request $request) {
        if (auth()->check()) {
            logActivity('Logout', 'Autentikasi', 'User "' . auth()->user()->name . '" keluar dari sistem.', auth()->id());
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}