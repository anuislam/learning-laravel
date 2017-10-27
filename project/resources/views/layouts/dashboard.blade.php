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
  {{ Html::style(asset('public').'/admin/vendor/bootstrap/css/bootstrap.min.css') }}
  <!-- Custom fonts for this template-->
   {{ Html::style(asset('public').'/admin/vendor/font-awesome/css/font-awesome.min.css') }}
  <!-- Page level plugin CSS-->
  {{ Html::style(asset('public').'/admin/vendor/datatables/dataTables.bootstrap4.css') }}
  <!-- Custom styles for this template-->
  {{ Html::style(asset('public').'/admin/css/sb-admin.css') }}
  {{ Html::style(asset('public').'/admin/css/main.css') }}
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
  <script>
    var global_data = {
      data_table_url : '{{ route("user-datatable") }}',
      token : '{{ csrf_token() }}',
    }
  </script>

  {{ Html::script(asset('public').'/admin/vendor/jquery/jquery.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/vendor/popper/popper.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/vendor/bootstrap/js/bootstrap.min.js', ['type' => 'text/javascript']) }}
  <!-- Core plugin JavaScript-->
  {{ Html::script(asset('public').'/admin/vendor/jquery-easing/jquery.easing.min.js', ['type' => 'text/javascript']) }}
  <!-- Page level plugin JavaScript-->
  {{ Html::script(asset('public').'/admin/vendor/chart.js/Chart.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/vendor/datatables/jquery.dataTables.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/vendor/datatables/dataTables.bootstrap4.js', ['type' => 'text/javascript']) }}
  <!-- Custom scripts for all pages-->
  {{ Html::script(asset('public').'/admin/js/sb-admin.min.js', ['type' => 'text/javascript']) }}
  <!-- Custom scripts for this page-->
  {{ Html::script(asset('public').'/admin/js/sb-admin-datatables.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/sb-admin-charts.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/custom_plugin.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/main.js', ['type' => 'text/javascript']) }}


</body>

</html>
