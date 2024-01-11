<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function passwordPage(){
        return view('recuperar');
    }
    public function cambiarPassword(Request $request){
        $email = $request->input('email');
        $user = DB::table('users')->where('email',$email)->first();

        if (isset($user)) {
            return view('',[$email]);
        }else{
            return redirect('recuperar')->withErrors(array('msg' =>'Credenciales Incorrectas'));
        }
    }
    public function enviarMail(){
        
    }
}
