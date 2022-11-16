<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\MahasiswaModule;
use App\Models\Module;
use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class MahasiswaController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user == null || $user->role == "admin" || $user->role == "dosen") {
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
    // $listMahasiswa = Session::get('listMahasiswa') ?? [];
    // $currentUser = Session::get('currentUser') ?? null;
    // if (!$currentUser) {
    //   redirect()->route('auth.login');
    // }
    // $response = [
    //   'status' => 'failed',
    //   'message' => 'Gagal!',
    // ];
    // foreach ($listMahasiswa as $i => $value) {
    //   if ($value['nrp'] == $currentUser['nrp']) {
    //     $currentUser['email'] = $request->email;
    //     $currentUser['nomor_telepon'] = $request->nomor_telepon;
    //     $currentUser['password'] = $request->password;
    //     $listMahasiswa[$i] = $currentUser;
    //   }
    // }
    // Session::put('listMahasiswa', $listMahasiswa);
    // Session::put('currentUser', $currentUser);
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
    $listPeriode = DB::table('periode')->get();

    if (!$kode_periode) {
      $kode_periode = DB::table('periode')->where('per_status', '=', true)->first();
      $kode_periode = $kode_periode->per_id;
    }
    if (!$currentUser) {
      return redirect()->route('auth.login');
    }
    $listKelasMahasiswa = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->where('periode.per_id', '=', $kode_periode)
      ->get();
    ;
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
    // $listKelas = Session::get('listKelas', []);
    // $listKelasJurusan = [];
    $user = Session::get('currentUser');
    // foreach ($listKelas as $key => $value) {
    //   $jurusan_id = substr($value['mata_kuliah'], 0, 3);
    //   if ($jurusan_id == $user['jurusan']) {
    //     if (count($value['listMahasiswa']) == 0) $value["joined"] = false;
    //     foreach ($value['listMahasiswa'] as $mahasiswa) {
    //       if ($mahasiswa['nrp'] == $user['nrp']) {
    //         $value["joined"] = true;
    //       }
    //       else {
    //         $value["joined"] = false;
    //       }
    //     }
    //     $listKelasJurusan[] = $value;
    //   }
    // }
    $listKelas = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      // ->groupBy('kelas.kel_id')
      ->get();
    // $listKelasMahasiswa = DB::table('kelasmahasiswa')
    //   ->where('mhs_nrp', '=', $user->mhs_nrp)
    //   ->get();
    // $listKelas = [];
    // foreach ($listKelasJurusan as $kelasJurusan) {
    //   foreach ($listKelasMahasiswa as $kelasMahasiswa) {
    //     if ($kelasMahasiswa->kel_id == $kelasJurusan->kel_id) {
    //       $listKelas[] = $kelasJurusan;
    //     }
    //   }
    // }
    // dd($listKelasJurusan);
    return view('mahasiswa.joinKelas', compact('listKelas'));
  }

  public function doJoinKelas(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "anda sudah join kelas ini";
    $user = Session::get('currentUser', []);
    $isSudahJoin = DB::table('kelasmahasiswa')
      ->where('kel_id', '=', $request->id)
      ->where('mhs_nrp', '=', $user->mhs_nrp)
      ->first();
    // dd($isSudahJoin);
    if ($isSudahJoin != null) {
      if ($isSudahJoin->kel_mhs_status == 0) {
        $response["status"] = "failed";
        $response["message"] = "anda sudah leave dari kelas ini";
      }
    }
    else {
      $response["status"] = "success";
      $response["message"] = "berhasil join kelas";
      KelasMahasiswa::insert([
        "kel_id" => $request->id,
        "mhs_nrp" => $user->mhs_nrp
      ]);
    }
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
    $listMyKelas = DB::table('kelas')
      ->join('kelasmahasiswa', 'kelas.kel_id', '=', 'kelasmahasiswa.kel_id')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->where('kelasmahasiswa.mhs_nrp', '=', $user->mhs_nrp)
      ->where('kelasmahasiswa.kel_mhs_status', '=', '1')
      ->get()
    ;
    // dd($listMyKelas);
    return view('mahasiswa.myKelas', compact('listMyKelas'));
  }

  public function pageMyKelasDetail($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $kelas = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->where('kel_id', '=', $id)->first();
    $listAbsensi = DB::table('absensi')
      ->where('kel_id', '=', $id)
      ->get();
    $listPengumuman = DB::table('pengumuman')
      ->where('kel_id','=', $id)
      ->get();
    $listFeed = [];
    foreach ($listAbsensi as $key => $value) {
      $feed = new stdClass();
      $feed->title = "Absensi";
      $feed->isi = "$value->abs_materi - $value->abs_deskripsi - $value->abs_minggu_ke";
      $listFeed[] = $feed;
    }
    foreach ($listPengumuman as $key => $value) {
      $feed = new stdClass();
      $feed->title = "Pengumuman";
      $feed->isi = "$value->pen_deskripsi - $value->pen_link_penting";
      $listFeed[] = $feed;
    }
    return view('mahasiswa.myKelasDetail', compact('kelas', 'id', 'listFeed'));
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
    foreach ($listAbsensi as $key => $absensi) {
      foreach ($absensi['listKehadiran'] as $kehadiran) {
        if ($kehadiran['nrp'] == $user['nrp']) {
          $listAbsensi[$key]['isHadir'] = $kehadiran['isHadir'];
        }
      }
    }
    $listAbsensi = DB::table('absensimahasiswa')
      ->join('absensi', 'absensimahasiswa.abs_id', '=', 'absensi.abs_id')
      ->where('absensimahasiswa.mhs_nrp', '=', $user->mhs_nrp)
      ->get()
    ;
    return view('mahasiswa.myKelasAbsensi', compact('listAbsensi', 'id'));
  }

  public function pageMyKelasKonfirmasiLeave($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('mahasiswa.myKelasKonfirmasiLeave', compact('id'));
  }

  public function doLeaveKelas(Request $request) {
    $user = Session::get('currentUser');
    $result = KelasMahasiswa::where('kel_id', '=', $request->id)
      ->where('mhs_nrp', '=', $user->mhs_nrp)
      ->update([
      "kel_mhs_status" => 0
    ]);
    // dd($result);
    $response["status"] = "success";
    $response["message"] = "berhasil leave kelas";
    return redirect()->route('mahasiswa.joinKelas')->with('response', $response);
  }

  public function pageMyKelasModule($id) {
    $listModule = Kelas::find($id)->Module;
    foreach ($listModule as $key => $value) {
      if ($value->mod_status == 1) {
        $value->mod_status = "Aktif";
      }
      else {
        $value->mod_status = "Inaktif";
      }
    }
    return view('mahasiswa.myKelasModule', compact('id', 'listModule'));
  }

  public function pageMyKelasKumpulModule($id, $mod_id) {
    $user = Session::get('currentUser');
    $module = Module::find($mod_id);

    $dateNow = now();
    $dateDeadline = new DateTime($module->mod_deadline);
    // dd($dateNow, $dateDeadline, $dateNow > $dateDeadline, $dateNow < $dateDeadline);
    if ($dateNow > $dateDeadline) {
      $response["status"] = "failed";
      $response["message"] = "anda telat!";
      $module->mod_status = 0;
      $module->save();
      return back()->with('response', $response);
    }

    $jawaban = MahasiswaModule::where('mod_id', '=', $mod_id)
      ->where('mhs_nrp', '=', $user->mhs_nrp)
      ->first()->mhs_mod_jawaban;
    return view('mahasiswa.myKelasKumpulModule', compact('module', 'id', 'mod_id', 'jawaban'));
  }

  public function pageMyKelasDoKumpulModule(Request $request) {
    $user = Session::get('currentUser');
    MahasiswaModule::where('mod_id', '=', $request->mod_id)
      ->where('mhs_nrp', '=', $user->mhs_nrp)
      ->update([
        "mhs_mod_jawaban" => $request->jawaban
      ]);
    $response["status"] = "success";
    $response["message"] = "berhasil kumpul";
    return back()->with('response', $response);
  }
}
