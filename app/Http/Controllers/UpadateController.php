<?php
namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpadateController extends Controller
{
    public function karyawan()
    {
        return view('update/updateindex');
    }

    public function getlistDataHarian(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';

        $q = "SELECT
                    a.id,
                    DATE_FORMAT(a.tanggal, '%d %M %Y') AS tanggal_formatted,
                    a.jenis_pembayaran,
                    a.pelanggan,
                    a.keterangan,
                    a.no_resi,
                    a.ongkir,
                    a.pajak,
                    c.name AS pembayaran
                FROM tbl_harian a
                INNER JOIN tbl_pembayaran c ON c.id = a.pembayaran_id
                WHERE UPPER(jenis_pembayaran) LIKE UPPER('$txSearch')
                OR UPPER(no_resi) LIKE UPPER('$txSearch')
                OR UPPER(a.pelanggan) LIKE UPPER('$txSearch')
                OR UPPER(c.name) LIKE UPPER('$txSearch')
                ORDER BY id Desc
                LIMIT 100
        ";

        $data = DB::select($q);


                    $output = '<table id="tableDataHarian" class="table table-responsive table-hover">
                    <thead>
                    <tr class="table-primary" >
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jenis Transaksi</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">No Resi</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Pajak</th>
                        <th scope="col">Pembayaran</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($data as $item) {

            $jenis_pembayaran_html = '';
            if ($item->jenis_pembayaran === 'Masuk') {
                $jenis_pembayaran_html = '
                <div class="d-flex align-items-center">
                <span
                  class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                  <i class="ti ti-arrow-up-left text-success"></i>
                </span>
                <p class="text-dark me-1 fs-3 mb-0">Masuk</p>
              </div>';
            } elseif ($item->jenis_pembayaran === 'Keluar') {
                $jenis_pembayaran_html = '
                <div class="d-flex align-items-center">
                <span
                  class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                  <i class="ti ti-arrow-down-right text-danger"></i>
                </span>
                <p class="text-dark me-1 fs-3 mb-0">Keluar</p>
              </div>';
            } else {
                $jenis_pembayaran_html = $item->jenis_pembayaran ?? '-';
            }


            $nominal = isset($item->ongkir) ? 'Rp. ' . number_format($item->ongkir, 0, ',', '.') : '-';
            $pajak = isset($item->pajak) ? 'Rp. ' . number_format($item->pajak, 0, ',', '.') : '-';

            $label_pembayaran = '';
            switch ($item->pembayaran) {
                case 'Cash':
                    $label_pembayaran = '<span class="badge text-bg-warning">Cash</span>';
                    break;
                case 'Transfer':
                    $label_pembayaran = '<span class="badge text-bg-success">Transfer</span>';
                    break;
                case 'Piutang':
                    $label_pembayaran = '<span class="badge text-bg-danger">Piutang</span>';
                    break;
                default:
                    $label_pembayaran = $item->pembayaran ?? '-';
            }

            $output .=
                '
                <tr>
                    <td class="">' . ($item->tanggal_formatted ?? '-') .'</td>
                    <td class="">' . $jenis_pembayaran_html . '</td>
                    <td class="">' . ($item->pelanggan ?? '-') .'</td>
                    <td class="">' . ($item->keterangan ?? '-') .'</td>
                    <td class="">' . ($item->no_resi ?? '-') .'</td>
                    <td class="">' . $nominal .'</td>
                    <td class="">' . $pajak .'</td>
                    <td class="">' . $label_pembayaran .'</td>
                    <td>
                       <a  class="btn btnEdiDataHarian" data-id="' .$item->id .'"><img src="' .asset('icons/Edit.svg') .'"></a>
                       <a  class="btn btnDeleteDataHarian" data-id="' .$item->id .'"><img src="' .asset('icons/delete.svg') .'"></a>
                   </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    public function insertDataHarian(Request $req)
    {
        $sessionLogin = session('loggedInUser');
        $sessionLogin['username'] ?? exit(header("Location: " . route('login')));
        $username = $sessionLogin['username'];

        try {

            DB::beginTransaction();
            foreach ($req->dataImport as $r) {
                DB::table('tbl_harian')->insert([
                    "tanggal" => new DateTime($r['tanggal']),
                    "jenis_pembayaran" => "Masuk",
                    "pelanggan" => $r['pelanggan'],
                    "keterangan" => "Piutang",
                    "no_resi" => $r['no_resi'],
                    "ongkir" => $r['ongkir'],
                    "pajak" => $r['pajak'],
                    "pembayaran_id" => 3,
                ]);

                DB::table('tbl_tagihan')->insert([
                    "no_resi" => $r['no_resi'],
                    "tanggal" => new DateTime($r['tanggal']),
                    "pengirim" => $r['pelanggan'],
                    "ongkir" => $r['ongkir'],
                    "pajak" => $r['pajak'],
                ]);
            }

            DB::commit();

            return response()->json('SUCCESS');

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
