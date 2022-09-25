<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function pageLogin()
  {
    return view('auth.login');
  }

  public function pageRegisterMahasiswa()
  {
    return view('auth.register.mahasiswa');
  }

  public function pageRegisterDosen()
  {
    return view('auth.register.dosen');
  }
}
