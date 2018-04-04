<div id="fh5co-team-section" class="fh5co-lightgray-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="heading-section text-center animate-box">
					<h2>{{$home_settings['trainer_sec_titile']}}</h2>
					<p>{{$home_settings['trainer_sec_desc']}}</p>
				</div>
			</div>
		</div>
		<div class="row text-center">			
			@foreach($trainers as $tkey => $tvalue)

				<div class="col-md-4 col-sm-6">
					<div class="team-section-grid animate-box" style="background-image: url({!! sanitize_url($media->get_image_src('trainer_avatar', $meta_data->get_post_meta($tvalue->id, 'trainer_avatar'))[0]) !!});">
						<div class="overlay-section">
							<div class="desc">
								<h3>{{ $tvalue->post_title }}</h3>
								<span>{{ $meta_data->get_post_meta($tvalue->id, 'trainer_title') }}</span>
								<p>{{ $tvalue->post_content }}</p>
								<p class="fh5co-social-icons">
									<a href="{{ $meta_data->get_post_meta($tvalue->id, 'trainer_twitter') }}"><i class="icon-twitter-with-circle"></i></a>
									<a href="{{ $meta_data->get_post_meta($tvalue->id, 'trainer_facebook') }}"><i class="icon-facebook-with-circle"></i></a>
									<a href="{{ $meta_data->get_post_meta($tvalue->id, 'trainer_instagram') }}"><i class="icon-instagram-with-circle"></i></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			@endforeach				
		</div>
	</div>
</div>
