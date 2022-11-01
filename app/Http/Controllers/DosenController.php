<?php

namespace App\Http\Controllers;

use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use App\Rules\UsernameDosenUnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\PushoverHandler;

class DosenController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user == null || $user->role == "dosen" || $user->role == "mahasiswa") {
      return redirect()->route('auth.login');
    }
    return false;
  }

  public function pageHome() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
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

  public function pageProfile() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $currentUser = Session::get('currentUser');
    return view('dosen.profile', compact('currentUser'));
  }

  public function gantiProfile(Request $request) {

    $request->validate(
      [
        "username" => ["required", "alpha_dash", new UsernameDosenUnik, "min:5", "max:10"],
        "password" => ["required", "min:6", "max:12", "confirmed", new NoSpasi, new PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername($request->username)],
        "email" => ["required", "email"],
        "nomor_telepon" => ["required", "digits_between:10,12", new NomorTeleponUnik],
      ]
    );

    $listDosen = Session::get('listDosen') ?? [];
    $currentUser = Session::get('currentUser') ?? null;
    if (!$currentUser) {
      redirect()->route('auth.login');
    }
    $response = [
      'status' => 'failed',
      'message' => 'Gagal!',
    ];
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
    return redirect()->route('dosen.profile')->with('response', $response);
  }

  public function pageKelas(Request $request, $kode_periode = null) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $currentUser = Session::get('currentUser') ?? null;
    $listPeriode = Session::get('listPeriode') ?? [];
    $listMataKuliah = Session::get('listMataKuliah');
    $listPeriode = Session::get('listPeriode', []);
    $listKelas = Session::get('listKelas', []);
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

  public function pageKelasDetail($id) {
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
    return view('dosen.kelasDetail', compact('kelas', 'id'));
  }

  public function pageKelasAbsensi($id) {
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
    $listMahasiswa = [];
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $id) {
        $listMahasiswa = $value['listMahasiswa'];
        break;
      }
    }
    return view('dosen.kelasAbsensi', compact('listMahasiswa', 'kelas', 'id'));
  }

  public function pageKelasMahasiswa($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listKelas = Session::get('listKelas', []);
    $listMahasiswa = [];
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $id) {
        $listMahasiswa = $value['listMahasiswa'];
        break;
      }
    }
    return view('dosen.kelasMahasiswa', compact('listMahasiswa', 'id'));
  }

  public function doCreateAbsensi(Request $request) {
    $request->validate([
      "minggu_ke" => ["required", ],
      "materi" => ["required", ],
      "deskripsi" => ["required", ],
    ]);
    $listMahasiswaAbsensi = $request->listMahasiswa;
    foreach ($listMahasiswaAbsensi as $key => $mahasiswa) {
      if (!array_key_exists('isHadir', $mahasiswa)) {
        $listMahasiswaAbsensi[$key]['isHadir'] = false;
      }
    }
    $absensi = [
      "minggu_ke" => $request->minggu_ke,
      "materi" => $request->materi,
      "deskripsi" => $request->deskripsi,
      "listKehadiran" => $listMahasiswaAbsensi,
    ];
    $listKelas = Session::get('listKelas', []);
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $request->id) {
        $listKelas[$key]['listAbsensi'][] = $absensi;
        break;
      }
    }
    Session::put('listKelas', $listKelas);
    $response = [
      'status' => 'success',
      'message' => 'Berhasil create absensi!'
    ];
    return redirect()->route('dosen.kelas.absensi', ['id' => $request->id])->with('response', $response);
  }
}
