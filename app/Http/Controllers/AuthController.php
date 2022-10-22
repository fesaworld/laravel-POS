<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ];

        $messages = [
            'email.required'    => 'E-mail wajib diisi',
            'email.email'       => 'E-mail wajib nu baleg',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal mengandung 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if($user && $user->deleted_at !== null) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Username tidak ditemukan']);
        }

        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        if($request->has('remember')) {
            $remember = true;
        } else {
            $remember = false;
        }

        Auth::attempt($data, $remember);


        if(Auth::check()) {
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->withErrors(['error' => 'Email / Password salah'])->withInput($request->all);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to('/');
    }

    public function view()
    {
        return view('form.auth');
    }
}
