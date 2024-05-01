@extends('layout.header')

@section('title', 'Update Harian')

@section('main')

<div class="container-fluid">

<!-- Modal Tambah-->
<div class="modal fade" id="modalTambahHarian" tabindex="-1" aria-labelledby="modalTambahHarianLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalTambahHarianLabel">Tambah Manual Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mt-3">
              <label for="namaPelanggan" class="form-label fw-bold">Tanggal</label>
              <input type="text" class="form-control" id="tanggalData" value="">
          </div>
          <div class="mt-3">
              <label class="form-label fw-bold">Jenis Transaksi</label><br>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jenisTransaksi" id="pemasukan" value="pemasukan">
                  <label class="form-check-label" for="pemasukan">Pemasukan</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jenisTransaksi" id="pengeluaran" value="pengeluaran">
                  <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
              </div>
          </div>
          <div class="mt-3">
              <label for="pelanggan" class="form-label fw-bold">Pelanggan</label>
              <select class="form-control" id="pelanggan">
               <option value="">tes</option>
              </select>
          </div>
          <div class="mt-3">
              <label for="noResi" class="form-label fw-bold">Nomor Resi</label>
              <input type="text" class="form-control" id="noResi" value="">
          </div>

          <div class="mt-3">
              <label for="harga" class="form-label fw-bold">Nominal</label>
              <input type="number" class="form-control" id="harga" value="">
          </div>
          <div class="mt-3">
              <label for="harga" class="form-label fw-bold">Pajak</label>
              <input type="number" class="form-control" id="harga" value="">
          </div>
          <div class="mt-3">
              <label for="pembayaran" class="form-label fw-bold">Metode Pembayaran</label>
              <select class="form-select" id="pembayaran">
                  <option value="tunai">Tunai</option>
                  <option value="transfer">Transfer</option>
                  <option value="kartu_kredit">Kartu Kredit</option>
              </select>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" id="submitDataManual" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal Tambah-->

<!-- Modal Tambah-->
<div class="modal fade" id="modalImportExcel" tabindex="-1" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalImportExcelLabel">Import Data Harian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="file" class="form-control" id="importFileExcel" name="importFileExcel" accept=".xlsx, .xls">
            <div id="output" style="max-height: 300px; overflow-y: scroll; overflow-x:hidden; margin-top: 10px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="btnImportFileExcel" class="btn btn-success" data-bs-dismiss="modal">Import</button>
        </div>
      </div>
    </div>
  </div>
  <!--End Modal Tambah-->

<div class="col-sm-12">
    <div>
        <h3 class=" mt-3 fw-bold">Update Harian</h3>
    </div>
</div>


  <div class="row mt-3">
    <div class="d-flex gap-3 justify-content-between">
      {{-- Search --}}
      <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
      <div class="d-flex gap-3">
        <button type="button" id="" class="btn btn-primary btnModalImportExcel">Import Data Harian</button>
        <button type="button" id="btnTambahDataManual" class="btn btn-primary">Tambah Data Harian</button>
      </div>
  </div>
  <div id="containerDataHarian" class="col-sm-12 mt-3">
    {{-- <table id="tableDataHarian" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">Tanggal</th>
                <th scope="col">Jenis Transaksi</th>
                <th scope="col">Keterangan</th>
                <th scope="col">No Resi</th>
                <th scope="col">Nominal</th>
                <th scope="col">Pajak</th>
                <th scope="col">Pembayaran</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr >
                <td>12 April 2023</td>
                <td>
                  <div class="d-flex">
                    <span><img src="{{ asset('icons/Down.svg') }}"></span>
                    <p class="ps-1">Keluar</p>
                  </div>

                </td>
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
            <tr >
                <td>12 April 2023</td>
                <td>
                  <div class="d-flex">
                    <span><img src="{{ asset('icons/Up.svg') }}"></span>
                    <p class="ps-1">Masuk</p>
                  </div>
                </td>
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
            <tr >
                <td>12 April 2023</td>
                <td>
                    <div class="d-flex">
                      <span><img src="{{ asset('icons/Up.svg') }}"></span>
                    <p class="ps-1">Masuk</p>
                  </div>
                </td>
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
    </table> --}}
</div>
  </div>

@endsection

@section('script')
<script>
    let dataImport = [];
