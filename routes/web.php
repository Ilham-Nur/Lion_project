<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

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
Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
Route::get('/karyawan/dashboard', [DashboardController::class, 'karyawan']);


// Route::get('/dashboard',  [DashboardController::class, 'index'])->middleware('role:admin');

