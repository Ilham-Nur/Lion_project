<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //Halaman Dashboard
    public function index()
    {
        return view('Dashboard/indexDashboard');
      
    }
    public function admin()
    {
        return view('admin/dashboard');
    }
    public function karyawan()
    {
        return view('karyawan/dashboard');
      
    }

}
