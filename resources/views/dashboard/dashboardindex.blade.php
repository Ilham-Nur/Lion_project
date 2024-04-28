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
              <div>
                <select class="form-select">
                  <option value="1">March 2023</option>
                  <option value="2">April 2023</option>
                  <option value="3">May 2023</option>
                  <option value="4">June 2023</option>
                </select>
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
     var options = {
          series: [{
          name: 'April',
          data: [{
              x: 1996,
              y: 322
            },
            {
              x: 1997,
              y: 324
            },
            {
              x: 1998,
              y: 329
            },
            {
              x: 1999,
              y: 342
            },
            {
              x: 2000,
              y: 348
            },
            {
              x: 2001,
              y: 334
            },
            {
              x: 2002,
              y: 325
            },
            {
              x: 2003,
              y: 316
            },
            {
              x: 2004,
              y: 318
            },
            {
              x: 2005,
              y: 330
            },
            {
              x: 2006,
              y: 355
            },
            {
              x: 2007,
              y: 366
            },
            {
              x: 2008,
              y: 337
            },
            {
              x: 2009,
              y: 352
            },
            {
              x: 2010,
              y: 377
            },
            {
              x: 2011,
              y: 383
            },
            {
              x: 2012,
              y: 344
            },
            {
              x: 2013,
              y: 366
            },
            {
              x: 2014,
              y: 389
            },
            {
              x: 2015,
              y: 334
            }
          ]
        }],
          chart: {
          type: 'area',
          height: 350 ,
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
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
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
            format: "yyyy",
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














