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
      <div class="col-lg-6">
        <!-- Monthly Breakup -->
        <div class="card overflow-hidden">
          <div class="card-body p-4">
            <h5 class="card-title mb-9 fw-semibold">Total Uang Masuk Bulan Ini</h5>
            <div class="row align-items-center">
              <div class="col-8">
                <h4 class="fw-semibold mb-3">Rp. 4.000.000</h4>
                <div class="d-flex align-items-center mb-3">
                  <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-up-left text-success"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">Bulan sebelumnya</p>
                </div>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-center">
                  <div id="breakup"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-start">
              <div class="col-8">
                <h5 class="card-title mb-9 fw-semibold">Total Uang Keluar Bulan Ini</h5>
                <h4 class="fw-semibold mb-3">Rp. 2.000.000</h4>
                <div class="d-flex align-items-center pb-1">
                  <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                    <i class="ti ti-arrow-down-right text-danger"></i>
                  </span>
                  <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                  <p class="fs-3 mb-0">Bulan sebelumnya</p>
                </div>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                </div>
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
  var datesArray = [];
    for (var i = 1; i <= 30; i++) {
        var currentDate = new Date(2024, 3, i);
        var randomY = Math.floor(Math.random() * (1000000 - 500000 + 1)) + 500000;
        datesArray.push({
            x: currentDate,
            y: randomY
        });
    }

var options = {
    series: [{
        name: 'April',
        data: datesArray
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
        datetimeUTC: false, // non-UTC datetime
        format: 'dd MMM', // format tanggal yang sesuai
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
            format: "dd MMM", // format tanggal yang sesuai
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

            const selectedMonth = instance.formatDate(selectedDate, "M Y");

            const calendarTitle = document.getElementById('calendarTitle');
            calendarTitle.textContent = selectedMonth;
        }
    });



</script>

@endsection














