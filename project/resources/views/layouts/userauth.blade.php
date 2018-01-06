<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('auth_tab_title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  {{ Html::style(asset('/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')) }}
  {{ Html::style(asset('/admin/bower_components/font-awesome/css/font-awesome.min.css')) }}
  {{ Html::style(asset('/admin/bower_components/Ionicons/css/ionicons.min.css')) }}
  {{ Html::style(asset('/admin/dist/css/AdminLTE.min.css')) }}
  {{ Html::style(asset('/admin/plugins/iCheck/square/blue.css')) }}


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    {{ Html::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', ['type' => 'text/javascript']) }}
    {{ Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js', ['type' => 'text/javascript']) }}
  <![endif]-->

  <!-- Google Font -->
  {{ Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') }}

</head>
<body class="hold-transition login-page">

<section class="content" style="min-height: 10px">
    @if(Session::get('error_msg'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      {{ Session::get('error_msg') }}
    </div>

    @endif

    @if(Session::get('success_msg'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        {{ Session::get('success_msg') }}
      </div>
    @endif
</section>

<div class="login-box">
  <div class="login-logo">
    @yield('auth_title')
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    @yield('auth_content')

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
{{ Html::script( asset('/admin/bower_components/jquery/dist/jquery.min.js'), ['type' => 'text/javascript']) }}
<!-- Bootstrap 3.3.7 -->
{{ Html::script(asset('/admin/bower_components/bootstrap/dist/js/bootstrap.min.js'), ['type' => 'text/javascript']) }}
<!-- iCheck -->
{{ Html::script(asset('/admin/plugins/iCheck/icheck.min.js'), ['type' => 'text/javascript']) }}
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
