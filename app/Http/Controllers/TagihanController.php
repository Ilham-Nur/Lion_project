<?php

namespace App\Http\Controllers;

use App\Exports\ExportTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TagihanController extends Controller
{

    public function index()
    {
        return view('tagihan/tagihanindex');

    }

    public function getlistTagihan(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        $filter = $request->filter;

        $q = "SELECT id, no_resi, tanggal, pengirim, ongkir, pajak, (ongkir + pajak) AS total
                FROM tbl_tagihan
                WHERE tanggal = '$filter'
                AND (UPPER(no_resi) LIKE UPPER('$txSearch') OR UPPER(pengirim) LIKE UPPER('$txSearch'))
                ORDER BY id DESC;
        ";




        $data = DB::select($q);

        $output = '<table id="tableTagihan" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">No Resi</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Pelanggan</th>
                <th scope="col">Ongkir</th>
                <th scope="col">Pajak</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $item) {
            $output .=
                '
                <tr>
                    <td class="">' . ($item->no_resi ?? '-') .'</td>
                    <td class="">' . ($item->tanggal ?? '-') .'</td>
                    <td class="">' . ($item->pengirim ?? '-') .'</td>
                    <td class="">' . ($item->ongkir ? 'Rp. ' . number_format($item->ongkir) : '-') .'</td>
                    <td class="">' . ($item->pajak ? 'Rp. ' . number_format($item->pajak) : '-') .'</td>
                    <td class="">' . ($item->total ? 'Rp. ' . number_format($item->total) : '-') .'</td>
                    <td>
                       <a  class="btn btnDeleteTagihan" data-id="' .$item->id .'"><img src="' .asset('icons/delete.svg') .'"></a>
                   </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
         return $output;

    }

    public function hapusTagihan(Request $request)
    {
        $id = $request->input('id');

        try {
            DB::table('tbl_tagihan')
                ->where('id', $id)
                ->delete();

            // Jika berhasil, kembalikan respons sukses
            return response()->json(['status' => 'success', 'message' => 'Tagihan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons gagal
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function exportTagihan(Request $req)
    {
        $sessionLogin = session('loggedInUser');
        $sessionLogin['username'] ?? exit(header("Location: " . route('login')));
        $username = $sessionLogin['username'];

        try {

            DB::beginTransaction();

            $tanggal = $req->tanggal;
            $pelanggan = $req->selectPelanggan;

            DB::commit();

            return Excel::download(new ExportTagihan($tanggal, $pelanggan), 'ExportTagihan.xlsx');

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
}
