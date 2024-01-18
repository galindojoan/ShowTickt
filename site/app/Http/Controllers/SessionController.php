<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
  public function out(){
    session()->forget('key');
    return redirect('login');
  }
  public function profile(){
    return view('perfil');
  }
  public function in(){
    return view('login');
  }

  public function SessionController(Request $request){
    $session=$request->input('sesionOpcion');
    switch ($session){
      case "profile":
        $this->profile();
        return view('perfil');
        break;
    case "closeSession":
        $this->out();
        return redirect('login');
        break;
    case "openSession":
        $this->in();
        return redirect('login');
        break;
    }
  }
}
