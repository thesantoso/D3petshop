<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function form(Request $request)
    {
        return view('admin.pages.login.form');
    }

    public function submit(Request $request)
    {
        // Validasi inputan
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil nilai email dan password
        $email = $request->get('email');
        $password = $request->get('password');

        // Ambil data user dari database
        $user = User::where('email', $email)->first();

        // Cek keberadaan user
        if (!$user) {
            // User dengan email $email tidak ditemukan
            return back()->with('danger', 'Email atau password tidak cocok.')->withInput();
        }

        // Cek password
        if (!Hash::check($password, $user->password)) {
            // Password salah
            return back()->with('danger', 'Email atau password tidak cocok.')->withInput();
        }

        // Cek status user
        if ($user->status == User::STATUS_BLOCKED) {
            // Akun diblokir
            return back()->with('danger', 'Akun anda diblokir.')->withInput();
        } elseif ($user->status == User::STATUS_PENDING) {
            // Akun masih pending
            return back()->with('danger', 'Akun anda belum aktif.')->withInput();
        }

        // Cek tipe user
        if ($user->type != 'admin') {
            return back()->with('danger', 'Akun anda tidak diizinkan mengakses halaman Admin.')->withInput();
        }

        // Daftarkan session auth user
        auth()->login($user);

        // Jika dispesifikasikan mau redirect kemana
        $redirect = $request->get('redirect');
        if ($redirect) {
            // Redirect kesana
            return redirect($redirect);
        }

        // Kalau nggak, redirect ke halaman akun
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return redirect()->intended('/');
    }
}
