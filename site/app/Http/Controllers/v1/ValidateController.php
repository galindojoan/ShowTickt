<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
  public function index(Request $request)
  {
    dd($request->input());
    return route('iniciarSesion');
  }
}
