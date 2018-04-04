<div id="fh5co-header">
	<header id="fh5co-header-section">
		<div class="container">
			<div class="nav-header">
				<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
				<h1 id="fh5co-logo">
					<a href="{{url('/')}}">
						<img src="{{@$logo_image[0]}}" alt="{{@$genarel['site_title']}}">
					</a>
				</h1>
				<!-- START #fh5co-menu-wrap -->
				<nav id="fh5co-menu-wrap" role="navigation">
					<ul class="sf-menu" id="fh5co-primary-menu">
						@php
		                	echo str_replace('<ul class="fh5co-sub-menu"></ul>', '', gym_get_header_menu(NULL, @$header_settings['menu_id']));
		                @endphp
					</ul>
				</nav>
			</div>
		</div>
	</header>		
</div>