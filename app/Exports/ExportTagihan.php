<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportTagihan implements FromView, ShouldAutoSize
{
    public function __construct($tanggal, $pelanggan)
    {
        $this->tanggal = $tanggal;
        $this->pelanggan = $pelanggan;
    }

    public function view(): View
    {
        return view('exports.exportTagihan', [
            "data" => DB::select("SELECT * FROM tbl_tagihan
                                    WHERE tanggal = '$this->tanggal'
                                    AND pengirim LIKE '%$this->pelanggan%'
                                    ORDER BY id DESC"),
            "tanggal" => $this->tanggal,
            "pelanggan" => $this->pelanggan,
        ]);
    }
}