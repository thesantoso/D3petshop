<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MemberProfile;

class RegisterController extends Controller
{
    public function form(Request $request)
    {
        return view('front.pages.register.form');
    }

    public function submit(Request $request)
    {
        // Validasi inputan
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        // Set data user
        $user = new User;
        $user->type = User::TYPE_MEMBER;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        // Set data member profile
        $profile = new MemberProfile;
        $profile->user_id = $user->user_id;
        $profile->phone = $request->get('phone');
        $profile->birth_date = $request->get('birth_date');
        $profile->gender = $request->get('gender');
        $profile->save();

        // Langsung loginin
        auth()->login($user);

        // Jika dispesifikasikan mau redirect kemana
        $redirect = $request->get('redirect');
        if ($redirect) {
            // Redirect kesana
            return redirect($redirect);
        }

        // Kalau nggak, redirect ke halaman akun
        return redirect('/account');
    }
}
