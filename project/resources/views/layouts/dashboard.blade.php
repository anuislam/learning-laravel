<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>@yield('dashboard_tab_title')</title>
  <!-- Bootstrap core CSS-->
  {{ Html::style(asset('public').'/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
  <!-- Custom fonts for this template-->
   {{ Html::style(asset('public').'/admin/bower_components/font-awesome/css/font-awesome.min.css') }}
  <!-- Page level plugin CSS-->
  {{ Html::style(asset('public').'/admin/bower_components/Ionicons/css/ionicons.min.css') }}
  {{ Html::style(asset('public').'/admin/dist/css/AdminLTE.min.css') }}
  {{ Html::style(asset('public').'/admin/dist/css/skins/_all-skins.min.css') }}
  {{ Html::style(asset('public').'/admin/bower_components/morris.js/morris.css') }}
  {{ Html::style(asset('public').'/admin/bower_components/jvectormap/jquery-jvectormap.css') }}
  {{ Html::style(asset('public').'/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
  {{ Html::style(asset('public').'/admin/bower_components/select2/dist/css/select2.min.css') }}
  {{ Html::style(asset('public').'/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}

  {{ Html::style(asset('public').'/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
  {{ Html::style(asset('public').'/admin/dist/css/AdminLTE.min.css') }}
  <!-- Custom styles for this template-->
  {{ Html::style(asset('public').'/admin/css/upload.css') }}
  {{ Html::style(asset('public').'/admin/css/main.css') }}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    {{ Html::style('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}
    {{ Html::style('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}
  <![endif]-->
  {{ Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">') }}


  @yield('style')
</head>

<body class="hold-transition skin-blue sidebar-mini">



<div class="wrapper">


  <header class="main-header">
    <!-- Logo -->

      @include('admin.inc.adminlogo')

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">

        @include('admin.inc.dashboardheader')

      </div>
    </nav>
  </header>

@include('admin.inc.dashboardmenu')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

     @yield('dashboard_content')

  </div>

    @include('admin.inc.footer')
</div>


  <!-- Modal-->
@include('admin.inc.globalmodal')

  <!-- End dashborad content -->

  <!-- Bootstrap core JavaScript-->
  <script>
    var global_data = {
      token : '{{ csrf_token() }}',
      media_uploade_image_url : '{{ route("get-uploder") }}',
      media_uploade_search_url : '{{ route("search-uploder") }}',
      media_uploade_delete_url : '{{ route("delete-uploder") }}',
      upload_dir_url : '{{ upload_dir_url() }}',
    }
  </script>

  {{ Html::script(asset('public').'/admin/bower_components/jquery/dist/jquery.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/jquery-ui/jquery-ui.min.js', ['type' => 'text/javascript']) }}
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
  {{ Html::script(asset('public').'/admin/bower_components/bootstrap/dist/js/bootstrap.min.js', ['type' => 'text/javascript']) }}
  <!-- Core plugin JavaScript-->
  {{ Html::script(asset('public').'/admin/bower_components/raphael/raphael.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/morris.js/morris.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/jquery-knob/dist/jquery.knob.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/moment/min/moment.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', ['type' => 'text/javascript']) }}

  {{ Html::script(asset('public').'/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/plugins/iCheck/icheck.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/fastclick/lib/fastclick.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/select2/dist/js/select2.full.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/datatables.net/js/jquery.dataTables.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js', ['type' => 'text/javascript']) }}

  {{ Html::script(asset('public').'/admin/bower_components/tinymce/tinymce.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/dist/js/adminlte.min.js', ['type' => 'text/javascript']) }}
  <!-- Page level plugin JavaScript-->

  {{ Html::script(asset('public').'/admin/js/core.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/uploader_plugin.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/media-uploader.js', ['type' => 'text/javascript']) }}

  @yield('script')
  {{ Html::script(asset('public').'/admin/js/custom_plugin.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/main.js', ['type' => 'text/javascript']) }}
</body>

</html>
