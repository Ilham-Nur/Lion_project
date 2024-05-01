@extends('layout.header')

@section('title', 'Dashboard')

@section('main')

<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
              <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Chart Pendapatan</h5>
              </div>
              <div class="d-flex align-items-center gap-1">
                <button id="monthEvent" class="btn btn-light form-control"  style="border: 1px solid #e9ecef;">
                    <span id="calendarTitle" class="fs-4"></span>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnResetDefault" onclick="window.location.reload()">
                    Reset
                </button>
            </div>
            </div>
            <div id="chart" style="width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-lg-4">
        <div class="card" style="background-color: rgb(139, 250, 200);">
          <div class="card-body p-4">
            <h5 class="card-title mb-9 fw-semibold">Total Uang Masuk</h5>
            <div class="row align-items-center">
              <div class="col-8">
                <h4 class="fw-semibold mb-3" id="pemasukandata">-</h4>
                {{-- <div class="d-flex align-items-center mb-3">
                  <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-up-left text-success"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">Bulan sebelumnya</p>
                </div> --}}
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="background-color: rgb(250, 139, 139);">
          <div class="card-body">
            <div class="row align-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">Total Uang Keluar</h5>
                <h4 class="fw-semibold" id="pengeluaranData">-</h4>
                {{-- <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-down-right text-danger"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">Bulan sebelumnya</p>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card" style="background-color: rgb(250, 230, 139);">
          <div class="card-body">
            <div class="row align-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">Total Tagihan</h5>
                <h4 class="fw-semibold"  id="totalTagihanData">-</h4>
                {{-- <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-down-right text-danger"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">Bulan sebelumnya</p>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>






@endsection

@section('script')
<script>

        function getCurrentMonth() {
                const months = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];

                const currentDate = new Date();
                const currentMonth = months[currentDate.getMonth()];
                const currentYear = currentDate.getFullYear();

                return `${currentMonth} ${currentYear}`;
            }

            let selectedMonth = '';

            document.addEventListener('DOMContentLoaded', function() {
                const calendarTitle = document.getElementById('calendarTitle');
                calendarTitle.textContent = getCurrentMonth();
            });


            const monthFilterInput = document.getElementById('monthEvent');

            const flatpickrInstance = flatpickr(monthFilterInput, {
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "M Y",
                        altFormat: "M Y",
                        theme: "light"
                    })
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    const selectedDate = selectedDates[0];
                    selectedMonth = instance.formatDate(selectedDate, "M Y");
                    const calendarTitle = document.getElementById('calendarTitle');
                    calendarTitle.textContent = selectedMonth;
                    getDataDashboard();
                }
            });


            const getDataDashboard = () => {
                $.ajax({
                        type: "GET",
                        url: "{{ route('getDataCard') }}",
                        data: {
                            filter: selectedMonth
                        },
                        success: function(response) {
                            // Update total uang masuk
                            $('#pemasukandata').empty();
                            $('#pemasukandata').append("Rp. " + (response.pemasukan ? parseInt(response.pemasukan).toLocaleString() : "-"));

                            // Update total uang keluar
                            $('#pengeluaranData').empty();
                            $('#pengeluaranData').append("Rp. " + (response.pengeluaran ? parseInt(response.pengeluaran).toLocaleString() : "-"));

                            // Update total tagihan
                            $('#totalTagihanData').empty();
                            $('#totalTagihanData').append("Rp. " + (response.total_tagihan ? parseInt(response.total_tagihan).toLocaleString() : "-"));
                        }
                    });

            $.ajax({
                type: "GET",
                url: "{{ route('getchartdata') }}",
                data: {
                    filter: selectedMonth
                },
                success: function(response) {
                    var formattedData = response.map(function(item) {
                        return {
                            x: new Date(item.tanggal).getTime(),
                            y: parseFloat(item.saldo_harian)
                        };
                    });

                    chart.updateSeries([{
                        name: 'chartData',
                        data: formattedData
                    }]);
                }
            });
        }

        getDataDashboard();





    var options = {
        series: [{
            name: 'chartData',
            data: []
        }],
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        xaxis: {
        type: 'datetime',
        labels: {

            style: {
                colors: '#8e8da4'
            }
        }
    },

        yaxis: {
            tickAmount: 4,
            floating: false,
            labels: {
                style: {
                    colors: '#8e8da4',
                },
                offsetY: -7,
                offsetX: 0,
                formatter: function (val) {
                    return "Rp" + val.toLocaleString(); // format uang
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            opacity: 0.5
        },
        tooltip: {
            x: {
                format: "dd ", // format tanggal yang sesuai
            },
            fixed: {
                enabled: false,
                position: 'topRight'
            }
        },
        grid: {
            yaxis: {
                lines: {
                    offsetX: -30
                }
            },
            padding: {
                left: 20
            }
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();


</script>

@endsection














