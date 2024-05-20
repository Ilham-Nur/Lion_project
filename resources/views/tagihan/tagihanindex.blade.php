@extends('layout.header')

@section('title', 'Tagihan')

@section('main')

<div class="container-fluid">

<div class="col-sm-12">
    <div>
        <h3 class=" mt-3 fw-bold">Tagihan Pelanggan</h3>
    </div>
</div>

<!-- Modal Preview-->
<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalImportExcelLabel">Export Preview</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <div class="mb-3 col-6">
                <label class="form-label">Tanggal</label>
                <input class="form-control" style="background-color: #e9eef7" type="text" readonly name="tanggal" id="tanggal">
            </div>
            <div class="mb-3 col-6">
                <label class="form-label">Pelanggan</label>
                <select class="form-select" id="selectPelanggan" required>
                </select>
            </div>
            <div id="test">
                {{-- <table id="tablePreviewTagihan" class="table table-responsive table-hover">
                    <thead>
                        <tr class="table-primary" >
                            <th scope="col">No Resi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tagihan</th>
                            <th scope="col">Ongkir</th>
                            <th scope="col">Pajak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <td>11LP1700879991404</td>
                            <td>2023-11-24</td>
                            <td>PIJE</td>
                            <td>82000</td>
                            <td>38000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td id="total-ongkir">50000</td>
                            <td id="total-pajak">30000</td>
                        </tr>
                        <tr>
                            <td colspan="4">Total Keseluruhan</td>
                            <td id="total-keseluruan">80000</td>
                        </tr>
                    </tfoot>
                </table> --}}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" id="btnExportFileExcel" class="btn btn-success">Export</button>
        </div>
        </div>
    </div>
    </div>
<!--End Modal Preview-->

  <div class="row mt-3">
    <div class="d-flex gap-3 justify-content-between">
        <div class="d-flex gap-3">
            {{-- Search --}}
            <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
            {{-- Filter Hari --}}
            <input type="text" id="hariPicker" placeholder="Pilih hari">
            {{-- Reset --}}
            <button type="button" class="btn btn-outline-secondary" id="btnResetDefault" onclick="window.location.reload()">
                    Reset
            </button>
        </div>
        <div class="d-flex gap-3">
            <button type="button" id="btnTambahTagihan" class="btn btn-primary">Preview Tagihan</button>
        </div>
    </div>

  </div>
  <div id="containerTagihan" class="col-sm-12 mt-3">
    {{-- <table id="tableTagihan" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">No Resi</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Tagihan</th>
                <th scope="col">Ongkir</th>
                <th scope="col">Pajak</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                <td>11LP1700879991404</td>
                <td>2023-11-24</td>
                <td>PIJE</td>
                <td>82000</td>
                <td>38000</td>
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

const getListTagihan = (txSearch, selectedDate) => {
    $.ajax({
        url: "{{ route('getlistTagihan') }}",
        method: "GET",
        data: {
            txSearch: txSearch,
            filter: selectedDate
        },
        beforeSend: () => {
            $('#containerTagihan').html(loadSpin)
        }
    })
    .done(res => {
        $('#containerTagihan').html(res)
        $('#tableTagihan').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 7,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });
}

flatpickr("#hariPicker", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "j F Y",
    defaultDate: "today",
    onChange: function(selectedDates, dateStr, instance) {
        selectedDate = dateStr;
        console.log("Nilai input berubah menjadi: " + selectedDate);
        getListTagihan($('#txSearch').val(), selectedDate);
    }
});


getListTagihan($('#txSearch').val(), $('#hariPicker').val());

$('#txSearch').keyup(function(e) {
    var inputText = $(this).val();
    if (inputText.length >= 2 || inputText.length == 0) {
        getListTagihan(inputText, $('#hariPicker').val());
    }
});

$(document).on('click', '.btnDeleteTagihan', function(e){
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
                            url: "{{route('hapusTagihan')}}",
                            data: {
                                id : id,
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Menghapus Tagihan",
                                        icon: "success"
                                    });
                                    getListTagihan($('#txSearch').val(), $('#hariPicker').val());
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Tagihan",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });


</script>
<script>
    $(document).on('click', '#btnTambahTagihan', function (e) {
        e.preventDefault();
        $("#modalImportExcel").modal('show');
        const hariPicker = $("#hariPicker").val();
        $("#tanggal").val(hariPicker);
        $.ajax({
            url: '{{ route('listPelanggan') }}',
            type: 'GET',
            data: {tanggal:hariPicker},
            dataType: 'JSON',
            success: function(data) {
                let select = $('#selectPelanggan');
                select.empty();
                select.append('<option value="" selected>Select Pelanggan</option>');
                $.each(data, function(key, value) {
                    select.append('<option value="' + value.pengirim + '">' + value.pengirim + '</option>');
                });
            }


        })

        const getPreviewTagihan = () => {
                let tanggalPreview =  $("#tanggal").val();
                let pelangganPreview =  $("#selectPelanggan").val();

                $.ajax({
                    url: "{{ route('previewTagihan') }}",
                    method: "GET",
                    data: {
                        filter: tanggalPreview,
                        pelanggan: pelangganPreview
                    },
                    beforeSend: () => {
                        $('#test').html(loadSpin);
                    }
                })
                .done(res => {
                    $('#test').html(res);
                    $('#tablePreviewTagihan').DataTable({
                        searching: false,
                        lengthChange: false,
                        "bSort": true,
                        "aaSorting": [],
                        pageLength: 7,
                        responsive: true,
                        language: { search: "" }
                    });
                });
            };

            getPreviewTagihan();

            $('#selectPelanggan').on('change', function() {
                getPreviewTagihan();
            });



        $(document).on('click', '#btnExportFileExcel', function (e) {
            e.preventDefault();
            var tanggal = $("#tanggal").val();
            var selectPelanggan = $('#selectPelanggan').val();
            if (selectPelanggan == "") {
                Swal.fire({
                    title: "Select Pelanggan Required!",
                    icon: "error"
                });
                return;
            }
            var url = "{{ route('exportTagihan') }}" + "?tanggal=" + tanggal + "&selectPelanggan=" + selectPelanggan;
            window.location = url;
            $("#modalImportExcel").modal('hide');
        });
    })

    $('#modalImportExcel').on('hidden.bs.modal', function () {
        $("#selectPelanggan").val("");
    });
</script>

<script>

</script>

@endsection




