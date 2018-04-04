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

		<div id="fh5co-schedule-section" class="fh5co-lightgray-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="heading-section text-center animate-box">
							<h2>{{$home_settings['class_sec_titile']}}</h2>
							<p>{{$home_settings['class_sec_desc']}}</p>
						</div>
					</div>
				</div>
				<div class="row animate-box">
					<div class="col-md-10 col-md-offset-1 text-center">
						<ul class="schedule">
							@foreach($class_cat as $ckey => $class)
								<li><a href="#" @php
										echo ($loop->index == 0) ? 'class="active"' : '' ;
									@endphp data-sched="date{{$ckey}}">{{$class}}</a></li>		
							@endforeach
						</ul>
					</div>
					<div class="row text-center">
						<div class="col-md-12 schedule-container">

							@foreach($class_data as $ckey => $class)	

							<div class="schedule-content @php
									echo ($loop->index == 0) ? 'active' : '' ;
								@endphp" data-day="date{{$ckey}}">

								@foreach($class['post_data'] as $postkey => $postlass)
								<div class="col-md-3 col-sm-6">
									<div class="program program-schedule">
										<img src="{!! upload_dir_url($media->get_media($meta_data->get_post_meta($postlass->post_id, 'class_icon'))->post_content) !!}" alt="Cycling">
										<small>{{$meta_data->get_post_meta($postlass->post_id, 'class_time')}}</small>
										<h3>{{$postlass->post_title}}</h3>
										<span>{{$meta_data->get_post_meta($postlass->post_id, 'class_triner')}}</span>
									</div>
								</div>
								@endforeach

							</div>

							@endforeach							
							<!-- END sched-content -->
						</div>				
					</div>
				</div>
			</div>
		</div>

		<div id="fh5co-team-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="heading-section text-center animate-box">
							<h2>{{$home_settings['program_sec_titile']}}</h2>
							<p>{{$home_settings['program_sec_desc']}}</p>
						</div>
					</div>
				</div>
				<div class="row text-center">

					@foreach($programs as $key => $value)

					<div class="col-md-4 col-sm-6">
						<div class="program animate-box">
							<img src="{!! upload_dir_url($media->get_media($meta_data->get_post_meta($value->id, 'program_icon'))->post_content) !!}" alt="Cycling">
							<h3>{{$value->post_title}}</h3>
							<p>{{$value->post_content}}</p>
							<span><a href="javascript:void(0)" post-title="{{$value->post_title}}" class="btn btn-default" onclick="openJoinNowModal(this)" >Join Now</a></span>
						</div>
					</div>

					@endforeach;
				</div>
			</div>
		</div>	

@stop
