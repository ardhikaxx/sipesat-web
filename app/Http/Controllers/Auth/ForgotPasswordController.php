<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('sweet_error', 'Email tidak terdaftar pada sistem.');
        }

        // Simpan email ke session untuk tahap selanjutnya
        session(['reset_email' => $user->email]);
        
        return back()->with('sweet_success', 'Email ditemukan. Anda akan diarahkan ke halaman pembuatan password baru.');
    }

    public function showResetForm(Request $request)
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');
        
        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            
            // Hapus session setelah berhasil
            session()->forget('reset_email');
            
            return redirect()->route('login')->with('success', 'Password berhasil diubah, silahkan login dengan password baru.');
        }

        return back()->with('sweet_error', 'Terjadi kesalahan saat merubah password.');
    }
}
