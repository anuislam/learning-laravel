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
	'menu-title' 	 	=> 'Post',
	'id' 	 		 	=> 'post',
	'menu-icon' 	 	=> 'fa-pencil-square-o', 
	'capability' 	 	=> 'edith_post', 
	'menu_position' 	=> 100, 
	'url' 	 		 	=> ['all-posts', 'post'], //route
]);
//**************************************************************
// Post dropdown
//**************************************************************
		register_dropdown_menu('post', [
			'menu-title' 	 	=> 'All Posts',
			'id' 	 		 	=> 'all-posts', //uniq
			'url' 	 		 	=> ['all-posts', 'post'], //route
			'capability' 	 	=> 'edith_post', //uniq
		]);

		register_dropdown_menu('post', [
			'menu-title' 	 	=> 'Add New Post',
			'id' 	 		 	=> 'add-new-post', //uniq
			'url' 	 		 	=> ['create_post_type', 'post'], //route
			'capability' 	 	=> 'edith_post', //uniq
		]);


//**************************************************************
// Post category menu
//**************************************************************
		register_dropdown_menu('post', [
			'menu-title' 	 	=> 'Category',
			'id' 	 		 	=> 'add-category', //uniq
			'url' 	 		 	=> ['create-tarms', '/'], //route
			'capability' 	 	=> 'create_tarm', //uniq
		]);

		register_dropdown_menu('post', [
			'menu-title' 	 	=> 'Tags',
			'id' 	 		 	=> 'add-tags', //uniq
			'url' 	 		 	=> ['create-tarms', 'tags'], //route
			'capability' 	 	=> 'create_tarm', //uniq
		]);


register_post_type([
	'id' 	 		 	=> 'post', //uniq
	'class' 	 	 	=> 'Modules\Blog\Entities\PostBlog', //opject name
]);


//**************************************************************
// Register texonomis
//**************************************************************

register_tarm([
	'id' 	 		 	=> 'tags', //uniq
	'class' 	 	 	=> 'Modules\Blog\Entities\tags',
]);
