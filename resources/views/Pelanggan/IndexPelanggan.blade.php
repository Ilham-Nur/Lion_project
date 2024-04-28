@extends('layout.header')

@section('title', 'Pelanggan Tetap')

@section('main')

<div class="container-fluid">
<!-- Modal Tambah-->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalTambahPelangganLabel">Tambah Pelanggan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mt-3">
                <label for="namaPelanggan" class="form-label fw-bold">Nama Pelanggan</label>
                <input type="text" class="form-control" id="namaPelanggan" value="">
            </div>
            <div class="mt-3">
                <label for="noTelpon" class="form-label fw-bold">No. Telpon</label>
                <input type="text" class="form-control numericInput" id="noTelpon" value="">
            </div>
            <div class="mt-3">
                <label for="alamat" class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" id="alamatPelanggan" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="submitpelanggan" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
</div>
<!--End Modal Tambah-->


<!-- Modal Edit-->
<div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalEditPelangganLabel">Tambah Pelanggan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idEditPelanggan">
            <div class="mt-3">
                <label for="namaPelanggan" class="form-label fw-bold">Nama Pelanggan</label>
                <input type="text" class="form-control" id="namaPelangganEdit" value="">
            </div>
            <div class="mt-3">
                <label for="noTelpon" class="form-label fw-bold">No. Telpon</label>
                <input type="text" class="form-control numericInput" id="noTelponEdit" value="">
            </div>
            <div class="mt-3">
                <label for="alamat" class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" id="alamatPelangganEdit" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="submitpelangganEdit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Edit-->

<div class="col-sm-12">
    <div>
        <h3 class=" mt-3 fw-bold">Pelanggan Tetap</h3>
    </div>
</div>

  <div class="row mt-3">
    <div class="d-flex gap-3 justify-content-between">
      {{-- Search --}}
      <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
      <div class="d-flex gap-3">
        <button type="button" id="btnTambahPelanggan" class="btn btn-primary">Tambah Pelanggan</button>
      </div>
  </div>
  <div id="containerPelanggan" class="col-sm-12 mt-3">
    {{-- <table id="tablePelanggan" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. Handphone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                <td>Lina</td>
                <td>PT.Seraya</td>
                <td>08136412341<td>
                    <a class="btn btnDetailAttendance" data-bs-toggle="modal">
                        <img src="{{ asset('icons/delete.svg') }}"></a>
                    <a class="btn btnEditAttendance" data-bs-toggle="modal"> <img
                            src="{{ asset('icons/Edit.svg') }}"></a>

                </td>
            </tr>
        </tbody>
    </table> --}}
</div>
</div>


@endsection

@section('script')


<script>
      const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    // get list Team
    const getListPelanggan = () => {
        const txtSearch = $('#txSearch').val();

        $.ajax({
                url: "{{ route('getlistPelanggan') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch
                },
                beforeSend: () => {
                    $('#containerPelanggan').html(loadSpin)
                }
            })
            .done(res => {
                $('#containerPelanggan').html(res)
                $('#tablePelanggan').DataTable({
                    searching: false,
                    lengthChange: false,
                    "bSort": true,
                    "aaSorting": [],
                    pageLength: 7,
                    "lengthChange": false,
                    responsive: true,
                    language: { search: "" }
                });
            })
    }

    getListPelanggan();

    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListPelanggan();
        }
    })

    $(document).ready(function () {
        $('.numericInput').keypress(function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 8) {
                return false;
            }
        });
    });

     $(document).on('click', '#btnTambahPelanggan', function(e){
        e.preventDefault()
        $('#modalTambahPelanggan').modal('show');
       });

       $(document).ready(function () {
            $("#submitpelanggan").click(function (e) {
                e.preventDefault();

                let namaPelanggan = $('#namaPelanggan').val();
                let noPelanggan = $('#noTelpon').val();
                let alamatPelanggan = $('#alamatPelanggan').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: "Apakah Kamu Yakin?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#5D87FF',
                    cancelButtonColor: '#49BEFF',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                            $.ajax({
                            type: "POST",
                            url: "{{route('tambahPelanggan')}}",
                            data: {
                                namaPelanggan : namaPelanggan,
                                noPelanggan : noPelanggan,
                                alamatPelanggan : alamatPelanggan,
                                _token : csrfToken
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Menambahkan Pelanggan",
                                        icon: "success"
                                    });
                                    getListPelanggan();
                                    $('#modalTambahPelanggan').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Pelanggan",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });

        $(document).on('click', '.btnEdiPelanggan', function(e){
            e.preventDefault()
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let noTelp = $(this).data('notelp');
            let alamat = $(this).data('alamat');

            $('#namaPelangganEdit').val(nama);
            $('#noTelponEdit').val(noTelp);
            $('#alamatPelangganEdit').val(alamat);
            $('#idEditPelanggan').val(id);

        $('#modalEditPelanggan').modal('show');
       });

       $(document).ready(function () {
            $("#submitpelangganEdit").click(function (e) {
                e.preventDefault();

                let idEdit = $('#idEditPelanggan').val();
                let namaPelangganEdit = $('#namaPelangganEdit').val();
                let noPelangganEdit = $('#noTelponEdit').val();
                let alamatPelangganEdit = $('#alamatPelangganEdit').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: "Apakah Kamu Yakin?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#5D87FF',
                    cancelButtonColor: '#49BEFF',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                            $.ajax({
                            type: "POST",
                            url: "{{route('updatePelanggan')}}",
                            data: {
                                id : idEdit,
                                namaPelangganEdit : namaPelangganEdit,
                                noPelangganEdit : noPelangganEdit,
                                alamatPelangganEdit : alamatPelangganEdit,
                                _token : csrfToken
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Update Pelanggan",
                                        icon: "success"
                                    });
                                    getListPelanggan();
                                    $('#modalEditPelanggan').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Pelanggan",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });

        $(document).on('click', '.btnDeletePelanggan', function(e){
            let id = $(this).data('id');

            Swal.fire({
                    title: "Apakah Kamu Yakin?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#5D87FF',
                    cancelButtonColor: '#49BEFF',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                            $.ajax({
                            type: "GET",
                            url: "{{route('hapusPelanggan')}}",
                            data: {
                                id : id,
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Menghapus Pelanggan",
                                        icon: "success"
                                    });
                                    getListPelanggan();
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Pelanggan",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });


 </script>


  @endsection




