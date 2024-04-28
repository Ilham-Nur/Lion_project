<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpadateController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagihanController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/ceklogin', [LoginController::class, 'login'])->name('ceklogin');
Route::get('/dashboardnew', [DashboardController::class, 'index'])->name('dashboard');

//Menu Update
Route::get('/karyawan/dashboard', [UpadateController::class, 'karyawan'])->name('menukaryawan');
Route::get('/karyawan/getlistDataHarian', [UpadateController::class, 'getlistDataHarian'])->name('getlistDataHarian');

// Menu Pelanggan
Route::get('/pelanggantetap', [PelangganController::class, 'index'])->name('menupelanggan');
Route::get('/pelanggantetap/getlistpelanggan', [PelangganController::class, 'getlistPelanggan'])->name('getlistPelanggan');
Route::post('/pelanggantetap/tambahPelanggan', [PelangganController::class, 'tambahPelanggan'])->name('tambahPelanggan');
Route::post('/pelanggantetap/updatePelanggan', [PelangganController::class, 'updatePelanggan'])->name('updatePelanggan');
Route::get('/pelanggantetap/hapusPelanggan', [PelangganController::class, 'hapusPelanggan'])->name('hapusPelanggan');


//Menu User
Route::get('/user', [UserController::class, 'index'])->name('menuuser');


//Menu User
Route::get('/tagihan', [TagihanController::class, 'index'])->name('menutagihan');
Route::get('/tagihan/getlisttagihan', [TagihanController::class, 'getlistTagihan'])->name('getlistTagihan');


// Route::get('/dashboard',  [DashboardController::class, 'index'])->middleware('role:admin');

