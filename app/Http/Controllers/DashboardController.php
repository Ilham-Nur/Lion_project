<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //Halaman Dashboard
    public function index()
    {
        return view('dashboard/dashboardindex');

    }


}
