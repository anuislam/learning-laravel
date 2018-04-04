<div id="fh5co-blog-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="col-md-12">
					<div class="heading-section animate-box">
						<h2>{{$home_settings['blog_sec_title']}}</h2>
					</div>
				</div>

				@foreach ($posts as $post)
				
				@php
					$user_data = $usermodel->get_user($post->post_author);
				@endphp

				<div class="col-md-12 col-md-offset-0">
					<div class="fh5co-blog animate-box">
						<div class="inner-post">
							<a href="{{ post_permalink($post->post_slug) }}"><img class="img-responsive" src="{!! sanitize_url($media->get_image_src('blog_thumb', $meta_data->get_post_meta($post->id, 'post_image'))[0]) !!}" alt=""></a>
						</div>
						<div class="desc">
							<h3><a href="{{ post_permalink($post->post_slug) }}">{{ $post->post_title }}</a></h3>
							<span class="posted_by">Posted by: {{ $user_data->fname }} {{ $user_data->lname }}</span>
							<span class="comment"><a href="{{ post_permalink($post->post_slug) }}">{!! $comment->approve_comment_count($post->id, '' , '', ''); !!}<i class="icon-bubble22"></i></a></span>
							<p>{{ trim(read_more(10,  strip_tags($post->post_content))) }}</p>
							<a href="{{ post_permalink($post->post_slug) }}" class="btn btn-default">Read More</a>
						</div> 
					</div>
				</div>
				@endforeach				
			</div>
			<div class="col-md-6">
				<div class="col-md-12">
					<div class="heading-section animate-box">
						<h2>{{$home_settings['event_sec_title']}}</h2>
					</div>
				</div>
				@foreach ($events as $ekey => $evalue)
				@php
					$user_event = $usermodel->get_user($evalue->post_author);
				@endphp
					<div class="col-md-12 col-md-offset-0">
						<div class="fh5co-blog animate-box">
							<div class="meta-date text-center">
								<p><span class="date">{{ \Carbon\Carbon::parse($meta_data->get_post_meta($evalue->id, 'event_date'))->format('d')}}</span><span>{{ \Carbon\Carbon::parse($meta_data->get_post_meta($evalue->id, 'event_date'))->format('F')}}</span><span>{{ \Carbon\Carbon::parse($meta_data->get_post_meta($evalue->id, 'event_date'))->format('Y')}}</span></p>
							</div>
							<div class="desc desc2">
								<h3>
									<a href="{{ route($evalue->post_type,$evalue->post_slug) }}">{{$evalue->post_title}}</a>
								</h3>
								<span class="posted_by">Posted by: {{ $user_event->fname }} {{ $user_event->lname }}</span>
								<span class="comment">
									<a href="{{ route($evalue->post_type,$evalue->post_slug) }}">{!! $comment->approve_comment_count($evalue->id, '' , '', ''); !!}<i class="icon-bubble22"></i></a>
								</span>
								<p>{{ trim(read_more(10,  strip_tags($evalue->post_content))) }}</p>
								<a href="{{ route($evalue->post_type,$evalue->post_slug) }}" class="btn btn-default">Read More</a>
							</div> 
						</div>
					</div>
				@endforeach
				
			</div>
		</div>
	</div>
</div>