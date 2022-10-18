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
  public function pageLogin() {
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
      // if (
      //   $request->username == "" ||
      //   $request->password == ""
      // ) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Semua field harus terisi!";
      // }
      // else if (!$admin && !$dosen && !$mahasiswa) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Username/password salah!";
      // }
      // else {
        $response["status"] = "success";
        $response["message"] = "Berhasil Login";
        if ($request->username == "admin" && $request->password == "admin") {
          Session::put('currentUser', 'admin');
          return redirect()->route('admin.home');
        }
        else if ($dosen) {
          Session::put('currentUser', $dosen);
          return redirect()->route('dosen.home');
        }
        else { //mahasiswa
          Session::put('currentUser', $mahasiswa);
          return redirect()->route('mahasiswa.home');
        }
      // }
    }
    return redirect()->route('auth.login')->with("response", $response);
  }

  public function pageRegisterMahasiswa()
  {
    if (!Session::has('listJurusan')) {
      Session::push('listJurusan', ['id'=>'INF', 'nama'=>'S1-Informatika']);
      Session::push('listJurusan', ['id'=>'SIB', 'nama'=>'S1-Sistem Informasi Bisnis']);
      Session::push('listJurusan', ['id'=>'DKV', 'nama'=>'S1-Desain Komunikasi Visual']);
    }
    return view('auth.register.mahasiswa');
  }

  public function registerMahasiswa(Request $request)
  {
    $response = [
      "status"=>"failed",
      "message"=>""
    ];

    // $request->validate(
    //   [
    //     "username" => ["required", "min:5", "max:10", new UsernameDosenUnik, "alpha_dash"],
    //     "password" => ["required", "min:6", "max:12", "confirmed", new NoSpasi, new PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername($request->username)],
    //     "tahun_kelulusan" => ["required", "after_or_equal:1990/01/01", "before:today"],
    //     "jurusan_kelulusan" => ["required"],
    //     "nama_lengkap" => ["required"],
    //     "tanggal_lahir" => ["required", "before:21 years ago"],
    //     "email" => ["required", "email"],
    //     "nomor_telepon" => ["required", "digits_between:10,12", new NomorTeleponUnik],
    //     "konfirmasi_syarat_dan_ketentuan" => ["required"],
    //   ]
    // );

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

    if ($request->submit) {
      $isEmailUnique = true;
      $isNomorTeleponUnique = true;
      if (Session::has("listMahasiswa")) {
        foreach (Session::get("listMahasiswa") as $mahasiswa) {
          if ($request->email == $mahasiswa["email"]) $isEmailUnique = false;
          if ($request->nomor_telepon == $mahasiswa["nomor_telepon"]) $isNomorTeleponUnique = false;
        }
      }
      if (Session::has("listDosen")) {
        foreach (Session::get("listDosen") as $dosen) {
          if ($request->email == $dosen["email"]) $isEmailUnique = false;
          if ($request->nomor_telepon == $dosen["nomor_telepon"]) $isNomorTeleponUnique = false;
        }
      }
      if (
        $request->nama_lengkap == "" ||
        $request->nomor_telepon == "" ||
        $request->tahun_angkatan == "" ||
        $request->email == "" ||
        $request->jurusan == "" ||
        $request->tanggal_lahir == "" ||
        $request->konfirmasi_syarat_dan_ketentuan == ""
      ) {
        $response["status"] = "failed";
        $response["message"] = "Semua field harus terisi!";
      }
      else if (!$isEmailUnique) {
        $response["status"] = "failed";
        $response["message"] = "Email harus unik!";
      }
      else if (!$isNomorTeleponUnique) {
        $response["status"] = "failed";
        $response["message"] = "Nomor telepon harus unik!";
      }
      else {
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
        // $response["mahasiswa"] = $mahasiswa;
      }
    }
    return redirect()->route('auth.register.mahasiswa')->with("response", $response);
  }

  public function pageRegisterDosen()
  {
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

    // if ($request->submit) {
      // $isEmailUnique = true;
      // $isNomorTeleponUnique = true;
      // $isUsernameUnique = true;
      // if (Session::has("listMahasiswa")) {
      //   foreach (Session::get("listMahasiswa") as $mahasiswa) {
      //     if ($request->email == $mahasiswa["email"]) $isEmailUnique = false;
      //     if ($request->nomor_telepon == $mahasiswa["nomor_telepon"]) $isNomorTeleponUnique = false;
      //   }
      // }
      // if (Session::has("listDosen")) {
      //   foreach (Session::get("listDosen") as $dosen) {
      //     if ($request->email == $dosen["email"]) $isEmailUnique = false;
      //     if ($request->nomor_telepon == $dosen["nomor_telepon"]) $isNomorTeleponUnique = false;
      //     if ($request->username == $dosen["username"]) $isUsernameUnique = false;
      //   }
      // }
      // if (
      //   $request->username == "" ||
      //   $request->password == "" ||
      //   $request->confirm_password == "" ||
      //   $request->tahun_kelulusan == "" ||
      //   $request->jurusan_kelulusan == "" ||
      //   $request->nama_lengkap == "" ||
      //   $request->tanggal_lahir == "" ||
      //   $request->email == "" ||
      //   $request->nomor_telepon == "" ||
      //   $request->konfirmasi_syarat_dan_ketentuan == ""
      // ) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Semua field harus terisi!";
      // }
      // else if (!$isEmailUnique) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Email harus unik!";
      // }
      // else if (!$isNomorTeleponUnique) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Nomor telepon harus unik!";
      // }
      // else if (!$isUsernameUnique) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Username harus unik!";
      // }
      // else if ($request->username == "admin") {
      //   $response["status"] = "failed";
      //   $response["message"] = "Username tidak boleh admin!";
      // }
      // else if ($request->password != $request->confirm_password) {
      //   $response["status"] = "failed";
      //   $response["message"] = "Password dan confirm password harus sama!";
      // }
      // else {
        $dosen = [
          "username" => $request->username,
          "password" => $request->password,
          "tahun_kelulusan" => $request->tahun_kelulusan,
          "jurusan_kelulusan" => $request->jurusan_kelulusan,
          "nama_lengkap" => $request->nama_lengkap,
          "tanggal_lahir" => $request->tanggal_lahir,
          "email" => $request->email,
          "nomor_telepon" => $request->nomor_telepon,
        ];
        Session::push("listDosen", $dosen);
        $response["status"] = "success";
        $response["message"] = "Berhasil register";
      // }
    // }
    return redirect()->route('auth.register.dosen')->with("response", $response);
  }
}
