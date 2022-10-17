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
    "nomor_telepon" => "0819312341234",
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
    "nomor_telepon" => '01238941263479123',
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

Route::get('/login', [AuthController::class, 'pageLogin'])->name('auth.login'); //login
Route::post('/doLogin', [AuthController::class, 'login'])->name('auth.doLogin'); //login

Route::get('/', function () {
  return redirect('/login'); //redirect
});

Route::prefix('/register')->group(function () {
  Route::get('/', [AuthController::class, 'pageRegisterMahasiswa'])->name('auth.register.mahasiswa') ; //page register mahasiswa
  Route::post('/do-mahasiswa', [AuthController::class, 'registerMahasiswa'])->name('auth.register.doMahasiswa') ; //register mahasiswa
  Route::get('/dosen', [AuthController::class, 'pageRegisterDosen'])->name('auth.register.dosen'); //page register dosen
  Route::post('/do-dosen', [AuthController::class, 'registerDosen'])->name('auth.register.doDosen'); //register dosen
});

Route::prefix('/admin')->group(function () {
  Route::get('/',[AdminController::class, 'pageHome'])->name('admin.home'); //page home admin
  Route::get('/dosen', [AdminController::class, 'pageDosen'])->name('admin.dosen'); //page list dosen
  Route::get('/mahasiswa', [AdminController::class, 'pageMahasiswa'])->name('admin.mahasiswa'); //page list mahasiswa
  Route::get('/mata-kuliah', [AdminController::class, 'pageMataKuliah'])->name('admin.matakuliah'); //page mata kuliah
  Route::post('/do-create-mata-kuliah', [AdminController::class, 'doCreateMataKuliah'])->name('admin.doCreateMataKuliah'); //create mata kuliah
  Route::get('/periode', [AdminController::class, 'pagePeriode'])->name('admin.periode'); //page periode
  Route::post('/do-create-periode', [AdminController::class, 'doCreatePeriode'])->name('admin.doCreatePeriode'); //create mata kuliah
  Route::get('/do-set-periode', [AdminController::class, 'doSetPeriode'])->name('admin.doSetPeriode'); //create mata kuliah
  Route::get('/kelas', [AdminController::class, 'pageKelas'])->name('admin.kelas'); //page kelas
  Route::post('/do-create-kelas', [AdminController::class, 'doCreateKelas'])->name('admin.doCreateKelas'); //create kelas
});

Route::prefix('/dosen')->group(function () {
  Route::get('/', [DosenController::class, 'pageHome'])->name('dosen.home'); //page home dosen
  Route::get('/profile', [DosenController::class, 'pageProfile'])->name('dosen.profile'); //page profile dosen
  Route::post('/gantiProfile', [DosenController::class, 'gantiProfile'])->name('dosen.gantiProfile'); //page profile mahasiswa
  Route::get('/kelas/{kode_periode?}', [DosenController::class, 'pageKelas'])->name('dosen.kelas'); //page kelas dosen
  Route::get('/ganti-periode', [DosenController::class, 'gantiPeriodeKelas'])->name('dosen.gantiPeriode'); //ganti periode kelas
});

Route::prefix('/mahasiswa')->group(function () {
  Route::get('/', [MahasiswaController::class, 'pageHome'])->name('mahasiswa.home'); //page home mahasiswa
  Route::get('/profile', [MahasiswaController::class, 'pageProfile'])->name('mahasiswa.profile'); //page profile mahasiswa
  Route::post('/gantiProfile', [MahasiswaController::class, 'gantiProfile'])->name('mahasiswa.gantiProfile'); //page profile mahasiswa
  Route::get('/kelas/{kode_periode?}', [MahasiswaController::class, 'pageKelas'])->name('mahasiswa.kelas'); //page kelas mahasiswa
  Route::get('/ganti-periode', [MahasiswaController::class, 'gantiPeriodeKelas'])->name('mahasiswa.gantiPeriode'); //ganti periode kelas
});
