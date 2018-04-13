<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title_tag')</title>

  
      {{ do_action('site_header') }}

    @yield('style')

</head>
<body>
<!-- Header - start -->
@include('allstor::template.header')

<!-- Header - end -->


<!-- Main Content - start -->

<main>
  <section class="container">
    @yield('main_content')
  </section>
</main>
<!-- Main Content - end -->

<!-- Footer - start -->
@include('allstor::template.footer')

<!-- Footer - end -->



  {{ do_action('site_footer') }}
  @yield('script')
<!-- jQuery plugins/scripts - end -->

</body>
</html>