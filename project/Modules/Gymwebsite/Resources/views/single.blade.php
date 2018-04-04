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

		<!-- end:fh5co-header -->
		<div class="fh5co-parallax" style="background-image: url({!! sanitize_url($media->get_image_src('header_slider', $meta_data->get_post_meta($post->id, 'post_bg_image'))[0]) !!});" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-center fh5co-table">
						<div class="fh5co-intro fh5co-table-cell animate-box">
							<h1 class="text-center">{{$post->post_title}}</h1>
							<p>{{$meta_data->get_post_meta($post->id, 'Page_Short_description')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div><!-- end: fh5co-parallax -->

		<div id="fh5co-team-section" style="padding-bottom: 50px;">
			<div class="container">
				<div class="row about" style="padding-bottom: 0;">
					<div class="col-md-12 col-md-offset-0">
						<img class="img-responsive animate-box" src="{!! sanitize_url($media->get_image_src('post_image', $meta_data->get_post_meta($post->id, 'post_image'))[0]) !!}" alt="{{$post->post_title}}">
					</div>
					<div class="col-md-12 col-md-offset-0 animate-box">
						{!! $post->post_content !!}
					</div>
				</div>
			</div>
		</div>	
		<div id="fh5co-team-section" style="margin: 0; padding-top: 0;">

			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p><strong>{!! $comment->approve_comment_count($post->id); !!}</strong></p>
					</div>
				</div>
				@php
					$comment_post_message 	= session('comment_post_message');
				@endphp
				@if ($comment_post_message)
					<div class="row">
						<div class="col-sm-12">
							<p style="color: #c36969;"><strong>{{ $comment_post_message  }}</strong></p>
						</div>
					</div>
				@endif
			</div>
			<div class="container">
				<div class="comments" id="comments">
						<div class="comment-wrap">
						<?php if(!Auth::guest()){  ?>  											
							<div class="photo">
								<div class="avatar" style="background-image: url('https://www.gravatar.com/avatar/{!! md5(Auth::user()->email) !!}?s=160&d=mm&r=g')"></div>
							</div>
						<?php } ?>	
							<div class="comment-block" id="comment_form_html">
								{!! $comment->get_comment_form(route('post_comment'), $errors, $post->id); !!}
							</div>
						</div>
							

						@php
							$allComments = $comment->get_comments($post->id);
						@endphp
						@if (count($allComments) > 0)
							@foreach ($allComments as $ckey => $cvalue)							

								<div class="comment-wrap">
									<div class="photo">
										<div class="avatar" style="background-image: url('https://www.gravatar.com/avatar/{!! md5($cvalue->email) !!}?s=160&d=mm&r=g')"></div>
									</div>
									<div class="comment-block">
										<p class="comment-text">{!!$cvalue->message!!}</p>
										<div class="bottom-comment">
											<div class="comment-date">{{ \Carbon\Carbon::parse($cvalue->created_at)->format('M d, Y @ g:i A')}}</div>			
										</div>
									</div>
								</div>
							@endforeach
						@endif						
				</div>

			</div>
		</div>
@stop
