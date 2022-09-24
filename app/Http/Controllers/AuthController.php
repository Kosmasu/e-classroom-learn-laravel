<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function pageLogin()
    {
      return view('login');
    }
}
