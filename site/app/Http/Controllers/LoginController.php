<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $user = DB::table('users')->where('username', $userName)->first();
        $tipus = DB::table('users')->where('username', $userName)->value('tipus');

        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('key', $userName);
            $request->session()->put('user_id', $user->id); // Almacenar el ID del usuario en la sesión
            if ($tipus == 'Promotor') {
                return view('homePromotor');
            }else{
                return view('taullerAdministracio');
            }
        } else {
            return redirect('login')->withErrors(array('msg' =>'Credenciales Incorrectas'));
        }}
    }
}
