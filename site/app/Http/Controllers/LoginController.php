<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        }else{
            $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'password' => 'required',
        ]);

        $userName = $request->input('usuario');
        $password = $request->input('password');
        if ($validator->fails()) {
            return redirect('login')->withErrors(array('error' =>'Rellene todos los campos'));
        }
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
            return redirect('login')->withErrors(array('error' =>'Credenciales Incorrectas'));
        }}
    }
}
