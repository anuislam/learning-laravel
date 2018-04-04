<!-- end:fh5co-header -->
<div class="fh5co-parallax" style="background-image: url({!! sanitize_url($media->get_image_src('header_slider', $meta_data->get_post_meta($post->id, 'page_bg_image'))[0]) !!});" data-stellar-background-ratio="0.5">
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