<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiMahasiswa;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MahasiswaModule;
use App\Models\Module;
use App\Models\Pengumuman;
use App\Rules\NomorTeleponUnik;
use App\Rules\NoSpasi;
use App\Rules\PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername;
use App\Rules\UsernameDosenUnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\PushoverHandler;

class DosenController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user == null || $user->role == "admin" || $user->role == "mahasiswa") {
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
    return view('dosen.home');
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

    $listDosen = DB::table('dosen')->get();
    $currentUser = Session::get('currentUser') ?? null;
    if (!$currentUser) {
      redirect()->route('auth.login');
    }
    $response = [
      'status' => 'failed',
      'message' => 'Gagal!',
    ];
    // foreach ($listDosen as $i => $value) {
    //   if ($value['username'] == $currentUser['username']) {
    //     $currentUser['email'] = $request->email;
    //     $currentUser['nomor_telepon'] = $request->nomor_telepon;
    //     $currentUser['password'] = $request->password;
    //     $currentUser['username'] = $request->username;
    //     $listDosen[$i] = $currentUser;
    //   }
    // }
    // Session::put('listDosen', $listDosen);
    // Session::put('currentUser', $currentUser);
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
    $listPeriode = DB::table('periode')->get();
    $currentUser = Session::get('currentUser') ?? null;
    if (!$kode_periode) {
      $kode_periode = DB::table('periode')->where('per_status', '=', true)->first();
      $kode_periode = $kode_periode->per_id;
    }
    if (!$currentUser) {
      return redirect()->route('auth.login');
    }
    $listKelasDosen = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->where('kelas.dsn_username', '=', $currentUser->dsn_username)
      ->where('periode.per_id', '=', $kode_periode)
      ->get();
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
    $kelas = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->where('kel_id', '=', $id)
      ->first();
    return view('dosen.kelasDetail', compact('kelas', 'id'));
  }

  public function pageKelasAbsensi($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listMahasiswa = DB::table('kelasmahasiswa')
      ->join('mahasiswa', 'kelasmahasiswa.mhs_nrp', '=', 'mahasiswa.mhs_nrp')
      ->where('kelasmahasiswa.kel_id', '=', $id)
      ->get();
    $listAbsensi = DB::table('absensi')
      ->where('kel_id', '=', $id)
      ->get();
    $kelas = DB::table('kelas')->where('kel_id', '=', $id)->first();
    return view('dosen.kelasAbsensi', compact('listMahasiswa', 'listAbsensi', 'kelas', 'id'));
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
    Absensi::insert([
      "abs_minggu_ke" => $request->minggu_ke,
      "abs_materi" => $request->materi,
      "abs_deskripsi" => $request->deskripsi,
      "kel_id" => $request->id,
    ]);
    $abs_id = DB::table('absensi')->orderBy('abs_id', 'desc')->select('abs_id')->first()->abs_id;

    foreach ($listMahasiswaAbsensi as $key => $value) {
      if ($value["isHadir"] == "true") {
        $temp = 1;
      }
      else {
        $temp = 0;
      }
      AbsensiMahasiswa::insert([
        "abs_id" => $abs_id,
        "mhs_nrp" => $value["nrp"],
        "abs_mhs_is_hadir" => $temp,
      ]);
    }
    $response = [
      'status' => 'success',
      'message' => 'Berhasil create absensi!'
    ];
    return redirect()->route('dosen.kelas.absensi', ['id' => $request->id])->with('response', $response);
  }

  public function pageKelasEditAbsensi($id, $absensi_id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $absensi = DB::table('absensi')->where('abs_id', '=', $absensi_id)->first();
    $listMahasiswa = DB::table('absensimahasiswa')
      ->join('mahasiswa', 'mahasiswa.mhs_nrp', '=', 'absensimahasiswa.mhs_nrp')
      ->where('absensimahasiswa.abs_id', '=', $absensi_id)
      ->get();

    return view('dosen.kelasEditAbsensi', compact('id', 'absensi_id', 'absensi', 'listMahasiswa'));
  }

  public function doEditAbsensi(Request $request) {
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
    Absensi::find($request->absensi_id)->update([
      "abs_minggu_ke" => $request->minggu_ke,
      "abs_materi" => $request->materi,
      "abs_deskripsi" => $request->deskripsi,
    ]);
    $abs_id = DB::table('absensi')->orderBy('abs_id', 'desc')->select('abs_id')->first()->abs_id;
    foreach ($listMahasiswaAbsensi as $key => $value) {
      if ($value["isHadir"] == "true") {
        $temp = 1;
      }
      else {
        $temp = 0;
      }
      AbsensiMahasiswa::find($value['abs_mhs_id'])->update([
        "abs_id" => $abs_id,
        "mhs_nrp" => $value["nrp"],
        "abs_mhs_is_hadir" => $temp,
      ]);
    }
    $response = [
      'status' => 'success',
      'message' => 'Berhasil edit absensi!'
    ];
    return redirect()->route('dosen.kelas.absensi', ['id' => $request->id])->with('response', $response);
  }

  public function doDeleteAbsensi(Request $request) {
    AbsensiMahasiswa::where('abs_id', '=', $request->abs_id)->delete();
    $result = Absensi::where('abs_id', '=', $request->abs_id)->delete();
    if ($result) {
      $response = [
        'status' => 'success',
        'message' => 'Berhasil delete absensi!'
      ];
    }
    else {
      $response = [
        'status' => 'failed',
        'message' => 'gagal delete absensi!'
      ];
    }
    return redirect()->back()->with('response', $response);
  }

  public function pageKelasMahasiswa($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listMahasiswa = DB::table('kelasmahasiswa')
      ->join('mahasiswa', 'kelasmahasiswa.mhs_nrp', '=', 'mahasiswa.mhs_nrp')
      ->where('kelasmahasiswa.kel_id', '=', $id)
      ->get();
      // dd($listMahasiswa);
    return view('dosen.kelasMahasiswa', compact('listMahasiswa', 'id'));
  }

  public function pageKelasPengumuman(Request $request, $id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    // $listPengumuman = DB::table('pengumuman')->where('kel_id', '');
    return view('dosen.kelasPengumuman', compact('id'));
  }

  public function doCreatePengumuman(Request $request) {
    $request->validate([
      "deskripsi" => ["required", ],
    ]);
    $result = Pengumuman::insert([
      "kel_id" => $request->id,
      "pen_deskripsi" => $request->deskripsi,
      "pen_link_penting" => $request->link_penting,
    ]);
    if ($result) {
      $response = [
        'status' => 'success',
        'message' => 'Berhasil create pengumuman!'
      ];
    }
    else {
      $response = [
        'status' => 'failed',
        'message' => 'gagal create pengumuman!'
      ];
    }
    return redirect()->back()->with('response', $response);
  }

  public function pageKelasModule(Request $request, $id) {
    // dd($id);
    $listModule = Kelas::find($id)->Module;
    foreach ($listModule as $key => $value) {
      if ($value->mod_status == 1) {
        $value->mod_status = "Aktif";
      }
      else {
        $value->mod_status = "Inaktif";
      }
    }
    // dd($listModule);
    return view('dosen.kelasModule', compact('id', 'listModule'));
  }

  public function doCreateModule(Request $request) {
    $request->validate([
      "mod_nama" => ["required", ],
      "mod_jenis" => ["required", ],
      "mod_keterangan" => ["required", ],
      "mod_deadline" => ["required", ],
    ]);
    $module = new Module();
    $module->mod_nama = $request->mod_nama;
    $module->mod_jenis = $request->mod_jenis;
    $module->mod_keterangan = $request->mod_keterangan;
    $module->mod_deadline = $request->mod_deadline;
    // dump($module);
    // dd($request->mod_deadline);
    $module->kel_id = $request->id;
    $module->save();
    // $module = Module::insert([
    //   "mod_nama" => $request->mod_nama,
    //   "mod_jenis" => $request->mod_jenis,
    //   "mod_keterangan" => $request->mod_keterangan,
    //   "mod_deadline" => $request->mod_deadline,
    // ]);

    $listKelasMahasiswa = Kelas::find($request->id)->KelasMahasiswa;
    foreach ($listKelasMahasiswa as $key => $value) {
      MahasiswaModule::insert([
        "mhs_nrp" => $value->mhs_nrp,
        "mod_id" => $module->mod_id,
      ]);
    }
    $response = [
      'status' => 'success',
      'message' => 'Berhasil create module!'
    ];
    return redirect()->route('dosen.kelas.module', ['id' => $request->id])->with('response', $response);
  }

  public function doSelesaikanModule(Request $request) {
    $module = Module::find($request->mod_id);
    if ($module->mod_status == 1) {
      $module->update([
        "mod_status"=>"0"
      ]);
      $response = [
        'status' => 'success',
        'message' => 'Berhasil selesaikan module!'
      ];
    }
    else {
      $response = [
        'status' => 'failed',
        'message' => 'Module sudah inaktif!'
      ];
    }
    return redirect()->route('dosen.kelas.module', ['id' => $request->id])->with('response', $response);
  }

  public function pageKelasDetailModule($id, $mod_id) {
    $listMahasiswa = MahasiswaModule::where('mod_id', '=', $mod_id)->get();
    return view('dosen.kelasDetailModule', compact('id', 'mod_id', 'listMahasiswa'));
  }

  public function pageSearch(Request $request) {
    $q = $request->search ?? "";
    $listMahasiswa = Mahasiswa::where('mhs_nama', 'like', '%'. $q . '%')->get();
    $listDosen = Dosen::where('dsn_nama', 'like', '%'. $q . '%')->get();
    return view('dosen.search', compact('listMahasiswa', 'listDosen'));
  }

  public function pageDetailMahasiswa($id) {
    $mahasiswa = Mahasiswa::find($id)->attributesToArray();
    return view('dosen.detailMahasiswa', compact('mahasiswa'));
  }

  public function pageDetailDosen($id) {
    $dosen = Dosen::find($id)->attributesToArray();
    return view('dosen.detailDosen', compact('dosen'));
  }
}
