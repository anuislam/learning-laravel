<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $__env->yieldContent('dashboard_tab_title'); ?></title>
  <!-- Bootstrap core CSS-->
  <?php echo e(Html::style(asset('').'/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>

  <!-- Custom fonts for this template-->
   <?php echo e(Html::style(asset('').'/admin/bower_components/font-awesome/css/font-awesome.min.css')); ?>

  <!-- Page level plugin CSS-->
  <?php echo e(Html::style(asset('').'/admin/bower_components/Ionicons/css/ionicons.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/dist/css/AdminLTE.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/dist/css/skins/_all-skins.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/bower_components/morris.js/morris.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/bower_components/jvectormap/jquery-jvectormap.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/bower_components/select2/dist/css/select2.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')); ?>


  <?php echo e(Html::style(asset('').'/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>

  <?php echo e(Html::style(asset('').'/admin/dist/css/AdminLTE.min.css')); ?>

  <!-- Custom styles for this template-->
  <?php echo e(Html::style(asset('').'/admin/css/upload.css')); ?>


  <?php echo e(Html::style(asset('').'/admin/nestablemenu/style.css')); ?>


  <?php echo e(Html::style(asset('').'/admin/css/main.css')); ?>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <?php echo e(Html::style('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js')); ?>

    <?php echo e(Html::style('https://oss.maxcdn.com/respond/1.4.2/respond.min.js')); ?>

  <![endif]-->
  <?php echo e(Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">')); ?>



  <?php echo $__env->yieldContent('style'); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">



<div class="wrapper">


  <header class="main-header">
    <!-- Logo -->

      <?php echo $__env->make('admin.inc.adminlogo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">

        <?php echo $__env->make('admin.inc.dashboardheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      </div>
    </nav>
  </header>

<?php echo $__env->make('admin.inc.dashboardmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

     <?php echo $__env->yieldContent('dashboard_content'); ?>

  </div>

    <?php echo $__env->make('admin.inc.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>


  <!-- Modal-->
<?php echo $__env->make('admin.inc.globalmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <!-- End dashborad content -->

  <!-- Bootstrap core JavaScript-->
  <script>
    var global_data = {
      token : '<?php echo e(csrf_token()); ?>',
      media_uploade_image_url : '<?php echo e(route("get-uploder")); ?>',
      media_uploade_search_url : '<?php echo e(route("search-uploder")); ?>',
      media_uploade_delete_url : '<?php echo e(route("delete-uploder")); ?>',
      add_menu_item : '<?php echo e(route("add_menu_item")); ?>',
      delete_menu_item : '<?php echo e(route("delete_menu_item")); ?>',
      upload_dir_url : '<?php echo e(upload_dir_url()); ?>',
    }
  </script>

  <?php echo e(Html::script(asset('').'/admin/bower_components/jquery/dist/jquery.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/jquery-ui/jquery-ui.min.js', ['type' => 'text/javascript'])); ?>

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
  <?php echo e(Html::script(asset('').'/admin/bower_components/bootstrap/dist/js/bootstrap.min.js', ['type' => 'text/javascript'])); ?>

  <!-- Core plugin JavaScript-->
  <?php echo e(Html::script(asset('').'/admin/bower_components/raphael/raphael.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/morris.js/morris.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/jquery-knob/dist/jquery.knob.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/moment/min/moment.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', ['type' => 'text/javascript'])); ?>


  <?php echo e(Html::script(asset('').'/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/plugins/iCheck/icheck.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/fastclick/lib/fastclick.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/select2/dist/js/select2.full.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/datatables.net/js/jquery.dataTables.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js', ['type' => 'text/javascript'])); ?>


  <?php echo e(Html::script(asset('').'/admin/bower_components/tinymce/tinymce.min.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/js/tinymcesetup.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/dist/js/adminlte.min.js', ['type' => 'text/javascript'])); ?>

  <!-- Page level plugin JavaScript-->

  <?php echo e(Html::script(asset('').'/admin/js/core.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/js/uploader_plugin.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/js/media-uploader.js', ['type' => 'text/javascript'])); ?>


  <?php echo e(Html::script(asset('').'/admin/nestablemenu/jquery.nestable.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/nestablemenu/jquery.nestable-custom.js', ['type' => 'text/javascript'])); ?>

  <?php echo $__env->yieldContent('script'); ?>
  <?php echo e(Html::script(asset('').'/admin/js/custom_plugin.js', ['type' => 'text/javascript'])); ?>

  <?php echo e(Html::script(asset('').'/admin/js/main.js', ['type' => 'text/javascript'])); ?>

</body>

</html>
