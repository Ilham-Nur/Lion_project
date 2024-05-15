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
                ORDER BY a.badge Asc
                ";

            $data = DB::select($q);

            $output = '<table id="tableUser" class="table table-responsive table-hover">
                    <thead>
                    <tr class="table-primary" >
                        <th scope="col">Badge</th>
                        <th scope="col">Username</th>
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
                        <td class="">' . ($item->badge ?? '-') .'</td>
                        <td class="">' . ($item->username ?? '-') .'</td>
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
        $q = "SELECT badge
        FROM tbl_user
        ORDER BY id DESC
        LIMIT 1;";

        $data = DB::select($q);

        if (!empty($data)) {
            $badge = $data[0]->badge;
            $badge = str_pad((int)$badge + 1, strlen($badge), '0', STR_PAD_LEFT);
        } else {
            $badge = "Unknow!!";
        }
        return response()->json($badge);
    }

    public function tambahUser(Request $request)
    {
        $namaUser = $request->input('namaUser');
        $noBadge = $request->input('noBadge');
        $passwordUser = $request->input('passwordUser');
        $roleUser = $request->input('roleUser');

        try {
            DB::table('tbl_user')
            ->insert([
                'username' => $namaUser,
                'badge' => $noBadge,
                'password' => $passwordUser,
                'role_id' => $roleUser
            ]);

            // Mengembalikan respons JSON jika berhasil
            return response()->json(['status' => 'success', 'message' => 'User berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal Menambahkan User' . $e->getMessage()], 500);
        }
    }
}
