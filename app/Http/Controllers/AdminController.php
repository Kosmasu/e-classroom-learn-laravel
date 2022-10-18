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
  public function pageHome() {
    return view('admin.home');
  }

  public function pageDosen() {
    return view('admin.dosen');
  }

  public function pageMahasiswa() {
    return view('admin.mahasiswa');
  }

  public function pageMataKuliah() {
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

    // if ($request->submit) {
    //   if (
    //     $request->nama_mata_kuliah == "" ||
    //     $request->minimal_semester == "" ||
    //     $request->jurusan == ""
    //   ) {
    //     $response["status"] = "failed";
    //     $response["message"] = "Semua field harus terisi!";
    //   }
    //   else {
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
        ];
        Session::push('listMataKuliah', $matakuliah);
    //   }
    // }
    return redirect()->route('admin.matakuliah')->with("response", $response);
  }

  public function pagePeriode() {
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
        "dosen_pengajar" => ["required", new DosenValid],
        "sks" => ["required", "integer", "min:2"],
      ]
    );

    // if ($request->submit) {
    //   if (
    //     $request->mata_kuliah == "" ||
    //     $request->jadwal == "" ||
    //     $request->periode == "" ||
    //     $request->dosen_pengajar == ""
    //   ) {
    //     $response["status"] = "failed";
    //     $response["message"] = "Semua field harus terisi!";
    //   }
    //   else {
        $response["status"] = "success";
        $response["message"] = "Berhasil tambah kelas!";
        $kelas = [
          "mata_kuliah" => $request->mata_kuliah,
          "jadwal" => $request->jadwal_hari . " " . $request->jadwal_jam,
          "periode" => $request->periode,
          "dosen" => $request->dosen_pengajar,
        ];
        Session::push('listKelas', $kelas);
    //   }
    // }
    return redirect()->route('admin.kelas')->with("response", $response);
  }
}
