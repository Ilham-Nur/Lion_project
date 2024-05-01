@php
$totalOngkir = 0;
$totalPajak = 0;
foreach ($data as $item) {
    $totalOngkir += $item->ongkir;
    $totalPajak += $item->pajak;
}
@endphp
<table>
    <thead>
        <tr>
            <td style="text-align:center;font-size:14px; font-weight: bold; padding: 14px" colspan="5">Export Tagihan Pelanggan</td>
        </tr>
        <tr>
            <td style="text-align:left;font-size:11px;padding: 14px;">Tanggal:</td>
            <td style="text-align:left;font-size:11px;padding: 14px;font-weight: bold;">{{ $tanggal }}</td>
        </tr>
        <tr>
            <td style="text-align:left;font-size:11px;padding: 14px;">Pelanggan:</td>
            <td style="text-align:left;font-size:11px;padding: 14px;font-weight: bold;">{{ $pelanggan }}</td>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">No Resi</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Tanggal</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Pelanggan</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Ongkir</th>
            <th style="text-align:center;font-size:11px;border:1px solid black; font-weight: bold; padding: 10px; white-space: normal;" bgcolor="#b9bab8">Pajak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i)
        <tr>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->no_resi }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->tanggal }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->pengirim }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->ongkir }}</td>
            <td style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $i->pajak }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align:right;font-size:11px;border:1px solid black; padding: 10px">Total:</th>
            <th style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $totalOngkir }}</th>
            <th style="text-align:left;font-size:11px;border:1px solid black; padding: 10px">{{ $totalPajak }}</th>
        </tr>
    </tfoot>
</table>
