<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportDataHarian implements FromView, ShouldAutoSize
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        $startOfMonth = date('Y-m-01', strtotime($this->tanggal));
        $endOfMonth = date('Y-m-t', strtotime($this->tanggal));

        $data = DB::select("SELECT
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
                            WHERE a.tanggal BETWEEN ? AND ?
                            ORDER BY a.id DESC
                        ", [$startOfMonth, $endOfMonth]);
        return view('exports.exportDataHarian', [
            'data' => $data,
            'tanggal' => $this->tanggal,
        ]);
    }
}
