<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $sessionLogin = session('loggedInUser');
        $sessionLogin['username'] ?? exit(header("Location: " . route('login')));
        $username = $sessionLogin['username'];

        return view('dashboard/dashboardindex');
    }


    public function getDataCard (Request $request)
    {
        $filter = $request->filter;
        if (!$filter) {
            $formattedFilter = date('Y-m');
        } else {
            $formattedFilter = date_create_from_format("M Y", $filter)->format("Y-m");
        }

        $q1 = "SELECT SUM(
                        CASE
                            WHEN a.pajak IS NULL THEN a.ongkir
                            ELSE COALESCE(a.pajak, 0) + a.ongkir
                        END
                    ) AS pemasukan
                    FROM tbl_harian a
                    JOIN tbl_pembayaran b ON a.pembayaran_id = b.id
                    WHERE a.jenis_pembayaran = 'Masuk'
                    AND a.tanggal BETWEEN '" . $formattedFilter . "-01' AND '" . $formattedFilter . "-31'
                    AND b.id <> 3;
        ";


        $q2 = "SELECT SUM(
                            CASE
                                WHEN a.pajak IS NULL THEN a.ongkir
                                ELSE COALESCE(a.pajak, 0) + a.ongkir
                            END
                        ) AS pengeluaran
                        FROM tbl_harian a
                        JOIN tbl_pembayaran b ON a.pembayaran_id = b.id
                        WHERE a.jenis_pembayaran = 'Keluar'
                        AND a.tanggal BETWEEN '" . $formattedFilter . "-01' AND '" . $formattedFilter . "-31'
                        AND b.id <> 3;
        ";

        $q3 = "SELECT SUM(COALESCE(a.pajak, a.ongkir)) AS total_tagihan
                FROM tbl_harian a
                JOIN tbl_pembayaran b ON a.pembayaran_id = b.id
                WHERE a.tanggal BETWEEN '" . $formattedFilter . "-01' AND '" . $formattedFilter . "-31'
                AND b.id = 3;
        ";

        $pengeluaran = DB::select($q2);
        $pemasukan = DB::select($q1);
        $total_tagihan = DB::select($q3);


        $result = [
            'pemasukan' => $pemasukan[0]->pemasukan,
            'pengeluaran' => $pengeluaran[0]->pengeluaran,
            'total_tagihan' => $total_tagihan[0]->total_tagihan
        ];

        return response()->json($result);
    }

    public function getchartdata(Request $request)
    {
        $filter = $request->filter;

        if (!$filter) {
            $formattedFilter = date('Y-m');
        } else {
            $formattedFilter = date_create_from_format("M Y", $filter)->format("Y-m");
        }

        $q1 = "SELECT a.tanggal, COALESCE(p.pemasukan, 0) - COALESCE(q.pengeluaran, 0) AS saldo_harian
            FROM (
                SELECT DISTINCT tanggal
                FROM tbl_harian
                WHERE tanggal BETWEEN '" . $formattedFilter . "-01' AND '" . $formattedFilter . "-31'
            ) AS a
            LEFT JOIN (
                SELECT tanggal, SUM(
                    CASE
                        WHEN a.pajak IS NULL THEN a.ongkir
                        ELSE COALESCE(a.pajak, 0) + a.ongkir
                    END
                ) AS pemasukan
                FROM tbl_harian a
                JOIN tbl_pembayaran b ON a.pembayaran_id = b.id
                WHERE a.jenis_pembayaran = 'Masuk'
                AND b.id <> 3
                GROUP BY tanggal
            ) AS p ON a.tanggal = p.tanggal
            LEFT JOIN (
                SELECT tanggal, SUM(
                    CASE
                        WHEN a.pajak IS NULL THEN a.ongkir
                        ELSE COALESCE(a.pajak, 0) + a.ongkir
                    END
                ) AS pengeluaran
                FROM tbl_harian a
                JOIN tbl_pembayaran b ON a.pembayaran_id = b.id
                WHERE a.jenis_pembayaran = 'Keluar'
                AND b.id <> 3
                GROUP BY tanggal
            ) AS q ON a.tanggal = q.tanggal
            ORDER BY a.tanggal;
        ";


        $data = DB::select($q1);

        return response()->json($data);
    }

}
