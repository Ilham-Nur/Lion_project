@extends('layout.header')

@section('title', 'Dashboard')

@section('main')

<div class="container-fluid">
  <div class="row">
    <div class="d-flex gap-3 justify-content-between">
      {{-- Search --}}
      <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
      <div class="d-flex gap-3">
        <button type="button" id="" class="btn btn-primary">Import Data Harian</button>
        <button type="button" id="" class="btn btn-primary">Tambah Data Harian</button>
      </div>
  </div>
  <div id="containerAttendanceOverbreak" class="col-sm-12 mt-3">
    <table id="attendanceOverbreak" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">Tanggal</th>
                <th scope="col">Keterangan</th>
                <th scope="col">No Resi</th>
                <th scope="col">Ongkir</th>
                <th scope="col">Pajak</th>
                <th scope="col">Pembayaran</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                <td>12 April 2023</td>
                <td>Beli Lakban</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>
                    <span class="badge text-bg-warning">Cash</span>
                <td>
                    <a class="btn btnDetailAttendance" data-bs-toggle="modal">
                        <img src="{{ asset('icons/delete.svg') }}"></a>
                    <a class="btn btnEditAttendance" data-bs-toggle="modal"> <img
                            src="{{ asset('icons/Edit.svg') }}"></a>

                </td>
            </tr>
            <tr class="align-middle">
                <td>12 April 2023</td>
                <td>Meta</td>
                <td>11LP2819402KQ23</td>
                <td>Rp. 123.000</td>
                <td>Rp. 50.000</td>
                <td>  
                    <span class="badge text-bg-success">Transfer</span>
                <td>
                    <a class="btn btnDetailAttendance" data-bs-toggle="modal">
                        <img src="{{ asset('icons/delete.svg') }}"></a>
                    <a class="btn btnEditAttendance" data-bs-toggle="modal"> <img
                            src="{{ asset('icons/Edit.svg') }}"></a>
                </td>
            </tr>
            <tr class="align-middle">
                <td>12 April 2023</td>
                <td>Indah</td>
                <td>11LP4390392YQ324</td>
                <td>Rp. 300.000</td>
                <td>Rp. 35.000</td>
                <td>  
                    <span class="badge text-bg-danger">Belum bayar</span>
                <td>
                    <a class="btn btnDetailAttendance" data-bs-toggle="modal">
                        <img src="{{ asset('icons/delete.svg') }}"></a>
                    <a class="btn btnEditAttendance" data-bs-toggle="modal"> <img
                            src="{{ asset('icons/Edit.svg') }}"></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
   
  </div>

  <script>
     $(document).ready(function () {
            $('#attendanceOverbreak').DataTable({
                searching: false,
                lengthChange: false,
                "bSort": true,
                pageLength: 10,
                responsive: true,
            });
        });
  </script>

  @endsection




