@php
$genarel = get_option('genarel');
$header_settings = get_option('header_settings');
$home_settings = get_option('home_settings');
@endphp

@extends('gymwebsite::layouts.master')

@section('page_title')
   {{$post->post_title}}
@stop

@section('main_content')

@include('gymwebsite::inc.page_header')

		<div id="fh5co-team-section" style="padding-bottom: 50px;">
			<div class="container">
				<div class="row about" style="padding-bottom: 0;">
					<div class="col-md-12 col-md-offset-0 animate-box">
						{!! $post->post_content !!}
					</div>
				</div>
			</div>
		</div>	
		
@stop
