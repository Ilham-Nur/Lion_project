<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    //Halaman Login
    public function index()
    {
        return view('login/loginindex');
      
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');


        $user = DB::table('tbl_user')
        ->where('username', $username)
        ->where('password', $password)
        ->first();

        // Check if $user is empty
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 401);
        }

        if ($user->role_id === 1){
            return response()->json(['role_id' => $user->role_id, 'redirect_url' => 'admin/dashboard']);
        } else if ($user->role_id === 2) {
            return response()->json(['role_id' => $user->role_id, 'redirect_url' => 'karyawan/dashboard']);
        } else {

        }


    }
    



    public function logout()
    {
        return redirect('/');   
    }

}
