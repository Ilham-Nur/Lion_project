<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpadateController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagihanController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/ceklogin', [LoginController::class, 'login'])->name('ceklogin');

// Menu Dashboard
Route::get('/dashboardnew', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/carddata', [DashboardController::class, 'getDataCard'])->name('getDataCard');
Route::get('/dashboard/chardata', [DashboardController::class, 'getchartdata'])->name('getchartdata');

//Menu Update
Route::get('/karyawan/dashboard', [UpadateController::class, 'karyawan'])->name('menukaryawan');
Route::get('insertDataHarian', [UpadateController::class, 'insertDataHarian'])->name('insertDataHarian');
Route::get('/karyawan/getlistDataHarian', [UpadateController::class, 'getlistDataHarian'])->name('getlistDataHarian');
Route::get('/karyawan/listpelanggan', [UpadateController::class, 'listPelangganFrom'])->name('listPelangganFrom');
Route::post('/karyawan/tambahdata', [UpadateController::class, 'tambahData'])->name('tambahData');
Route::post('/karyawan/updatedata', [UpadateController::class, 'updateData'])->name('updateData');
Route::get('/karyawan/hapusData', [UpadateController::class, 'hapusData'])->name('hapusData');

// Menu Pelanggan
Route::get('/pelanggantetap', [PelangganController::class, 'index'])->name('menupelanggan');
Route::get('/pelanggantetap/getlistpelanggan', [PelangganController::class, 'getlistPelanggan'])->name('getlistPelanggan');
Route::post('/pelanggantetap/tambahPelanggan', [PelangganController::class, 'tambahPelanggan'])->name('tambahPelanggan');
Route::post('/pelanggantetap/updatePelanggan', [PelangganController::class, 'updatePelanggan'])->name('updatePelanggan');
Route::get('/pelanggantetap/hapusPelanggan', [PelangganController::class, 'hapusPelanggan'])->name('hapusPelanggan');


//Menu User
Route::get('/user', [UserController::class, 'index'])->name('menuuser');
Route::get('/listPelanggan', [UserController::class, 'listPelanggan'])->name('listPelanggan');


//Menu User
Route::get('/tagihan', [TagihanController::class, 'index'])->name('menutagihan');
Route::get('/exportTagihan', [TagihanController::class, 'exportTagihan'])->name('exportTagihan');
Route::get('/tagihan/getlisttagihan', [TagihanController::class, 'getlistTagihan'])->name('getlistTagihan');
