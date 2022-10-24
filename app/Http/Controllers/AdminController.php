<?php

namespace App\Http\Controllers;

use App\Rules\DosenValid;
use App\Rules\MataKuliahValid;
use App\Rules\NamaMataKuliahUnik;
use App\Rules\PeriodeValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
  private function checkLoggedInUser() {
    $user = Session::get('currentUser');
    if ($user == null || $user['role'] == "dosen" || $user['role'] == "mahasiswa") {
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
    return view('admin.dosen');
  }

  public function pageMahasiswa() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('admin.mahasiswa');
  }

  public function pageMataKuliah() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    if (!Session::has('listJurusan')) {
      Session::push('listJurusan', ['id'=>'INF', 'nama'=>'S1-Informatika']);
      Session::push('listJurusan', ['id'=>'SIB', 'nama'=>'S1-Sistem Informasi Bisnis']);
      Session::push('listJurusan', ['id'=>'DKV', 'nama'=>'S1-Desain Komunikasi Visual']);
    }
    return view('admin.matakuliah');
  }

  public function doCreateMataKuliah(Request $request) {
    $response["status"] = "failed";
    $response["message"] = "";

    $request->validate(
      [
        "nama_mata_kuliah" => ["required", new NamaMataKuliahUnik],
        "minimal_semester" => ["required", "integer", "min:1", "max:8"],
        "jurusan" => ["required", ],
      ]
    );
    $response["status"] = "success";
    $response["message"] = "Berhasil tambah mata kuliah!";
    $jurusan = null;
    foreach (Session::get('listJurusan') ?? [] as $item) {
      if ($request->jurusan == $item["id"]) {
        $jurusan = $item;
        break;
      }
    }
    $matakuliah = [
      "kode" => substr($jurusan["id"], 0, 3) . substr($request->nama_mata_kuliah, 0, 2),
      "nama" => $request->nama_mata_kuliah,
      "minimal_semester" => $request->minimal_semester,
      "jurusan_id" => $jurusan["id"],
      "sks" => $request->sks,
    ];
    Session::push('listMataKuliah', $matakuliah);
    return redirect()->route('admin.matakuliah')->with("response", $response);
  }

  public function pageEditMataKuliah($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    if (!Session::has('listJurusan')) {
      Session::push('listJurusan', ['id'=>'INF', 'nama'=>'S1-Informatika']);
      Session::push('listJurusan', ['id'=>'SIB', 'nama'=>'S1-Sistem Informasi Bisnis']);
      Session::push('listJurusan', ['id'=>'DKV', 'nama'=>'S1-Desain Komunikasi Visual']);
    }
    $mataKuliah = null;
    $listMataKuliah = Session::get('listMataKuliah') ?? [];
    foreach ($listMataKuliah as $key => $value) {
      if ($value["kode"] == $id) {
        $mataKuliah = $value;
      }
    }
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
    $response["status"] = "success";
    $response["message"] = "Berhasil edit mata kuliah!";
    $listMataKuliah = Session::get('listMataKuliah') ?? [];
    $mataKuliah = null;
    foreach ($listMataKuliah as $key => $value) {
      if ($value["kode"] == $request->id) {
        $listMataKuliah[$key]["nama"] = $request->nama_mata_kuliah;
        $listMataKuliah[$key]["minimal_semester"] = $request->minimal_semester;
        $listMataKuliah[$key]["sks"] = $request->sks;
        $mataKuliah = $value;
        break;
      }
    }
    Session::put('listMataKuliah', $listMataKuliah);
    // dd($request->all());
    return redirect()->route('admin.matakuliah')->with("response", $response);
  }

  public function pagePeriode() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('admin.periode');
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

        $id = 0;
        if (Session::has('listPeriode')) {
          $id = count(Session::get('listPeriode'));
        }

        $periode = [
          'id' => $id,
          'tahun_awal' => $request->tahun_awal,
          'tahun_akhir' => $request->tahun_akhir,
          'status' => false,
        ];
        Session::push('listPeriode', $periode);
      }
    }
    return redirect()->route('admin.periode')->with("response", $response);
  }

  public function doSetPeriode(Request $request) {
    // dd($request->all());
    $response["status"] = "failed";
    $response["message"] = "";
    $listPeriode = Session::get('listPeriode');
    for ($i = 0; $i < count($listPeriode); $i++ ) {
      $listPeriode[$i]["status"] = false;
      if ($listPeriode[$i]["id"] == $request->id && $request->status) {
        $listPeriode[$i]["status"] = true;
      }
    }
    $response["status"] = "success";
    $response["message"] = "Berhasil toggle periode!";
    Session::put('listPeriode', $listPeriode);
    return redirect()->route('admin.periode')->with("response", $response);
  }

  public function pageKelas() {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    return view('admin.kelas');
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
    $kelas = [
      "id" => count(Session::get('listKelas', [])),
      "mata_kuliah" => $request->mata_kuliah,
      "jadwal" => $request->jadwal_hari . " " . $request->jadwal_jam,
      "jadwal_hari" => $request->jadwal_hari,
      "jadwal_jam" => $request->jadwal_jam,
      "periode" => $request->periode,
      "dosen" => $request->dosen_pengajar,
      "listMahasiswa" => [],
      "listAbsensi" => [],
    ];
    Session::push('listKelas', $kelas);
    return redirect()->route('admin.kelas')->with("response", $response);
  }

  public function pageEditKelas($id) {
    if ($this->checkLoggedInUser()) {
      return $this->checkLoggedInUser();
    }
    $listKelas = Session::get('listKelas', []);
    $kelas = null;
    foreach ($listKelas as $key => $value) {
      if ($value["id"] == $id) {
        $kelas = $value;
      }
    }
    if ($kelas == null) {
      return redirect()->route('admin.kelas');
    }
    return view('admin.editKelas', compact('kelas'));
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
    $listKelas = Session::get('listKelas', []);
    foreach ($listKelas as $key => $value) {
      if ($value['id'] == $request->id) {
        $listKelas[$key]["mata_kuliah"] = $request->mata_kuliah;
        $listKelas[$key]["jadwal"] = $request->jadwal_hari . " " . $request->jadwal_jam;
        $listKelas[$key]["jadwal_hari"] = $request->jadwal_hari;
        $listKelas[$key]["jadwal_jam"] = $request->jadwal_jam;
        $listKelas[$key]["periode"] = $request->periode;
      }
    }
    // $kelas = [
    //   "mata_kuliah" => $request->mata_kuliah,
    //   "jadwal" => $request->jadwal_hari . " " . $request->jadwal_jam,
    //   "periode" => $request->periode,
    //   "dosen" => $request->dosen_pengajar,
    // ];
    Session::put('listKelas', $listKelas);
    return redirect()->route('admin.kelas')->with("response", $response);
  }
}
