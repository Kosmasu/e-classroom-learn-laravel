<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
  return redirect('/login'); //redirect
});

Route::prefix('/register')->group(function () {
  Route::get('/', function () {})->name('auth.register.mahasiswa') ; //register mahasiswa
  Route::get('/dosen', function () {})->name('auth.register.dosen'); //register dosen
});

Route::prefix('/admin')->group(function () {
  Route::get('/', function () {})->name('admin.home'); //home admin
  Route::get('/dosen', function () {})->name('admin.dosen'); //list dosen
  Route::get('/mahasiswa', function () {})->name('admin.mahasiswa'); //list mahasiswa
});

Route::prefix('/dosen')->group(function () {
  Route::get('/', [DosenController::class, 'pageHome'])->name('dosen.home'); //home dosen
  Route::get('/profile', [DosenController::class, 'pageProfile'])->name('dosen.profile'); //profile dosen
});

Route::prefix('/mahasiswa')->group(function () {
  Route::get('/', [MahasiswaController::class, 'pageHome'])->name('mahasiswa.home'); //home mahasiswa
  Route::get('/profile', [MahasiswaController::class, 'pageProfile'])->name('mahasiswa.profile'); //profile mahasiswa
});
