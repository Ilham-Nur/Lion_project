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
                <label for="badgeUser" class="form-label fw-bold">Badge</label>
                <input type="text" class="form-control numericInput" id="badgeUser" value="" disabled>
            </div>
            <div class="mt-3">
                <label for="namaUser" class="form-label fw-bold">Nama User</label>
                <input type="text" class="form-control" id="namaUser" value="">
            </div>
            <div class="mt-3">
                <label for="passwordUser" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" id="passwordUser"></input>
            </div>
            <div class="mt-3">
                <label for="cekPassword" class="form-label fw-bold">Ulangi Password</label>
                <input type="password" class="form-control" id="cekPassword"></input>
            </div>
            <div class="mt-3">
                <label for="alamat" class="form-label fw-bold">Role</label>
                <select id="roleUser" class="form-control">
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="1">Owner</option>
                    <option value="2">Admin</option>
                </select>
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
    {{-- <table id="tableUser" class="table table-responsive table-hover">
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
    const getListUser = () => {
        const txtSearch = $('#txSearch').val();

        $.ajax({
                url: "{{ route('getlistUser') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch
                },
                beforeSend: () => {
                    $('#containerUser').html(loadSpin)
                }
            })
            .done(res => {
                $('#containerUser').html(res)
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
            })
    }

    getListUser();

    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListUser();
        }
    })

    $(document).on('click', '.btnDeleteUser', function(e){
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
                            url: "{{route('hapusUser')}}",
                            data: {
                                id : id,
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Menghapus User",
                                        icon: "success"
                                    });
                                    getListUser();
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan User",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });

    $(document).on('click', '#btnTambahUser', function(e){
        e.preventDefault()
        let password = $('#passwordUser').val();

        $.ajax({
            type: "GET",
            url: "{{route('generateBadge')}}",
            dataType: "json",
            success: function (response) {
                $('#badgeUser').val(response);
            }
        });


        $('#cekPassword').change(function(){
            var password = $('#passwordUser').val();
            var confirmPassword = $(this).val();

            if(password !== confirmPassword) {
                Swal.fire({
                    title: "Password tidak sama",
                    icon: "error"
                });
            }

        });

        $('#modalTambahUser').modal('show');
       });

       $(document).ready(function () {
            $("#submitUser").click(function (e) {
                e.preventDefault();

                let namaUser = $('#namaUser').val();
                let noBadge = $('#badgeUser').val();
                let passwordUser = $('#cekPassword').val();
                let roleUser = $('#roleUser').val();
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
                            url: "{{route('tambahUser')}}",
                            data: {
                                namaUser : namaUser,
                                noBadge : noBadge,
                                passwordUser : passwordUser,
                                roleUser : roleUser,
                                _token : csrfToken
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "User berhasil ditambahkan",
                                        icon: "success"
                                    });
                                    getListUser();
                                    $('#modalTambahUser').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan User",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });

    $('#modalTambahUser').on('hidden.bs.modal', function () {
        $("#namaUser").val("");
        $("#cekPassword").val("");
        $("#passwordUser").val("");
        $("#roleUser").val("");
    });
</script>


@endsection




