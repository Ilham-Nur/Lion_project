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

        return response()->json(['redirect_url' => '/dashboardnew']);
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