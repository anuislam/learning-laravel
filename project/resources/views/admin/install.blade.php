
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Install | AS CMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  {{ Html::style(asset('').'/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
  {{ Html::style(asset('').'/admin/bower_components/font-awesome/css/font-awesome.min.css') }}
  {{ Html::style(asset('').'/admin/dist/css/AdminLTE.min.css') }}
  {{ Html::style(asset('').'/admin/plugins/iCheck/square/blue.css') }}


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  	{{ Html::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', ['type' => 'text/javascript']) }}
  	{{ Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js', ['type' => 'text/javascript']) }}
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>AS</b>CMS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Install AS CMS</p>

    <form action="#" method="post">
      <div class="form-group has-feedback">
        <label for="db_name">Database Name</label>
        <input type="text" id="db_name" class="form-control" placeholder="Database Name">
      </div>
      <div class="form-group has-feedback">
        <label for="db_user">Database Username</label>
        <input type="text" id="db_user" class="form-control" placeholder="Database Username">
      </div>
      <div class="form-group has-feedback">
        <label for="db_pass">Database Password</label>
        <input type="password" id="db_pass" class="form-control" placeholder="Database Password">
      </div>
      <div class="form-group has-feedback">
        <label for="db_host">Database Host</label>
        <input type="text" id="db_host" class="form-control" placeholder="Database Host">
      </div>
      <div class="form-group has-feedback">
        <label for="db_prefix">Table Prefix</label>
        <input type="text" id="db_prefix" class="form-control" placeholder="Table Prefix">
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
  {{ Html::script(asset('').'/admin/bower_components/jquery/dist/jquery.min.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('').'/admin/bower_components/bootstrap/dist/js/bootstrap.min.js', ['type' => 'text/javascript']) }}

</body>
</html>
