<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Periode;
use App\Rules\DosenValid;
use App\Rules\MataKuliahValid;
use App\Rules\NamaMataKuliahUnik;
use App\Rules\PeriodeValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
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
    return view('admin.home');
  }

  public function pageDosen() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listDosen = Dosen::all();
    return view('admin.dosen', compact('listDosen'));
  }

  public function pageMahasiswa() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listMahasiswa = Mahasiswa::all();
    return view('admin.mahasiswa', compact('listMahasiswa'));
  }

  public function doBan(Request $request) {
    $status = $request->submit == "Unban" ? 0 : 1;
    if ($request->role == "dosen") {
      $temp = Dosen::find($request->id)->update([
        "dsn_status_ban"=>$status
      ]);
    }
    else {
      Mahasiswa::find($request->id)->update([
        "dsn_status_ban"=>$status
      ]);
    }
    return back();
  }

  public function pageMataKuliah() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listJurusan = DB::table('jurusan')->get();
    $listMataKuliah = DB::table('matakuliah')
      ->join('jurusan', 'matakuliah.jur_id', '=', 'jurusan.jur_id')
      ->get();
    return view('admin.matakuliah', compact('listJurusan', 'listMataKuliah'));
  }

  public function doCreateMataKuliah(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    $request->validate(
      [
        "nama_mata_kuliah" => ["required", new NamaMataKuliahUnik],
        "minimal_semester" => ["required", "integer", "min:1", "max:8"],
        "jurusan" => ["required", ],
        "sks" => ["required", "integer", "min:2"],
      ]
    );
    $response["status"] = "success";
    $response["message"] = "Berhasil tambah mata kuliah!";
    $jurusan = DB::table('jurusan')
      ->where('jur_id', '=', $request->jurusan)
      ->first();
    MataKuliah::insert(
      [
        "matkul_id" => substr($jurusan->jur_id, 0, 3) . strtoupper(substr($request->nama_mata_kuliah, 0, 2)),
        "matkul_nama" => $request->nama_mata_kuliah,
        "matkul_minimal_semester" => $request->minimal_semester,
        "jur_id" => $jurusan->jur_id,
        "matkul_sks" => $request->sks,
      ]
    );
    return redirect()->route('admin.matakuliah')->with("response", $response);
  }

  public function pageEditMataKuliah($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $mataKuliah = DB::table('matakuliah')
      ->where('matkul_id', '=', $id)
      ->first();
    if ($mataKuliah == null) {
      return redirect()->route('admin.matakuliah');
    }
    return view('admin.editMatakuliah', compact('mataKuliah'));
  }

  public function doEditMataKuliah(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    $request->validate(
      [
        "nama_mata_kuliah" => ["required", new NamaMataKuliahUnik],
        "minimal_semester" => ["required", "integer", "min:1", "max:8"],
        "sks" => ["required", "integer", "min:2"],
      ]
    );
    $result = MataKuliah::find($request->id)->update(
      [
        "matkul_nama" => $request->nama_mata_kuliah,
        "matkul_minimal_semester" => $request->minimal_semester,
        "matkul_sks" => $request->sks,
      ]
    );
    if ($result) {
      $response["status"] = "success";
      $response["message"] = "Berhasil edit mata kuliah!";
    }
    return redirect()->route('admin.matakuliah')->with("response", $response);
  }

  public function pagePeriode() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listPeriode = DB::table('periode')->get();
    return view('admin.periode', compact('listPeriode'));
  }

  public function doCreatePeriode(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";
    if ($request->submit) {
      if (
        $request->tahun_awal == "" ||
        $request->tahun_akhir == ""
      ) {
        $response["status"] = "failed";
        $response["message"] = "Semua field harus terisi!";
      }
      else {
        $response["status"] = "success";
        $response["message"] = "Berhasil tambah periode!";
        Periode::insert([
          'per_tahun_awal' => $request->tahun_awal,
          'per_tahun_akhir' => $request->tahun_akhir,
          'per_status' => false,
        ]);
      }
    }
    return redirect()->route('admin.periode')->with("response", $response);
  }

  public function doSetPeriode(Request $request) {
    // dd($request->all());
    $response["status"] = "failed";
    $response["message"] = "gagal";
    $per_status = DB::table('periode')->where('per_id', '=', $request->id)->first();
    $per_status = !$per_status->per_status;
    $result = DB::table('periode')
      ->where('per_status', '=', 1)
      ->update([
        "per_status" => 0
      ]);
    $result = Periode::find($request->id)->update(['per_status' => $per_status]);
    // dd($result)
    $response["status"] = "success";
    $response["message"] = "Berhasil toggle periode!";
    return redirect()->route('admin.periode')->with("response", $response);
  }

  public function pageKelas() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listMataKuliah = DB::table('matakuliah')->get();
    $listPeriode = DB::table('periode')->get();
    $listDosen = DB::table('dosen')->get();
    $listKelas = DB::table('kelas')
      ->join('matakuliah', 'kelas.matkul_id', '=', 'matakuliah.matkul_id')
      ->join('periode', 'kelas.per_id', '=', 'periode.per_id')
      ->join('dosen', 'kelas.dsn_username', '=', 'dosen.dsn_username')
      ->get();
    return view('admin.kelas', compact('listMataKuliah', 'listPeriode', 'listDosen', 'listKelas'));
  }

  public function doCreateKelas(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    $request->validate(
      [
        "mata_kuliah" => ["required", new MataKuliahValid],
        "jadwal_jam" => ["required", ],
        "jadwal_hari" => ["required", ],
        "periode" => ["required", new PeriodeValid],
      ]
    );
    $response["status"] = "success";
    $response["message"] = "Berhasil tambah kelas!";
    Kelas::insert([
      "matkul_id" => $request->mata_kuliah,
      "kel_jadwal" => $request->jadwal_hari . " " . $request->jadwal_jam,
      "per_id" => $request->periode,
      "dsn_username" => $request->dosen_pengajar,
    ]);
    return redirect()->route('admin.kelas')->with("response", $response);
  }

  public function pageEditKelas($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $kelas = DB::table('kelas')->where('kel_id', '=', $id)->first();
    $kelas->jadwal_hari = explode(" ", $kelas->kel_jadwal)[0];
    $kelas->jadwal_jam = explode(" ", $kelas->kel_jadwal)[1];
    if ($kelas == null) {
      return redirect()->route('admin.kelas');
    }
    $listMataKuliah = DB::table('matakuliah')->get();
    $listPeriode = DB::table('periode')->get();
    return view('admin.editKelas', compact('kelas', 'listMataKuliah', 'listPeriode'));
  }

  public function doEditKelas(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    $request->validate(
      [
        "mata_kuliah" => ["required", new MataKuliahValid],
        "jadwal_jam" => ["required", ],
        "jadwal_hari" => ["required", ],
        "periode" => ["required", new PeriodeValid],
      ]
    );
    $response["status"] = "success";
    $response["message"] = "Berhasil edit kelas!";
    Kelas::find($request->id)->update([
      "matkul_id" => $request->mata_kuliah,
      "kel_jadwal" => $request->jadwal_hari . " " . $request->jadwal_jam,
      "per_id" => $request->periode,
    ]);
    return redirect()->route('admin.kelas')->with("response", $response);
  }

  public function doDeleteKelas(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    // DB::table('kelas')->where('kel_id', '=', $request->id)->delete();
    Kelas::find($request->id)->delete();
    $response["status"] = "success";
    $response["message"] = "berhasil delete";
    return redirect()->back()->with('response', $response);
  }
}
