<?php

namespace App\Http\Controllers;

use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user == null || $user['role'] == "admin" || $user['role'] == "dosen") {
      return redirect()->route('auth.login');
    }
  }

  public function pageHome()
  {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('mahasiswa.home');
  }

  public function pageProfile()
  {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
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
    return redirect()->route('mahasiswa.profile')->with('response', $response);
  }

  public function pageKelas(Request $request, $kode_periode = null) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
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

  public function pageJoinKelas() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listKelas = Session::get('listKelas', []);
    $listKelasJurusan = [];
    $user = Session::get('currentUser');
    foreach ($listKelas as $key => $value) {
      $jurusan_id = substr($value['mata_kuliah'], 0, 3);
      if ($jurusan_id == $user['jurusan']) {
        if (count($value['listMahasiswa']) == 0) $value["joined"] = false;
        foreach ($value['listMahasiswa'] as $mahasiswa) {
          if ($mahasiswa['nrp'] == $user['nrp']) {
            $value["joined"] = true;
          }
          else {
            $value["joined"] = false;
          }
        }
        $listKelasJurusan[] = $value;
      }
    }
    return view('mahasiswa.joinKelas', compact('listKelasJurusan'));
  }

  public function doJoinKelas(Request $request) {
    $listKelas = Session::get('listKelas', []);
    $user = Session::get('currentUser', []);
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $request->id) {
        $listKelas[$key]['listMahasiswa'][] = $user;
      }
    }
    Session::put('listKelas', $listKelas);
    $response["status"] = "success";
    $response["message"] = "berhasil join kelas";
    return redirect()->route('mahasiswa.joinKelas')->with('response', $response);
  }

  public function pageMyKelas() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listMyKelas = [];
    $listKelas = Session::get('listKelas', []);
    $user = Session::get('currentUser');
    foreach ($listKelas as $keyKelas => $kelas) {
      $listMahasiswaKelas = $kelas['listMahasiswa'];
      foreach ($listMahasiswaKelas as $keyMahasiswaKelas => $mahasiswaKelas) {
        if ($mahasiswaKelas['nrp'] == $user['nrp']) {
          $listMyKelas[] = $kelas;
          break;
        }
      }
    }
    return view('mahasiswa.myKelas', compact('listMyKelas'));
  }

  public function pageMyKelasDetail($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $kelas = [];
    $listKelas = Session::get('listKelas', []);
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $id) {
        $kelas = $value;
        break;
      }
    }
    return view('mahasiswa.myKelasDetail', compact('kelas', 'id'));
  }

  public function pageMyKelasAbsensi($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $kelas = [];
    $listAbsensi = [];
    $listKelas = Session::get('listKelas', []);
    $user = Session::get('currentUser');
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $id) {
        $kelas = $value;
        $listAbsensi = $kelas['listAbsensi'];
        break;
      }
    }
    // dd($listAbsensi);
    foreach ($listAbsensi as $key => $absensi) {
      foreach ($absensi['listKehadiran'] as $kehadiran) {
        if ($kehadiran['nrp'] == $user['nrp']) {
          $listAbsensi[$key]['isHadir'] = $kehadiran['isHadir'];
        }
      }
    }
    // dd($listAbsensi);  
    return view('mahasiswa.myKelasAbsensi', compact('listAbsensi', 'id'));
  }
}
