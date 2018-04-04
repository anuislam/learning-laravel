<div class="fh5co-parallax" style="background-image: url({!! sanitize_url($media->get_image_src('header_slider', $home_settings['fitness_sec_bg_image'])[0]) !!});" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-md-pull-3 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 fh5co-table">
				<div class="fh5co-intro fh5co-table-cell box-area">
					<div class="animate-box">
						<h1>{{$home_settings['fitness_sec_titile']}}</h1>
						<p>{{$home_settings['fitness_sec_desc']}}</p>
						<a href="{{$home_settings['fitness_sec_btn_url']}}" class="btn btn-primary">{{$home_settings['fitness_sec_btn_text']}}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- end: fh5co-parallax -->