<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        return view('user/userindex');
    }

    public function listPelanggan(Request $req)
    {
        $sessionLogin = session('loggedInUser');
        $sessionLogin['username'] ?? exit(header("Location: " . route('login')));
        $username = $sessionLogin['username'];

        try {

            DB::beginTransaction();

            $data = DB::table('tbl_tagihan')->where('tanggal', $req->tanggal)->select('pengirim')->distinct()->get();

            DB::commit();

            return response()->json($data);

        } catch (\Throwable $th) {
            return response()->json([
                'MESSAGETYPE' => 'E',
                'MESSAGE' => 'Something went wrong',
                'SERVERMSG' => dd($th->getMessage()),
            ], 400)->header(
                'Accept',
                'application/json'
            );
        }
    }

    public function getListUser(Request $request)
    {
            $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';

            $q = "SELECT
                    a.id,
                    a.username,
                    a.badge,
                    a.password,
                    b.role as role
                FROM tbl_user a
                JOIN tbl_role b ON a.role_id = b.id
                WHERE UPPER(username) LIKE UPPER('$txSearch')
                OR UPPER(badge) LIKE UPPER('$txSearch')
                OR UPPER(role) LIKE UPPER('$txSearch')
                ORDER BY id Desc
                ";

            $data = DB::select($q);

            $output = '<table id="tableUser" class="table table-responsive table-hover">
                    <thead>
                    <tr class="table-primary" >
                        <th scope="col">Username</th>
                        <th scope="col">Badge</th>
                        <th scope="col">Password</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>';
            foreach ($data as $item) {
                $output .=
                    '
                    <tr>
                        <td class="">' . ($item->username ?? '-') .'</td>
                        <td class="">' . ($item->badge ?? '-') .'</td>
                        <td class="">' . ($item->password ?? '-') .'</td>
                        <td class="">' . ($item->role ?? '-') .'</td>
                        <td>
                           <a  class="btn btnDeleteUser" data-id="' .$item->id .'"><img src="' .asset('icons/delete.svg') .'"></a>
                       </td>
                    </tr>
                ';
            }

            $output .= '</tbody></table>';
             return $output;
    }

    public function hapusUser(Request $request)
    {
        $id = $request->input('id');

        try {
            DB::table('tbl_user')
                ->where('id', $id)
                ->delete();

            // Jika berhasil, kembalikan respons sukses
            return response()->json(['status' => 'success', 'message' => 'Data User berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons gagal
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function generateBadge()
    {

    }

    public function tambahUser(Request $request)
    {
        $username = $request->input('username');
    }
}
