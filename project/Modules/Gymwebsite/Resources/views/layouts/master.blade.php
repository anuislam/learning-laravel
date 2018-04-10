@php
$genarel = get_option('genarel');
$header_settings = get_option('header_settings');
$logo_image = $media->get_image_src('header_logo', $header_settings['header_logo']);
@endphp
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('page_title') | {{ @$genarel['site_title'] }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{@$genarel['site_desc']}}" />
	<meta name="keywords" content="{{@$genarel['keywords']}}" />
	<meta name="author" content="{{@$genarel['site_author']}}" />


  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">	


		{{ do_action('site_header') }}
		@yield('style')
	</head>
	<body>

		<div id="fh5co-wrapper">
		<div id="fh5co-page">


			<!-- Header -->
		@include('gymwebsite::inc.header')
		<!-- end:fh5co-header -->

		@yield('main_content')

		<!-- fh5co-blog-section -->	
		@include('gymwebsite::inc.footer')
	</div>
	<!-- END fh5co-page -->

	</div>
	<!-- END fh5co-wrapper -->


	<div id="joinnowmodal" class="modal fade" role="dialog">
	<div class="modal-dialog">		
	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	    <h4 class="modal-title"></h4>
	  </div>
	  <div class="modal-body">

	<div class="print-error-msg" style="display: block;">
			<ul style="text-decoration: none;list-style: none;padding: 0;">
			</ul>
		</div>
			<div class="form-group">
				{!! Form::label( 'joinemail', 'Email address') !!}
				{!! Form::email( 'joinemail' , '', ['class' => 'form-control','placeholder' => 'Email address'] ) !!}
			</div>
			<div class="form-group">
				{!! Form::label( 'joinmobile', 'Mobile') !!}
				{!! Form::number( 'joinmobile' , '', ['class' => 'form-control','placeholder' => 'Mobile'] ) !!}		
			</div>		
			<div class="form-group">			
				{!! Form::label( 'joinmessage', 'Message') !!}
				{!! Form::textarea( 'joinmessage' , '', ['class' => 'form-control','placeholder' => 'Message'] ) !!}		
			</div>					
	      </div>
	      <div class="modal-footer">

	      	{!! Form::submit('Cancel', [
		      	'class' => 'btn btn-default pull-left',
		      	'data-dismiss' => 'modal',
		      	]) !!}
	      	{!! Form::submit('Send', [
		      	'class' => 'btn btn-default',
		      	'id' => 'joinsendmessage',
		      	]) !!}
	      </div>
	    </div>

	  </div>
	</div>

	
  <script>
    var global_data = {
      	token : '{{ csrf_token() }}',
     	ajax_url : '{{ route("ajax_url") }}',
      	upload_dir_url : '{{ upload_dir_url() }}',
    }
  </script>

	  	{{ do_action('site_footer') }}
  		@yield('script')

	</body>
</html>

