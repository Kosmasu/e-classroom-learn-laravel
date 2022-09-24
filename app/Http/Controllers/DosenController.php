<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
  public function pageHome()
  {
    return view('dosen.home');
  }

  public function pageProfile()
  {
    return view('dosen.profile');
  }
}