</script>

  <script>
      const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    // get list Team
    const getListDataHarian = () => {
        const txtSearch = $('#txSearch').val();

        $.ajax({
                url: "{{ route('getlistDataHarian') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch
                },
                beforeSend: () => {
                    $('#containerDataHarian').html(loadSpin)
                }
            })
            .done(res => {
                $('#containerDataHarian').html(res)
                $('#tableDataHarian').DataTable({
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

    getListDataHarian();

    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
          getListDataHarian();
        }
    })


    $(document).on('click', '#btnTambahDataManual', function(e){
        e.preventDefault()
        flatpickr("#tanggalData", {
            // enableTime: true,
            // noCalendar: true,
            // time_24hr: true,
            dateFormat: "d/m/Y",
            defaultDate: new Date(),
        });

        $( '#pelanggan' ).select2( {
            theme: "bootstrap-5",
            dropdownParent: $('#modalTambahHarian'),
        });


        $('#modalTambahHarian').modal('show');
      });


      $(document).ready(function () {
            $("#submitDataManual").click(function (e) {
                e.preventDefault();

                let namaPelangganEdit = $('#tanggalData').val();
                $('input[name="jenisTransaksi"]').change(function(){
                    let jenisTransaksi  = $(this).val();
                    if(value === "pemasukan") {
                        value = "Masuk";
                    } else if(value === "pengeluaran") {
                        value = "Keluar";
                    }
                    console.log("Nilai yang dipilih: " + jenisTransaksi);
                });
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Swal.fire({
                //     title: "Apakah Kamu Yakin?",
                //     icon: 'question',
                //     showCancelButton: true,
                //     confirmButtonColor: '#5D87FF',
                //     cancelButtonColor: '#49BEFF',
                //     confirmButtonText: 'Ya',
                //     cancelButtonText: 'Tidak',
                //     reverseButtons: true
                // }).then((result) => {
                //     if (result.isConfirmed) {
                //             $.ajax({
                //             type: "POST",
                //             url: "",
                //             data: {
                //                 id : idEdit,
                //                 namaPelangganEdit : namaPelangganEdit,
                //                 noPelangganEdit : noPelangganEdit,
                //                 alamatPelangganEdit : alamatPelangganEdit,
                //                 _token : csrfToken
                //             },
                //             success: function (response) {
                //                 if (response.status === 'success') {
                //                     Swal.fire({
                //                         title: "Berhasil Update Pelanggan",
                //                         icon: "success"
                //                     });
                //                     getListPelanggan();
                //                     $('#modalEditPelanggan').modal('hide');
                //                 } else {
                //                     Swal.fire({
                //                         title: "Gagal Menambahkan Pelanggan",
                //                         icon: "error"
                //                     });
                //                 }
                //             }
                //         });
                //     }
                // })
            });
        });
  </script>
  <script>
    $(document).on('click', '.btnModalImportExcel', function (e) {
        e.preventDefault();
        $("#modalImportExcel").modal('show');
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
  <script>
    $(document).on('change',"#importFileExcel", function (e) {
        e.preventDefault();
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, {type: 'array'});
            var sheetName = workbook.SheetNames[0];
            var sheet = workbook.Sheets[sheetName];
            var columnData = XLSX.utils.sheet_to_json(sheet, { header: 1 })
                .slice(1)
                .map(row => ({
                    no_resi: row[0],
                    tanggal: row[1],
                    pelanggan: row[5],
                    ongkir: row[41],
                    pajak: (parseInt(row[44] || 0) + parseInt(row[45] || 0) + parseInt(row[46] || 0))
                }));
            var outputDiv = document.getElementById('output');
            outputDiv.innerHTML = "<h5 class='mt-3'>Data Kolom yang Diambil:</h5><pre>" + JSON.stringify(columnData, null, 2) + "</pre>";
            dataImport = columnData;
        };
        reader.readAsArrayBuffer(file);
    })
  </script>
  <script>
    $(document).on('click', '#btnImportFileExcel', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('insertDataHarian') }}",
                    data: {dataImport},
                    dataType: "JSON",
                    success: function (RES) {
                        console.log(RES);
                        Swal.fire("Saved!", "", "success");
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    })
  </script>
  <script>
    $('#modalImportExcel').on('hidden.bs.modal', function () {
        $("#importFileExcel").val("");
        $("#output").empty();
        document.getElementById('output').innerHTML = '';
        document.getElementById('output').replaceChildren();
        var container = document.getElementById('output');
        while (container.childNodes.length > 0) {
            container.removeChild(container.childNodes[0]);
        }
    });
  </script>
  @endsection




