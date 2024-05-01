
<script>

      // Tambah Update
      $(document).on('click', '#btnTambahDataManual', function(e){
        e.preventDefault()
        flatpickr("#tanggalData", {
            dateFormat: "Y-m-d",
            defaultDate: new Date(),
        });

        $('#modalTambahHarian').modal('show');
      });


      $(document).ready(function () {
            $("#submitDataManual").click(function (e) {
                e.preventDefault();

                let tanggalData = $('#tanggalData').val();
                let jenisTransaksi = $('input[name="jenisTransaksi"]:checked').val();
                if (jenisTransaksi === "pemasukan") {
                    jenisTransaksi = "Masuk";
                } else if (jenisTransaksi === "pengeluaran") {
                    jenisTransaksi = "Keluar";
                }
                let pelanggan =  $('#pelanggan').val();
                let keterangan =  $('#keterangan').val();
                let noresi =  $('#noResi').val();
                let nominal =  $('#harga').val();
                let pajak =  $('#pajak').val();
                let pembayaran =  $('#pembayaran').val();
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
                            url: "{{route('tambahData')}}",
                            data: {
                                tanggal : tanggalData,
                                jenistransaksi : jenisTransaksi,
                                pelanggan : pelanggan,
                                keterangan : keterangan,
                                noresi : noresi,
                                nominal : nominal,
                                pajak : pajak,
                                pembayaran : pembayaran,
                                _token : csrfToken
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Tambah Data",
                                        icon: "success"
                                    });
                                    getListDataHarian();
                                    $('#modalTambahHarian').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Data",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });


        // EDITDATA

        $(document).on('click', '.btnEdiDataHarian', function(e){
            e.preventDefault()

            let id = $(this).data('id');
            let tanggal = $(this).data('tanggal');
            let jenisbayar = $(this).data('jenisbayar');
            let pelanggan = $(this).data('pelanggan');
            let keterangan = $(this).data('keterangan');
            let noresi = $(this).data('noresi');
            let nominal = $(this).data('nominal');
            let pajak = $(this).data('pajak');
            let pembayaran = $(this).data('pembayaran');

            flatpickr("#tanggalDataEdit", {
                dateFormat: "Y-m-d",
                defaultDate: tanggal,
            });


            $('#editDataId').val(id);
            $('#tanggalDataEdit').val(tanggal);
            $('#pelangganEdit').val(pelanggan);
            $('#keteranganEdit').val(keterangan);
            $('#noResiEdit').val(noresi);
            $('#hargaEdit').val(nominal);
            $('#pajakEdit').val(pajak);
            $('#pembayaranEdit').val(pembayaran);

            if (jenisbayar === 'Masuk') {
                    $('#pemasukanEdit').prop('checked', true);
                } else if (jenisbayar === 'Keluar') {
                    $('#pengeluaranEdit').prop('checked', true);
                }


            $('#modalEditHarian').modal('show');
        });


      $(document).ready(function () {
            $("#submitEditDataManual").click(function (e) {
                e.preventDefault();

                let idEdit =  $('#editDataId').val();
                let tanggalDataEdit = $('#tanggalDataEdit').val();
                let jenisTransaksiEdit = $('input[name="jenisTransaksiEdit"]:checked').val();
                if (jenisTransaksiEdit === "pemasukan") {
                    jenisTransaksiEdit = "Masuk";
                } else if (jenisTransaksiEdit === "pengeluaran") {
                    jenisTransaksiEdit = "Keluar";
                }
                let pelangganEdit =  $('#pelangganEdit').val();
                let keteranganEdit =  $('#keteranganEdit').val();
                let noResiEdit =  $('#noResiEdit').val();
                let hargaEdit =  $('#hargaEdit').val();
                let pajakEdit =  $('#pajakEdit').val();
                let pembayaranEdit =  $('#pembayaranEdit').val();
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
                            url: "{{route('updateData')}}",
                            data: {
                                id : idEdit,
                                tanggal : tanggalDataEdit,
                                jenistransaksi : jenisTransaksiEdit,
                                pelanggan : pelangganEdit,
                                keterangan : keteranganEdit,
                                noresi : noResiEdit,
                                nominal : hargaEdit,
                                pajak : pajakEdit,
                                pembayaran : pembayaranEdit,
                                _token : csrfToken
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Update Data",
                                        icon: "success"
                                    });
                                    getListDataHarian();
                                    $('#modalEditHarian').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal Update Data",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });

        $(document).on('click', '.btnDeleteDataHarian', function(e){
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
                            url: "{{route('hapusData')}}",
                            data: {
                                id : id,
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil Menghapus Data",
                                        icon: "success"
                                    });
                                    getListDataHarian();
                                } else {
                                    Swal.fire({
                                        title: "Gagal Menambahkan Data",
                                        icon: "error"
                                    });
                                }
                            }
                        });
                    }
                })
            });


</script>
