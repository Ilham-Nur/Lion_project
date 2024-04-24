<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PelangganController extends Controller
{

    public function index()
    {
        return view('karyawan/Pelanggan/indexPelanggan');
      
    }

    public function getlistPelanggan(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';

        $q = "SELECT * FROM tbl_pelanggan 
        WHERE UPPER(nama) LIKE UPPER('$txSearch') 
        OR UPPER(no_telpon) LIKE UPPER('$txSearch') 
        OR UPPER(alamat) LIKE UPPER('$txSearch')
        ORDER BY id Desc    ";

        $data = DB::select($q);

    

        $output = '<table id="tablePelanggan" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. Handphone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $item) {
            $output .=
                '
                <tr>
                    <td class="">' . ($item->nama ?? '-') .'</td>
                    <td class="">' . ($item->no_telpon ?? '-') .'</td>
                    <td class="">' . ($item->alamat ?? '-') .'</td>
                    <td>
                       <a  class="btn btnEdiPelanggan" data-id="' .$item->id .'" data-nama="' .$item->nama .'" data-notelp="' .$item->no_telpon .'" data-alamat="' .$item->alamat .'" ><img src="' .asset('icons/Edit.svg') .'"></a>
                       <a  class="btn btnDeletePelanggan" data-id="' .$item->id .'"><img src="' .asset('icons/delete.svg') .'"></a>
                   </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
         return $output;
        
    }


    public function tambahPelanggan(Request $request)
    {
        $nama = $request->input('namaPelanggan');
        $notelp = $request->input('noPelanggan');
        $alamat = $request->input('alamatPelanggan');
        
        try {
            DB::table('tbl_pelanggan')->insert([
                'nama' => $nama, 
                'no_telpon' => $notelp, 
                'alamat' => $alamat 
            ]);
    
            // Mengembalikan respons JSON jika berhasil
            return response()->json(['status' => 'success', 'message' => 'Pelanggan berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan pelanggan: ' . $e->getMessage()], 500);
        }
    }

    public function updatePelanggan(Request $request)
    {
        $idedit = $request->input('id');
        $nameedit = $request->input('namaPelangganEdit');
        $noPelangganEdit = $request->input('noPelangganEdit');
        $alamatPelangganEdit = $request->input('alamatPelangganEdit');

        try {
            DB::table('tbl_pelanggan')
            ->where('id', $idedit)
            ->update([
                'nama' => $nameedit, 
                'no_telpon' => $noPelangganEdit, 
                'alamat' => $alamatPelangganEdit 
            ]);
    
            // Mengembalikan respons JSON jika berhasil
            return response()->json(['status' => 'success', 'message' => 'Data Pelanggan berhasil diupdate'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal Mengupdate Data Pelanggan: ' . $e->getMessage()], 500);
        }
    }

    public function hapusPelanggan(Request $request)
    {
        $id = $request->input('id');

        try {
            DB::table('tbl_pelanggan')
                ->where('id', $id)
                ->delete();

            // Jika berhasil, kembalikan respons sukses
            return response()->json(['status' => 'success', 'message' => 'Data Pelanggan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons gagal
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }







}
