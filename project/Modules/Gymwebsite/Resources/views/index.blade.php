@php
$genarel = get_option('genarel');
$header_settings = get_option('header_settings');
$home_settings = get_option('home_settings');
@endphp

@extends('gymwebsite::layouts.master')

@section('page_title')
   Gym Website
@stop

@section('main_content')

		@include('gymwebsite::inc.slider')

		<!-- end:fh5co-hero -->

		@include('gymwebsite::inc.schedule')

		<!-- end:fh5co-SCHEDULE -->


		@include('gymwebsite::inc.commit')

		@include('gymwebsite::inc.ourprograms')

		@include('gymwebsite::inc.trainer')

		@include('gymwebsite::inc.fitnessclasess')

		@include('gymwebsite::inc.priceing')

		@include('gymwebsite::inc.blogsection')
		
@stop
