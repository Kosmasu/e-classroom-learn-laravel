<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function pageHome()
  {
    return view('admin.home');
  }

  public function pageDosen()
  {
    return view('admin.dosen');
  }
  public function pageMahasiswa()
  {

    return view('admin.mahasiswa');
  }
}
