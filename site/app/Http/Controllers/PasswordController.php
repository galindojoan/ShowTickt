<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoRecuperar;
use Illuminate\Support\Facades\URL;

class PasswordController extends Controller
{
    public function passwordPage(){
        return view('recuperar');
    }
    public function pagePassword(){
        return view('cambiarPassword');
    }
    // Función que recoje el mail escrito, confirma la existencia de esté en la bd y si existe enviará 
    //el correo a dicho mail con una url que redirige al usuario a la pantalla cambiar contraseña
    public function enviarCorreo(Request $request){
        $email = $request->input('email');
        $user = DB::table('users')->where('email',$email)->value('email');

        if ($email == $user) {
            $username = DB::table('users')->where('email', $email)->value('name');
            $url = URL::temporarySignedRoute('cambiarPassword', now()->addMinutes(30),['user' => 1]);
            $data = ['username' => $username, 'urlGenerada' => $url];
            Mail::to($email)->send(new CorreoRecuperar($data));
            return view('login');
        }else{
            return redirect('recuperar')->withErrors(array('msg' =>'Credenciales Incorrectas'));
        }
    }
    public function cambiarPassword(Request $request){
        $password = $request->input('contrasenya');
        if (strlen($password)>8 && preg_match('/[A-Z]/', $password) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
            
        }else{
            return redirect('cambiarPassword')->withErrors(array('msg' => 'La contraseña neceesita al menos 8 caracteres, mayusculas y minusculas, y un simbolo'));
        }
    }
}
