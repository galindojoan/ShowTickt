<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function iniciarSesion(Request $request)
    {
        if(session('key')){
            return view('homePromotor');
        }
        else{$this->validate($request, [
            'usuario' => 'required',
            'password' => 'required',
        ]);

        $userName = $request->input('usuario');
        $password = $request->input('password');

        $user = DB::table('users')->where('name', $userName)->first();

        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('key', $userName);
            $sessionValue = $request->session()->get('key');
            return view('homePromotor');
        } else {
            return back()->withInput()->withErrors(['usuario' => 'Credenciales inválidas']);
        }}
    }
}
