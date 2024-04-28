@extends('layout.header')

@section('title', 'Tagihan')

@section('main')

<div class="container-fluid">

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
            {{-- Filter Hari --}}
            <input type="text" id="hariPicker" placeholder="Pilih hari">
            {{-- Reset --}}
            <button type="button" class="btn btn-outline-secondary" id="btnResetDefault" onclick="window.location.reload()">
                    Reset
            </button>
        </div>
        <div class="d-flex gap-3">
            <button type="button" id="btnTambahTagihan" class="btn btn-primary">Export Tagihan</button>
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


</script>


@endsection




