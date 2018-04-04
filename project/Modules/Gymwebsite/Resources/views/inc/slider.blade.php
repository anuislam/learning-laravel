<div class="fh5co-hero">
	<div class="fh5co-overlay"></div>
	<div class="fh5co-cover" data-stellar-background-ratio="0.5" style="background-image: url({!! sanitize_url($media->get_image_src('header_slider', $header_settings['header_slider'])[0]) !!});">
		<div class="desc animate-box">
			<div class="container">
				<div class="row">
					<div class="col-md-7">
						@php
						echo $header_settings['slider_content'];
						@endphp
						<p><span>
						@php
						echo $header_settings['slider_tagline'];
						@endphp
						</span></p>
						<span><a class="btn btn-primary" href="{{sanitize_url($header_settings['slider_btn_url'])}}">{{$header_settings['slider_button']}}</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>