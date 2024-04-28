<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

        $q = "SELECT * FROM tbl_tagihan
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

                    <td>
                       <a  class="btn btnDeletePelanggan" data-id="' .$item->id .'"><img src="' .asset('icons/delete.svg') .'"></a>
                   </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
         return $output;

    }
}
