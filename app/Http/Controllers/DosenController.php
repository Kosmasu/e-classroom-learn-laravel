<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\PushoverHandler;

class DosenController extends Controller
{
  public function pageHome()
  {
    $currentUser = Session::get('currentUser') ?? null;
    if (!$currentUser) {
      return redirect()->route('auth.login');
    }
    $listPeriode = Session::get('listPeriode') ?? [];
    $listMataKuliah = Session::get('listMataKuliah');
    $listPeriode = Session::get('listPeriode');
    $listKelasDosen = [];
    foreach (Session::get('listKelas') ?? [] as $item) {
      if ($item['dosen'] == $currentUser['username']) {
        foreach ($listMataKuliah as $item2) { if ($item2['kode'] == $item['mata_kuliah']) $mataKuliah = $item2['nama']; }
        foreach ($listPeriode as $item2) { if ($item2['id'] == $item['periode']) $periode = $item2["tahun_awal"] . '/' . $item2["tahun_akhir"]; }
        $listKelasDosen[] = $item;
      }
    }
    return view('dosen.home', compact('listPeriode', 'listKelasDosen'));
  }

  public function pageProfile()
  {
    $currentUser = Session::get('currentUser');
    return view('dosen.profile', compact('currentUser'));
  }

  public function gantiProfile(Request $request) {
    $listDosen = Session::get('listDosen') ?? [];
    $currentUser = Session::get('currentUser') ?? null;
    if (!$currentUser) {
      redirect()->route('auth.login');
    }
    $response = [
      'status' => 'failed',
      'message' => 'Gagal!',
    ];
    if ($request->submit) {
      $isUsernameUnique = true;
      foreach ($listDosen as $item) {
        if ($item['username'] == $currentUser['username'] && $item != $currentUser) {
          $isUsernameUnique = false; break;
        }
      }
      if (
        $request->username == "" ||
        $request->email == "" ||
        $request->nomor_telepon == "" ||
        $request->password == "" ||
        $request->confirm_password == ""
      ) {
        $response = [
          'status' => 'failed',
          'message' => 'Isi semua field!'
        ];
      }
      else if ($request->password != $request->confirm_password) {
        $response = [
          'status' => 'failed',
          'message' => 'Password dan confirm password tidak sama!'
        ];
      }
      else if (!$isUsernameUnique) {
        $response = [
          'status' => 'failed',
          'message' => 'Username tidak unique!'
        ];
      }
      else {
        foreach ($listDosen as $i => $value) {
          if ($value['username'] == $currentUser['username']) {
            $currentUser['email'] = $request->email;
            $currentUser['nomor_telepon'] = $request->nomor_telepon;
            $currentUser['password'] = $request->password;
            $currentUser['username'] = $request->username;
            $listDosen[$i] = $currentUser;
          }
        }
        Session::put('listDosen', $listDosen);
        Session::put('currentUser', $currentUser);
        $response = [
          'status' => 'success',
          'message' => 'Berhasil edit profile!'
        ];
      }
    }
    return redirect()->route('dosen.profile')->with('response', $response);
  }

  public function pageKelas(Request $request, $kode_periode = null) {
    $currentUser = Session::get('currentUser') ?? null;
    $listPeriode = Session::get('listPeriode') ?? [];
    $listMataKuliah = Session::get('listMataKuliah');
    $listPeriode = Session::get('listPeriode');
    // dd($kode_periode);
    if (!$kode_periode) {
      foreach ($listPeriode as $periode) {
        if ($periode['status']) $kode_periode = $periode['id'];
      }
    }
    if (!$currentUser) {
      return redirect()->route('auth.login');
    }
    $listKelasDosen = [];
    foreach (Session::get('listKelas') ?? [] as $item) {
      if ($item['dosen'] == $currentUser['username'] && $item['periode'] == $kode_periode) {
        foreach ($listMataKuliah as $item2) {
          if ($item2['kode'] == $item['mata_kuliah'])
          $item['mata_kuliah'] = $item2['nama'];
            // $mataKuliah = $item2['nama'];
        }
        foreach ($listPeriode as $item2) {
          if ($item2['id'] == $item['periode'])
          $item['periode'] = $item2["tahun_awal"] . '/' . $item2["tahun_akhir"];
          // $periode = $item2["tahun_awal"] . '/' . $item2["tahun_akhir"];
        }
        $listKelasDosen[] = $item;
      }
    }
    return view('dosen.kelas', compact('listPeriode', 'listKelasDosen', 'kode_periode'));
  }

  public function gantiPeriodeKelas(Request $request) {
    if ($request->kode_periode) {
      return redirect()->route('dosen.kelas', ["kode_periode" => $request->kode_periode]);
    }
    return redirect()->route('dosen.kelas');
  }
}
