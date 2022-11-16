<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('layout.guest');
});

Route::get('/flush', function () {
  Session::flush();
});

Route::get('/allSession', function () {
  dd(Session::all());
});

Route::get('/addSession', function () {
  Session::push('listMahasiswa', [
    "nrp" => "220001",
    "password" => "a",
    "nama_lengkap" => "Kenny Kenny",
    "nomor_telepon" => "000000000001",
    "tahun_angkatan" => "2020",
    "email" => "kenny@gmail.com",
    "jurusan" => "INF",
    "tanggal_lahir" => "2022-01-01",
  ]);
  Session::push('listDosen', [
    "username" => 'dosen',
    "password" => 'dosen',
    "tahun_kelulusan" => '2022-01-01',
    "jurusan_kelulusan" => 'S1INF',
    "nama_lengkap" => 'Mikhael Setiawan',
    "tanggal_lahir" => '2022-01-01',
    "email" => 'mimi@gmail.com',
    "nomor_telepon" => '000000000002',
  ]);
});

Route::get('/coba-session', function() {
  Session::push('listMahasiswa', [
    "nrp" => "220002",
    "password" => "a",
    "nama_lengkap" => "Mahasiswa 2",
    "nomor_telepon" => "000000000001",
    "tahun_angkatan" => "2020",
    "email" => "kenny@gmail.com",
    "jurusan" => "INF",
    "tanggal_lahir" => "2022-01-01",
  ]);
  Session::push('listMahasiswa', [
    "nrp" => "220003",
    "password" => "a",
    "nama_lengkap" => "Mahasiswa 3",
    "nomor_telepon" => "000000000001",
    "tahun_angkatan" => "2020",
    "email" => "kenny@gmail.com",
    "jurusan" => "INF",
    "tanggal_lahir" => "2022-01-01",
  ]);
});
/*
-	Halaman Login (/login)
-	Halaman Register dosen (/register/dosen)
-	Halaman Register mahasiswa (/register)
-	Halaman Home Admin (/admin)
-	Halaman List dosen (/admin/dosen/)
-	Halaman List mahasiswa (/admin/mahasiswa)
-	Halaman Home untuk dosen (/dosen)
-	Halaman Profile untuk dosen (/dosen/profile)
-	Halaman Home untuk mahasiswa (/mahasiswa)
-	Halaman Profile untuk mahasiswa (/mahasiswa/profile)
*/

Route::get('/login', [AuthController::class, 'pageLogin'])->name('auth.login');
Route::post('/do-login', [AuthController::class, 'login'])->name('auth.doLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/', function () {
  return redirect('/login');
});

Route::prefix('/register')->group(function () {
  Route::get('/', [AuthController::class, 'pageRegisterMahasiswa'])->name('auth.register.mahasiswa') ;
  Route::post('/do-mahasiswa', [AuthController::class, 'registerMahasiswa'])->name('auth.register.doMahasiswa') ;
  Route::get('/dosen', [AuthController::class, 'pageRegisterDosen'])->name('auth.register.dosen');
  Route::post('/do-dosen', [AuthController::class, 'registerDosen'])->name('auth.register.doDosen');
});

Route::prefix('/admin')->group(function () {
  Route::get('/',[AdminController::class, 'pageHome'])->name('admin.home');
  Route::get('/dosen', [AdminController::class, 'pageDosen'])->name('admin.dosen');
  Route::get('/mahasiswa', [AdminController::class, 'pageMahasiswa'])->name('admin.mahasiswa');
  Route::get('/mata-kuliah', [AdminController::class, 'pageMataKuliah'])->name('admin.matakuliah');
  Route::post('/do-create-mata-kuliah', [AdminController::class, 'doCreateMataKuliah'])->name('admin.doCreateMataKuliah');
  Route::get('/edit-mata-kuliah/{id}', [AdminController::class, 'pageEditMataKuliah'])->name('admin.editMataKuliah');
  Route::post('/do-edit-mata-kuliah', [AdminController::class, 'doEditMataKuliah'])->name('admin.doEditMataKuliah');
  Route::get('/periode', [AdminController::class, 'pagePeriode'])->name('admin.periode');
  Route::post('/do-create-periode', [AdminController::class, 'doCreatePeriode'])->name('admin.doCreatePeriode');
  Route::get('/do-set-periode', [AdminController::class, 'doSetPeriode'])->name('admin.doSetPeriode');
  Route::get('/kelas', [AdminController::class, 'pageKelas'])->name('admin.kelas');
  Route::post('/do-create-kelas', [AdminController::class, 'doCreateKelas'])->name('admin.doCreateKelas');
  Route::get('/edit-kelas/{id}', [AdminController::class, 'pageEditKelas'])->name('admin.editKelas');
  Route::post('/do-edit-kelas', [AdminController::class, 'doEditKelas'])->name('admin.doEditKelas');
  Route::post('/do-delete-kelas', [AdminController::class, 'doDeleteKelas'])->name('admin.doDeleteKelas');
});

