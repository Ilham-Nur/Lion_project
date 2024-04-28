@extends('layout.header')

@section('title', 'User Tetap')

@section('main')

<div class="container-fluid">
<!-- Modal Tambah-->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalTambahUserLabel">Tambah User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mt-3">
                <label for="namaUser" class="form-label fw-bold">Nama User</label>
                <input type="text" class="form-control" id="namaUser" value="">
            </div>
            <div class="mt-3">
                <label for="noTelpon" class="form-label fw-bold">No. Telpon</label>
                <input type="text" class="form-control numericInput" id="noTelpon" value="">
            </div>
            <div class="mt-3">
                <label for="alamat" class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" id="alamatUser" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="submitUser" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
</div>
<!--End Modal Tambah-->

<div class="col-sm-12">
    <div>
        <h3 class=" mt-3 fw-bold">User</h3>
    </div>
</div>

  <div class="row mt-3">
    <div class="d-flex gap-3 justify-content-between">
      {{-- Search --}}
      <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
      <div class="d-flex gap-3">
        <button type="button" id="btnTambahUser" class="btn btn-primary">Tambah User</button>
      </div>
  </div>
  <div id="containerUser" class="col-sm-12 mt-3">
    <table id="tableUser" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">Username</th>
                <th scope="col">Badge</th>
                <th scope="col">Role</th>
                <th scope="col">Password</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                <td>ilhamNur</td>
                <td>0001</td>
                <td>Owner</td>
                <td>ilonoer123</td>
                <td> <a class="btn btnDetailAttendance" data-bs-toggle="modal">
                    <img src="{{ asset('icons/delete.svg') }}"></a>
                </td>

            </tr>
        </tbody>
    </table>
</div>
</div>


@endsection

@section('script')
<script>
     $('#tableUser').DataTable({
                    searching: false,
                    lengthChange: false,
                    "bSort": true,
                    "aaSorting": [],
                    pageLength: 7,
                    "lengthChange": false,
                    responsive: true,
                    language: { search: "" }
                });
</script>


@endsection




