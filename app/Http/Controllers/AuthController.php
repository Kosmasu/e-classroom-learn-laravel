<?php

namespace App\Http\Controllers;

use App\Rules\LoginTerdaftar;
use App\Rules\MinVowel;
use App\Rules\MinWord;
use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use App\Rules\UsernameDosenUnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user != null) {
      if ($user["role"] == "admin") {
        return redirect()->route('admin.home');
      }
      else if ($user["role"] == "mahasiswa") {
        return redirect()->route('mahasiswa.home');
      }
      else if ($user["role"] == "dosen") {
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
      "message"=>""
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
      if (Session::has("listMahasiswa")) {
        foreach (Session::get("listMahasiswa") as $item) {
          if ($request->username == $item["nrp"] && $request->password == $item["password"]) {
            $mahasiswa = $item; break;
          }
        }
      }
      if (Session::has("listDosen")) {
        foreach (Session::get("listDosen") as $item) {
          if ($request->username == $item["username"] && $request->password == $item["password"]) {
            $dosen = $item; break;
          }
        }
      }
      $response["status"] = "success";
      $response["message"] = "Berhasil Login";
      if ($request->username == "admin" && $request->password == "admin") {
        Session::put('currentUser', ["role"=>"admin"]);
        return redirect()->route('admin.home');
      }
      else if ($dosen) {
        $dosen["role"] = "dosen";
        Session::put('currentUser', $dosen);
        return redirect()->route('dosen.home');
      }
      else { //mahasiswa
        $mahasiswa["role"] = "mahasiswa";
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
    if (!Session::has('listJurusan')) {
      Session::push('listJurusan', ['id'=>'INF', 'nama'=>'S1-Informatika']);
      Session::push('listJurusan', ['id'=>'SIB', 'nama'=>'S1-Sistem Informasi Bisnis']);
      Session::push('listJurusan', ['id'=>'DKV', 'nama'=>'S1-Desain Komunikasi Visual']);
    }
    return view('auth.register.mahasiswa');
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

    if (Session::has('listMahasiswa')) {
      foreach (Session::get('listMahasiswa') as $mahasiswa) {
        if($tahunNrp == substr($mahasiswa["nrp"], 0, 3)) {
          $nomorUrut++;
        }
      }
    }
    if ($nomorUrut <= 9) $nrp = $tahunNrp . "00" . $nomorUrut;
    else if ($nomorUrut <= 99) $nrp = $tahunNrp . "0" . $nomorUrut;
    else  $nrp = $tahunNrp . $nomorUrut;
    $mahasiswa = [
      "nrp" => $nrp,
      "password" => $password,
      "nama_lengkap" => $request->nama_lengkap,
      "nomor_telepon" => $request->nomor_telepon,
      "tahun_angkatan" => $request->tahun_angkatan,
      "email" => $request->email,
      "jurusan" => $request->jurusan,
      "tanggal_lahir" => $request->tanggal_lahir,
    ];
    Session::push("listMahasiswa", $mahasiswa);
    $response["status"] = "success";
    $response["message"] = "Berhasil register";
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
    return redirect()->route('auth.register.dosen')->with("response", $response);
  }
}
