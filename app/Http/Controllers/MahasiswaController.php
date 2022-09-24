<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
  public function pageHome()
  {
    return view('mahasiswa.home');
  }

  public function pageProfile()
  {
    return view('mahasiswa.profile');
  }
}
