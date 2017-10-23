<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>@yield('dashboard_tab_title') | Blog</title>
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('public') }}/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="{{ asset('public') }}/admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="{{ asset('public') }}/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('public') }}/admin/css/sb-admin.css" rel="stylesheet">
  <link href="{{ asset('public') }}/admin/css/main.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    
    @include('admin.inc.adminlogo')

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">


    @include('admin.inc.dashboardmenu')
    @include('admin.inc.sidenavtoggler')
    @include('admin.inc.dashboardheader')

    </div>
  </nav>

  <!-- Start dashboard content -->

  <div class="content-wrapper">
    <div class="container-fluid">

    @yield('dashboard_content')

    @include('admin.inc.footer')
    </div>
  </div>
  <!-- Modal-->
@include('admin.inc.globalmodal')

  <!-- End dashborad content -->

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('public') }}/admin/vendor/jquery/jquery.min.js"></script>
  <script src="{{ asset('public') }}/admin/vendor/popper/popper.min.js"></script>
  <script src="{{ asset('public') }}/admin/vendor/bootstrap/js/bootstrap.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('public') }}/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="{{ asset('public') }}/admin/vendor/chart.js/Chart.min.js"></script>
  <script src="{{ asset('public') }}/admin/vendor/datatables/jquery.dataTables.js"></script>
  <script src="{{ asset('public') }}/admin/vendor/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('public') }}/admin/js/sb-admin.min.js"></script>
  <!-- Custom scripts for this page-->
  <script src="{{ asset('public') }}/admin/js/sb-admin-datatables.min.js"></script>
  <script src="{{ asset('public') }}/admin/js/sb-admin-charts.min.js"></script>
  <script src="{{ asset('public') }}/admin/js/custom_plugin.js"></script>
  <script src="{{ asset('public') }}/admin/js/main.js"></script>

</body>

</html>
