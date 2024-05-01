<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    public function index()
    {
        if (!session()->has('loggedInUser')) {
            return view('login/loginindex');
        } else {
            return redirect('/dashboardnew');
        }
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('tbl_user')
        ->where('username', $username)
        ->where('password', $password)
        ->first();

        if (!$user) {
            return response()->json(['message' => 'Data not found'], 401);
        }

        $request->session()->put('loggedInUser', [
            'username' => $username,
        ]);

        if (DB::table('tbl_role')->where('id', DB::table('tbl_user')->where('username', session('loggedInUser')['username'])->select('role_id')->value('role_id'))->select('role')->value('role') == "Owner") {
            return response()->json(['redirect_url' => '/dashboardnew']);
        } else {
            return response()->json(['redirect_url' => '/karyawan/dashboard']);
        }
    }

    public function logout()
    {
        if (session()->has('loggedInUser')) {
            session()->pull('loggedInUser');
            Auth::logout();
            return redirect('/');
        }
    }
}