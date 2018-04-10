@php
$genarel = get_option('genarel');
$header_settings = get_option('header_settings');
$home_settings = get_option('home_settings');
$contact_us_page = get_option('contact_us_page');
@endphp

@extends('gymwebsite::layouts.master')

@section('page_title')
   {{$post->post_title}}
@stop

@section('main_content')
@include('gymwebsite::inc.page_header')

<div id="fh5co-contact">
	<div class="container">		
			{{Form::open(['url' =>  route('send_mail'), 'method' => 'POST'])}}
			<div class="row">
				<div class="col-md-6 animate-box">
					{!! $contact_us_page['addr_content'] !!}
<!-- 
					<h3 class="section-title">Our Address</h3>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					<ul class="contact-info">
						<li><i class="icon-location-pin"></i>198 West 21th Street, Suite 721 New York NY 10016</li>
						<li><i class="icon-phone2"></i>+ 1235 2355 98</li>
						<li><i class="icon-mail"></i><a href="#">info@yoursite.com</a></li>
						<li><i class="icon-globe2"></i><a href="#">www.yoursite.com</a></li>
					</ul> -->
					
				</div>
				<div class="col-md-6 animate-box">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								{{ Form::text(  'name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name'] ) }}
								@if ($errors->has('name'))
									<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
								{{ Form::email(  'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email'] ) }}
								@if ($errors->has('email'))
									<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif								
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group  {{ $errors->has('message') ? 'has-error' : '' }}">
								{{Form::textarea(  'message', old('message'), ['class' => 'form-control', 'placeholder' => 'Message', 'cols' => '30', 'rows' => '7'] )}}
								@if ($errors->has('message'))
									<span class="help-block">
									<strong>{{ $errors->first('message') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								{{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
							</div>
						</div>
					</div>
        @if(Session::get('send_mail'))
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ Session::get('send_mail') }}
					</div>
				</div>
			</div>
        @endif

        @if(Session::get('error_send_mail'))
	        <div class="row">
	        	<div class="col-md-12">
			        <div class="alert alert-danger alert-dismissible">
			          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			          {{ Session::get('error_send_mail') }}
			        </div>
		        </div>
	        </div>
	    @endif
				</div>
			</div>
		{{Form::close()}}
	</div>
</div>

<!-- END fh5co-contact -->

<div id="map" class="fh5co-map"></div>

<!-- END map -->
@stop


@section('script')
	{!! Html::script('//maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false', ['type' => 'text/javascript']) !!}
	{!! Html::script(Module::asset('gymwebsite:js/google_map.js'), ['type' => 'text/javascript']) !!}
@stop