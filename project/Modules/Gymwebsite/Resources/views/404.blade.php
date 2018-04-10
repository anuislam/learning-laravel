@php
$page404 = get_option('not_found_page');
@endphp


@extends('gymwebsite::layouts.master')

@section('page_title')
   404. Page Not Found
@stop

@section('main_content')

<!-- end:fh5co-header -->
<div class="fh5co-parallax" style="background-image: url({!! sanitize_url($media->get_image_src('header_slider', $page404['page_bg_image'])[0]) !!});" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center fh5co-table">
				<div class="fh5co-intro fh5co-table-cell animate-box">
					<h1 class="text-center">{{ $page404['page_title'] }}</h1>
					<p>{{ $page404['page_short_desc'] }}</p>
				</div>
			</div>
		</div>
	</div>
</div><!-- end: fh5co-parallax -->

<div id="fh5co-team-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="heading-section text-center animate-box">
					<h2>{{ $page404['page_sec_title'] }}</h2>
					<p>{{ $page404['page_sec_desc'] }}</p>
				</div>
			</div>
		</div>
		<div class="row text-center">
			<p>{{ $page404['page_sec_content'] }}</p>
			<a class="btn btn-primary" href="{{url('/')}}">{{ $page404['page_button_title'] }}</a>
		</div>
	</div>
</div>	
		


@stop
