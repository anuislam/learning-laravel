<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces And Routes
|--------------------------------------------------------------------------
|
| When a module starting, this file will executed automatically. This helps
| to register some namespaces like translator or view. Also this file
| will load the routes file for each module. You may also modify
| this file as you want.
|
*/

if (!app()->routesAreCached()) {
    require __DIR__ . '/Http/routes.php';
}

register_menu([
	'menu-title' 	 	=> 'Slider',
	'id' 	 		 	=> 'slider',
	'menu-icon' 	 	=> 'fa-sliders', 
	'capability' 	 	=> 'manage_option',
	'menu_position' 	 	=> 301, 
]);

	register_dropdown_menu('slider', [
		'menu-title' 	 	=> 'Sliders',
		'id' 	 		 	=> 'all_slider', //uniq
		'url' 	 		 	=> ['all-posts', 'slider'], //route
		'capability' 	 	=> 'manage_option', //uniq
	]);

	register_dropdown_menu('slider', [
		'menu-title' 	 	=> 'Add New Slider',
		'id' 	 		 	=> 'add-new-slider', //uniq
		'url' 	 		 	=> ['create_post_type', 'slider'], //route
		'capability' 	 	=> 'manage_option', //uniq
	]);


register_post_type([
	'id' 	 		 	=> 'slider', //uniq
	'class' 	 	 	=> 'Modules\Slider\Entities\Slider',
]);

crop_image_size([
	'name' 		=> 'slider_image', //must be give an uniq name
	'width' 	=> 1140, 
	'height' 	=> 480,
	'resize' 	=> false
]);


new Modules\Slider\Entities\Sliderhooks();


function slider_get_slider(){
	$slider = new Modules\Slider\Entities\Slider();
	if ($slider->slider_get_slider()) {
		return $slider->slider_get_slider();
	}
	return false;
}
