@php
$totalOngkir = 0;
$totalPajak = 0;
foreach ($data as $item) {
    $totalOngkir += $item->ongkir;
    $totalPajak += $item->pajak;
}
$totalKeseluruhan = $totalOngkir + $totalPajak;
@endphp
<table>
    <thead>
        <tr>
            <td style="text-align:center;font-size:14px; font-weight: bold; padding: 14px" colspan="8">Pos Glory Center</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:14px; font-weight: bold; padding: 14px" colspan="8">Export Laporan Keuangan</td>
        </tr>
        <tr>
            <td style="text-align:left;font-size:11px;padding: 14px;">Tanggal:</td>
            <td style="text-align:left;font-size:11px;padding: 14px;font-weight: bold;">{{ $tanggal }}</td>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Tanggal</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Jenis Transaksi</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Pelanggan</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Keterangan</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">No Resi</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Pembayaran</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Nominal</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Pajak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i)
        <tr>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->tanggal_formatted ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->jenis_pembayaran ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->pelanggan ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->keterangan ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->no_resi ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->pembayaran ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->ongkir ?? '-' }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->pajak ?? '0' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right;font-size:11px;border:1px solid black; padding: 10px">Total:</th>
            <th style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $totalOngkir }}</th>
            <th style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $totalPajak }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align:right;font-size:11px;border:1px solid black; padding: 10px">Total Keseluruhan:</th>
            <th colspan="2" style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $totalKeseluruhan }}</th>
        </tr>
    </tfoot>
</table>
