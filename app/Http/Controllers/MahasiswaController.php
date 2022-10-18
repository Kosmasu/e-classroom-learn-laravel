<?php

namespace App\Http\Controllers;

use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
  public function pageHome()
  {
    return view('mahasiswa.home');
  }

  public function pageProfile()
  {
    $currentUser = Session::get('currentUser');
    return view('mahasiswa.profile', compact('currentUser'));
  }

  public function gantiProfile(Request $request) {
    $request->validate(
      [
        "password" => ["required", "min:6", "max:12", "confirmed", new NoSpasi],
        "email" => ["required", "email"],
        "nomor_telepon" => ["required", "digits_between:10,12", new NomorTeleponUnik],
      ]
    );
    $listMahasiswa = Session::get('listMahasiswa') ?? [];
    $currentUser = Session::get('currentUser') ?? null;
    if (!$currentUser) {
      redirect()->route('auth.login');
    }
    $response = [
      'status' => 'failed',
      'message' => 'Gagal!',
    ];

    // if ($request->submit) {
    //   if (
    //     $request->email == "" ||
    //     $request->nomor_telepon == "" ||
    //     $request->password == "" ||
    //     $request->confirm_password == ""
    //   ) {
    //     $response = [
    //       'status' => 'failed',
    //       'message' => 'Isi semua field!'
    //     ];
    //   }
    //   else if ($request->password != $request->confirm_password) {
    //     $response = [
    //       'status' => 'failed',
    //       'message' => 'Password dan confirm password tidak sama!'
    //     ];
    //   }
    //   else {
        foreach ($listMahasiswa as $i => $value) {
          if ($value['nrp'] == $currentUser['nrp']) {
            $currentUser['email'] = $request->email;
            $currentUser['nomor_telepon'] = $request->nomor_telepon;
            $currentUser['password'] = $request->password;
            $listMahasiswa[$i] = $currentUser;
          }
        }
        Session::put('listMahasiswa', $listMahasiswa);
        Session::put('currentUser', $currentUser);
        $response = [
          'status' => 'success',
          'message' => 'Berhasil edit profile!'
        ];
      // }
    // }
    return redirect()->route('mahasiswa.profile')->with('response', $response);
  }

  public function pageKelas(Request $request, $kode_periode = null) {
    $currentUser = Session::get('currentUser') ?? null;
    $listPeriode = Session::get('listPeriode') ?? [];
    $listMataKuliah = Session::get('listMataKuliah') ?? [];
    $listDosen = Session::get('listDosen') ?? [];

    // dd($kode_periode);
    if (!$kode_periode) {
      foreach ($listPeriode as $periode) {
        if ($periode['status']) $kode_periode = $periode['id'];
      }
    }
    if (!$currentUser) {
      return redirect()->route('auth.login');
    }
    $listKelasMahasiswa = [];
    foreach (Session::get('listKelas') ?? [] as $item) {
      if (substr($item['mata_kuliah'], 0, 3) == $currentUser['jurusan'] && $item['periode'] == $kode_periode) {
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
        foreach ($listDosen as $item2) {
          if ($item2['username'] == $item['dosen'])
            $item['dosen'] = $item2['nama_lengkap'];
            // $periode = $item2["tahun_awal"] . '/' . $item2["tahun_akhir"];
        }
        $listKelasMahasiswa[] = $item;
      }
    }
    return view('mahasiswa.kelas', compact('listPeriode', 'listKelasMahasiswa', 'kode_periode'));
  }

  public function gantiPeriodeKelas(Request $request) {
    if ($request->kode_periode) {
      return redirect()->route('mahasiswa.kelas', ["kode_periode" => $request->kode_periode]);
    }
    return redirect()->route('mahasiswa.kelas');
  }
}
