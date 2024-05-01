<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('dashboard/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('dashboard/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/monthSelect.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fixedColumns.dataTables.min.css') }}">
  <script src="{{ asset('dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
</head>

<body>

  @yield('content')
  <script src="{{ asset('dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/flatpickr.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/monthSelect.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/apexcharts.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dataTables.fixedColumns.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('dashboard/js/app.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>

  @yield('script')

</body>

</html>
