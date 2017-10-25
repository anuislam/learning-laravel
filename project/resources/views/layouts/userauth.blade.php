<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>@yield('auth_tab_title') | Blog</title>
  <!-- Bootstrap core CSS-->
  {{ Html::style(asset('public').'/admin/vendor/bootstrap/css/bootstrap.min.css') }}
  {{ Html::style(asset('public').'/admin/vendor/font-awesome/css/font-awesome.min.css') }}
  {{ Html::style(asset('public').'/admin/css/sb-admin.css') }}
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">@yield('auth_title')</div>

      @yield('auth_content')

    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
    {{ Html::script(asset('public').'/admin/vendor/jquery/jquery.min.js', ['type' => 'text/javascript']) }}
    {{ Html::script(asset('public').'/admin/vendor/popper/popper.min.js', ['type' => 'text/javascript']) }}
    {{ Html::script(asset('public').'/admin/vendor/bootstrap/js/bootstrap.min.js', ['type' => 'text/javascript']) }}
  
  <!-- Core plugin JavaScript-->
    {{ Html::script(asset('public').'/admin/vendor/jquery-easing/jquery.easing.min.js', ['type' => 'text/javascript']) }}
</body>

</html>
