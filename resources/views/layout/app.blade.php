<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('dashboard/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('dashboard/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fixedColumns.dataTables.min.css') }}">
  <script src="{{ asset('dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
  <script src="{{ asset('dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dataTables.fixedColumns.min.js') }}"></script>
  <script src="{{ asset('dashboard/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('dashboard/js/app.min.js') }}"></script>
  <script src="{{ asset('dashboard/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('dashboard/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('dashboard/js/dashboard.js') }}"></script>
@yield('content')

</body>

</html>
