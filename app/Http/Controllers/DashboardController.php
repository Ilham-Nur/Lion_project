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

    
    public function getlistDataHarian(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';

        $q = "SELECT
                    a.id,
                    DATE_FORMAT(a.tanggal, '%d %M %Y') AS tanggal_formatted,
                    a.jenis_pembayaran,
                    b.nama AS pelanggan,
                    a.keterangan,
                    a.no_resi,
                    a.ongkir,
                    a.pajak,
                    c.name AS pembayaran
                FROM tbl_harian a
                JOIN tbl_pelanggan b ON b.id = a.pelanggan_id
                INNER JOIN tbl_pembayaran c ON c.id = a.pembayaran_id
                WHERE UPPER(jenis_pembayaran) LIKE UPPER('$txSearch') 
                OR UPPER(no_resi) LIKE UPPER('$txSearch') 
                OR UPPER(b.nama) LIKE UPPER('$txSearch')
                OR UPPER(c.name) LIKE UPPER('$txSearch')
                ORDER BY id Desc    
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
                    <div class="d-flex">
                        <span><img src="' . asset('icons/Up.svg') . '"></span>
                        <p class="ps-1">Masuk</p>
                    </div>';
            } elseif ($item->jenis_pembayaran === 'Keluar') {
                $jenis_pembayaran_html = '
                    <div class="d-flex">
                        <span><img src="' . asset('icons/Down.svg') . '"></span>
                        <p class="ps-1">Keluar</p>
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

}
