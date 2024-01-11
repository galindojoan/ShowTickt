<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
  public function SessionController(Request $request){
    var_dump ($request->input('sesion'));
  }
    public function out(){
      session()->forget('key');
      session_destroy();
      return view('login');
    }
    public function profile(){
      return view('perfil');
    }
    public function in(){
      return view('login');
    }
}
