@extends('layout.header')

@section('title', 'Tagihan')

@section('main')

<div class="container-fluid">
<!-- Modal Tambah-->
<div class="modal fade" id="modalTambahTagihan" tabindex="-1" aria-labelledby="modalTambahTagihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalTambahTagihanLabel">Tambah Tagihan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mt-3">
                <label for="namaTagihan" class="form-label fw-bold">Nama Tagihan</label>
                <input type="text" class="form-control" id="namaTagihan" value="">
            </div>
            <div class="mt-3">
                <label for="noTelpon" class="form-label fw-bold">No. Telpon</label>
                <input type="text" class="form-control numericInput" id="noTelpon" value="">
            </div>
            <div class="mt-3">
                <label for="alamat" class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" id="alamatTagihan" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="submitTagihan" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
</div>
<!--End Modal Tambah-->

<div class="col-sm-12">
    <div>
        <h3 class=" mt-3 fw-bold">Tagihan Pelanggan</h3>
    </div>
</div>

  <div class="row mt-3">
    <div class="d-flex gap-3 justify-content-between">
        <div class="d-flex gap-3">
            {{-- Search --}}
            <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"class="form-control rounded-3" placeholder="Search">
            {{-- <div class="d-flex align-items-center gap-1">
                <button id="monthEvent" class="btn btn-light form-control"  style="border: 1px solid #e9ecef;">
                    <span id="calendarTitle" class="fs-4"></span>
                </button>
            </div> --}}
            <input type="text" id="hariPicker" placeholder="Pilih hari">
            <button type="button" class="btn btn-outline-secondary" id="btnResetDefault" onclick="window.location.reload()">
            {{-- <button type="button" class="btn btn-outline-secondary" onclick="window.location.reload()">
                <div class="d-flex align-items-center gap-1">
                    <i class='bx bx-refresh bx-rotate-90 fs-4'></i>--}}
                    Reset
            </button>
        </div>
        <div class="d-flex gap-3">
            <button type="button" id="btnTambahTagihan" class="btn btn-primary">Export Tagihan</button>
          </div>
    </div>

  </div>
  <div id="containerTagihan" class="col-sm-12 mt-3">
    <table id="tableTagihan" class="table table-responsive table-hover">
        <thead>
            <tr class="table-primary" >
                <th scope="col">No Resi</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Pelanggan</th>
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
    </table>
</div>
</div>


@endsection

@section('script')
<script>
    // $(document).ready(function() {
    //         function getCurrentMonth() {
    //             const months = [
    //                 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    //                 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    //             ];

    //             const currentDate = new Date();
    //             const currentMonth = months[currentDate.getMonth()];
    //             const currentYear = currentDate.getFullYear();

    //             return `${currentMonth} ${currentYear}`;
    //         }

    //         $('#calendarTitle').text(getCurrentMonth());

    //         $('#monthEvent').flatpickr({
    //             plugins: [
    //                 new monthSelectPlugin({
    //                     shorthand: true,
    //                     dateFormat: "M Y",
    //                     altFormat: "M Y",
    //                     theme: "light"
    //                 })
    //             ],
    //             onChange: function(selectedDates, dateStr, instance) {
    //                 const selectedDate = selectedDates[0];
    //                 const selectedMonth = instance.formatDate(selectedDate, "M Y");

    //                 $('#calendarTitle').text(selectedMonth);
    //             }
    //         });
    //     });

    flatpickr("#hariPicker", {
    dateFormat: "l", // Menampilkan nama hari
    altFormat: "Y-m-d", // Format tanggal alternatif
    altInput: true, // Mengaktifkan input tanggal alternatif
    defaultDate: "today" // Set default tanggal ke hari ini
  });

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
</script>


@endsection




