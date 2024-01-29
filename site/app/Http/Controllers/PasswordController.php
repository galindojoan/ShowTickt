<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\CorreoRecuperar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function passwordPage(){
        return view('recuperar');
    }
    public function pagePassword(Request $request){
        if (! $request->hasValidSignature()) {
            return redirect('recuperar')->withErrors(array('error'=>'El link ha caducado, vuelva a pedirlo.'));
        }else{
            return view('cambiarPassword');
        }
    }
    // Función que recoje el mail escrito, confirma la existencia de esté en la bd y si existe enviará 
    //el correo a dicho mail con una url que redirige al usuario a la pantalla cambiar contraseña
    public function enviarCorreo(Request $request){
        $email = $request->input('email');
        $user = DB::table('users')->where('email',$email)->value('email');

        if ($email == $user) {
            try {
                $username = DB::table('users')->where('email', $email)->value('name');
                $userId = DB::table('users')->where('email', $email)->value('id');
                $url = URL::temporarySignedRoute('cambiarPassword', now()->addMinutes(env('MAIL_TIME_LIMIT')),['user' => $userId]);
                $data = ['username' => $username, 'urlGenerada' => $url];
                Mail::to($email)->send(new CorreoRecuperar($data));                
                Log::info('Mail enviado exitosamente por contraseña olvidada - Usuario: '. $username);
                return redirect('login')->withErrors(array('vali' => 'Correo enviado con éxito, revisa tu bandeja de entrada.'));
            } catch (Exception $e) {
                Log::error('Error en el envio de mail por contraseña olvidada - Usuario: '. $username .', Error:'. $e->getMessage());
            }
        }else{
            return redirect('recuperar')->withErrors(array('error' => 'No existe esa cuenta.'));
        }
    }
    public function cambiarPassword(Request $request){
        $password = $request->input('password');
        $user = $request->input('userId');
        if (strlen($password)>=8 && preg_match('/[A-Z]/', $password) && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
            try {
                User::where('id',$user)->update(array('password' => Hash::make($password)));
                Log::info('Contraseña de usuario '.$user .'cambiada correctamentea.');
                return redirect('login')->withErrors(array('vali'=>'Contraseña cambiada correctamente'));
            } catch (Exception $e) {
                Log::error('Error en la  actualización de la contraseña - Usuario: '.$user . ', Error: '.$e);
            }
        }else{
            return back()->withErrors(array('error' => 'La contraseña necesita al menos 8 caracteres, una mayuscula, y un simbolo'));
        }
    }
}