Route::prefix('/dosen')->group(function () {
  Route::get('/', [DosenController::class, 'pageHome'])->name('dosen.home');
  Route::get('/profile', [DosenController::class, 'pageProfile'])->name('dosen.profile');
  Route::post('/gantiProfile', [DosenController::class, 'gantiProfile'])->name('dosen.gantiProfile');
  Route::prefix('/kelas')->group(function () {
    Route::get('/{kode_periode?}', [DosenController::class, 'pageKelas'])->name('dosen.kelas');
    Route::get('/detail/{id}', [DosenController::class, 'pageKelasDetail'])->name('dosen.kelas.detail');
    Route::get('/detail/{id}/absensi', [DosenController::class, 'pageKelasAbsensi'])->name('dosen.kelas.absensi');
    Route::post('/detail/{id}/do-create-absensi', [DosenController::class, 'doCreateAbsensi'])->name('dosen.kelas.doCreateAbsensi');
    Route::get('/detail/{id}/absensi/{absensi_id}/edit', [DosenController::class, 'pageKelasEditAbsensi'])->name('dosen.kelas.editAbsensi');
    Route::post('/detail/{id}/do-edit-absensi', [DosenController::class, 'doEditAbsensi'])->name('dosen.kelas.doEditAbsensi');
    Route::post('/detail/{id}/do-delete-absensi', [DosenController::class, 'doDeleteAbsensi'])->name('dosen.kelas.doDeleteAbsensi');
    Route::get('/detail/{id}/mahasiswa', [DosenController::class, 'pageKelasMahasiswa'])->name('dosen.kelas.mahasiswa');
    Route::get('/detail/{id}/pengumuman', [DosenController::class, 'pageKelasPengumuman'])->name('dosen.kelas.pengumuman');
    Route::post('/detail/{id}/do-create-pengumuman', [DosenController::class, 'doCreatePengumuman'])->name('dosen.kelas.doCreatePengumuman');
    Route::get('/detail/{id}/module', [DosenController::class, 'pageKelasModule'])->name('dosen.kelas.module');
    Route::post('/detail/{id}/do-create-module', [DosenController::class, 'doCreateModule'])->name('dosen.kelas.doCreateModule');
    Route::post('/detail/{id}/do-selesaikan-module', [DosenController::class, 'doSelesaikanModule'])->name('dosen.kelas.doSelesaikanModule');
    Route::get('/detail/{id}/module/{mod_id}', [DosenController::class, 'pageKelasDetailModule'])->name('dosen.kelas.detailModule');
    Route::post('/detail/{id}/grade-module', [DosenController::class, 'doGradeModule'])->name('dosen.kelas.doGradeModule');
  });
  Route::get('/ganti-periode', [DosenController::class, 'gantiPeriodeKelas'])->name('dosen.gantiPeriode');
});

Route::prefix('/mahasiswa')->group(function () {
  Route::get('/', [MahasiswaController::class, 'pageHome'])->name('mahasiswa.home');
  Route::get('/profile', [MahasiswaController::class, 'pageProfile'])->name('mahasiswa.profile');
  Route::post('/gantiProfile', [MahasiswaController::class, 'gantiProfile'])->name('mahasiswa.gantiProfile');
  Route::get('/kelas/{kode_periode?}', [MahasiswaController::class, 'pageKelas'])->name('mahasiswa.kelas');

  Route::prefix('/my-kelas')->group(function() {
    Route::get('/', [MahasiswaController::class, 'pageMyKelas'])->name('mahasiswa.myKelas');
    Route::get('/{id}', [MahasiswaController::class, 'pageMyKelasDetail'])->name('mahasiswa.myKelas.detail');
    Route::get('/{id}/absensi', [MahasiswaController::class, 'pageMyKelasAbsensi'])->name('mahasiswa.myKelas.absensi');
    Route::get('/{id}/konfirmasi-leave', [MahasiswaController::class, 'pageMyKelasKonfirmasiLeave'])->name('mahasiswa.myKelas.konfirmasiLeave');
    Route::get('/{id}/module', [MahasiswaController::class, 'pageMyKelasModule'])->name('mahasiswa.myKelas.module');
    Route::get('/{id}/pageKumpulModule/{mod_id}', [MahasiswaController::class, 'pageMyKelasKumpulModule'])->name('mahasiswa.myKelas.kumpulModule');
    Route::post('/{id}/doKumpulModule', [MahasiswaController::class, 'pageMyKelasDoKumpulModule'])->name('mahasiswa.myKelas.doKumpulModule');
    Route::post('/do-leave', [MahasiswaController::class, 'doLeaveKelas'])->name('mahasiswa.myKelas.doLeave');
  });
  Route::get('/join-kelas', [MahasiswaController::class, 'pageJoinKelas'])->name('mahasiswa.joinKelas');
  Route::post('/do-join-kelas', [MahasiswaController::class, 'doJoinKelas'])->name('mahasiswa.doJoinKelas');
  Route::get('/ganti-periode', [MahasiswaController::class, 'gantiPeriodeKelas'])->name('mahasiswa.gantiPeriode');
});
