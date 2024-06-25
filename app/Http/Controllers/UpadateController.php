<?php
namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDataHarian;

class UpadateController extends Controller
{
    public function karyawan()
    {
        return view('update/updateindex');
    }

    public function getlistDataHarian(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        $filter = $request->filter;
        if (!$filter) {
            $formattedFilter = date('Y-m');
        } else {
            $formattedFilter = date_create_from_format("M Y", $filter)->format("Y-m");
        }

        $q = "SELECT
                    a.id,
                    DATE_FORMAT(a.tanggal, '%d %M %Y') AS tanggal_formatted,
                    a.tanggal AS tanggalori,
                    a.jenis_pembayaran,
                    a.pelanggan,
                    a.keterangan,
                    a.no_resi,
                    a.ongkir,
                    a.pajak,
                    c.name AS pembayaran,
                    c.id as id_pembayaran
                FROM tbl_harian a
                INNER JOIN tbl_pembayaran c ON c.id = a.pembayaran_id
                WHERE (
                    UPPER(a.jenis_pembayaran) LIKE UPPER('$txSearch')
                    OR UPPER(a.no_resi) LIKE UPPER('$txSearch')
                    OR UPPER(a.pelanggan) LIKE UPPER('$txSearch')
                    OR UPPER(c.name) LIKE UPPER('$txSearch')
                )
                AND a.tanggal BETWEEN '" . $formattedFilter . "-01' AND '" . $formattedFilter . "-31'
                ORDER BY a.id DESC
                LIMIT 100;
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
                       <a  class="btn btnEdiDataHarian" data-id="' .$item->id .'" data-tanggal="' .$item->tanggalori .'" data-jenisbayar="' .$item->jenis_pembayaran .'" data-pelanggan="' .$item->pelanggan .'" data-keterangan="' .$item->keterangan .'" data-noresi="' .$item->no_resi .'" data-nominal="' .$item->ongkir .'" data-pajak="' .$item->pajak .'"  data-pembayaran="' .$item->id_pembayaran .'"><img src="' .asset('icons/Edit.svg') .'"></a>
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

    public function tambahData(Request $request)
    {
        $tanggal = $request->tanggal;
        $jenistransaksi = $request->jenistransaksi;
        $pelanggan = $request->pelanggan;
        $noresi = $request->noresi;
        $nominal = $request->nominal;
        $pajak = $request->pajak;
        $pembayaran = $request->pembayaran;
        $keterangan = $request->keterangan;

        try {
            DB::table('tbl_harian')->insert([
                'tanggal' => $tanggal,
                'jenis_pembayaran' => $jenistransaksi,
                'pelanggan' => $pelanggan,
                'keterangan' => $keterangan,
                'no_resi' => $noresi,
                'ongkir' => $nominal,
                'pajak' => $pajak,
                'pembayaran_id' => $pembayaran
            ]);

            // Mengembalikan respons JSON jika berhasil
            return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Data: ' . $e->getMessage()], 500);
        }

    }

    public function updateData(Request $request)
    {
        $idEdit = $request->id;
        $tanggalEdit = $request->tanggal;
        $jenistransaksiEdit = $request->jenistransaksi;
        $pelangganEdit = $request->pelanggan;
        $noresiEdit = $request->noresi;
        $nominalEdit = $request->nominal;
        $pajakEdit = $request->pajak;
        $pembayaranEdit = $request->pembayaran;
        $keteranganEdit = $request->keterangan;


        try {
            DB::table('tbl_harian')
            ->where("id", $idEdit)
            ->update([
                'tanggal' => $tanggalEdit,
                'jenis_pembayaran' => $jenistransaksiEdit,
                'pelanggan' => $pelangganEdit,
                'keterangan' => $keteranganEdit,
                'no_resi' => $noresiEdit,
                'ongkir' => $nominalEdit,
                'pajak' => $pajakEdit,
                'pembayaran_id' => $pembayaranEdit
            ]);

            // Mengembalikan respons JSON jika berhasil
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diUpdate'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal update Data: ' . $e->getMessage()], 500);
        }


    }

    public function hapusData(Request $request)
    {
        $id = $request->input('id');

        try {
            DB::table('tbl_harian')
                ->where('id', $id)
                ->delete();

            // Jika berhasil, kembalikan respons sukses
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons gagal
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function exportData(Request $request)
    {
        try {
            $tanggal = $request->input('tanggal');


            $date = DateTime::createFromFormat('M Y', $tanggal);

            $formattedDate = $date->format('Y-m');

            return Excel::download(new ExportDataHarian($formattedDate), 'ExportData.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'MESSAGETYPE' => 'E',
                'MESSAGE' => 'Something went wrong',
                'SERVERMSG' => $th->getMessage(),
            ], 400)->header(
                'Accept',
                'application/json'
            );
        }
    }


}
