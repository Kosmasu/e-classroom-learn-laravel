<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Rules\LoginTerdaftar;
use App\Rules\MinVowel;
use App\Rules\MinWord;
use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use App\Rules\UsernameDosenUnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class AuthController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user != null) {
      if ($user->role == "admin") {
        return redirect()->route('admin.home');
      }
      else if ($user->role == "mahasiswa") {
        return redirect()->route('mahasiswa.home');
      }
      else if ($user->role == "dosen") {
        return redirect()->route('dosen.home');
      }
    }
    return false;
  }

  public function logout() {
    Session::forget('currentUser');
    return redirect()->route('auth.login');
  }

  public function pageLogin() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('auth.login');
  }

  public function login(Request $request) {
    $response = [
      "status"=>"failed",
      "message"=>"anda kena ban"
    ];

    $request->validate(
      [
        "username" => ["required", new LoginTerdaftar($request)],
        "password" => ["required"],
      ]
    );

    if ($request->submit) {
      $dosen = null;
      $mahasiswa = null;
      $admin = $request->username == "admin" && $request->password == "admin";
      $listMahasiswa = DB::table('mahasiswa')->get();
      $listDosen = DB::table('dosen')->get();
      foreach ($listMahasiswa as $item) {
        if ($request->username == $item->mhs_nrp && $request->password == $item->mhs_password) {
          $mahasiswa = $item; break;
        }
      }
      foreach ($listDosen as $item) {
        if ($request->username == $item->dsn_username && $request->password == $item->dsn_password) {
          $dosen = $item; break;
        }
      }
      if ($dosen && $dosen->dsn_status_ban == 1) {
        return redirect()->route('auth.login')->with("response", $response);
      }
      if ($mahasiswa && $mahasiswa->mhs_status_ban == 1) {
        return redirect()->route('auth.login')->with("response", $response);
      }
      $response["status"] = "success";
      $response["message"] = "Berhasil Login";
      if ($request->username == "admin" && $request->password == "admin") {
        $admin = new stdClass();
        $admin->role = "admin";
        Session::put('currentUser', $admin);
        return redirect()->route('admin.home');
      }
      else if ($dosen) {
        $dosen->role = "dosen";
        Session::put('currentUser', $dosen);
        return redirect()->route('dosen.home');
      }
      else if ($mahasiswa) { //mahasiswa
        $mahasiswa->role = "mahasiswa";
        Session::put('currentUser', $mahasiswa);
        return redirect()->route('mahasiswa.home');
      }
    }
    return redirect()->route('auth.login')->with("response", $response);
  }

  public function pageRegisterMahasiswa() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listJurusan = DB::table('jurusan')->get();
    return view('auth.register.mahasiswa', compact('listJurusan'));
  }

  public function registerMahasiswa(Request $request) {
    $response = [
      "status"=>"failed",
      "message"=>""
    ];

    $request->validate(
      [
        "nama_lengkap" => ["required", new MinWord(2), new MinVowel(3)],
        "nomor_telepon" => ["required", "digits_between:10,12", new NomorTeleponUnik],
        "tahun_angkatan" => ["required",],
        "email" => ["required", "email"],
        "jurusan" => ["required",],
        "tanggal_lahir" => ["required","before:17 years ago"],
        "konfirmasi_syarat_dan_ketentuan" => ["required",],
      ]
    );
    $nomorUrut = 1;
    $nrp = "";

    //php nda jelas, harus dipisah, nda bisa inline current(explode())
    $tahunAngkatan = explode("-", $request->tahun_angkatan);
    $tahunAngkatan = current($tahunAngkatan);

    $tahunNrp = substr($tahunAngkatan, 0, 1) . substr($tahunAngkatan, 2, 2);

    $password = explode(" ",$request->nama_lengkap);
    $password = end($password) . substr($tahunAngkatan, 0, 2);

    $listMahasiswa = DB::table('mahasiswa')->get();
    foreach ($listMahasiswa as $mahasiswa) {
      if($tahunNrp == substr($mahasiswa->mhs_nrp, 0, 3)) {
        $nomorUrut++;
      }
    }
    if ($nomorUrut <= 9) $nrp = $tahunNrp . "00" . $nomorUrut;
    else if ($nomorUrut <= 99) $nrp = $tahunNrp . "0" . $nomorUrut;
    // else  $nrp = $tahunNrp . $nomorUrut;
    // $result = DB::table('mahasiswa')->insert(
    //   [
    //     "mhs_nrp" => $nrp,
    //     "mhs_password" => $password,
    //     "mhs_nama" => $request->nama_lengkap,
    //     "mhs_nomor_telepon" => $request->nomor_telepon,
    //     "mhs_tahun_angkatan" => $request->tahun_angkatan,
    //     "mhs_email" => $request->email,
    //     "mhs_jurusan" => $request->jurusan,
    //     "mhs_tanggal_lahir" => $request->tanggal_lahir,
    //   ]
    // );
    $result = Mahasiswa::insert(
      [
        "mhs_nrp" => $nrp,
        "mhs_password" => $password,
        "mhs_nama" => $request->nama_lengkap,
        "mhs_nomor_telepon" => $request->nomor_telepon,
        "mhs_tahun_angkatan" => $request->tahun_angkatan,
        "mhs_email" => $request->email,
        "jur_id" => $request->jurusan,
        "mhs_tanggal_lahir" => $request->tanggal_lahir,
      ]
    );
    if ($result) {
      $response["status"] = "success";
      $response["message"] = "Berhasil register";
    }
    return redirect()->route('auth.register.mahasiswa')->with("response", $response);
  }

  public function pageRegisterDosen() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('auth.register.dosen');
  }

  public function registerDosen(Request $request)
  {
    $response = [
      "status"=>"failed",
      "message"=>""
    ];

    $request->validate(
      [
        "username" => ["required", "min:5", "max:10", new UsernameDosenUnik, "alpha_dash"],
        "password" => ["required", "min:6", "max:12", "confirmed", new NoSpasi, new PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername($request->username)],
        "tahun_kelulusan" => ["required", "after_or_equal:1990/01/01", "before:today"],
        "jurusan_kelulusan" => ["required"],
        "nama_lengkap" => ["required"],
        "tanggal_lahir" => ["required", "before:21 years ago"],
        "email" => ["required", "email"],
        "nomor_telepon" => ["required", "digits_between:10,12", new NomorTeleponUnik],
        "konfirmasi_syarat_dan_ketentuan" => ["required"],
      ]
    );
    // $result = DB::table('dosen')->insert(
    //   [
    //     "dsn_username" => $request->username,
    //     "dsn_password" => $request->password,
    //     "dsn_tahun_kelulusan" => $request->tahun_kelulusan,
    //     "dsn_jurusan_kelulusan" => $request->jurusan_kelulusan,
    //     "dsn_nama" => $request->nama_lengkap,
    //     "dsn_tanggal_lahir" => $request->tanggal_lahir,
    //     "dsn_email" => $request->email,
    //     "dsn_nomor_telepon" => $request->nomor_telepon,
    //   ]
    // );
    $result = Dosen::insert(
      [
        "dsn_username" => $request->username,
        "dsn_password" => $request->password,
        "dsn_tahun_kelulusan" => $request->tahun_kelulusan,
        "dsn_jurusan_kelulusan" => $request->jurusan_kelulusan,
        "dsn_nama" => $request->nama_lengkap,
        "dsn_tanggal_lahir" => $request->tanggal_lahir,
        "dsn_email" => $request->email,
        "dsn_nomor_telepon" => $request->nomor_telepon,
      ]
    );
    if ($result) {
      $response["status"] = "success";
      $response["message"] = "Berhasil register";
    }
    return redirect()->route('auth.register.dosen')->with("response", $response);
  }
}
