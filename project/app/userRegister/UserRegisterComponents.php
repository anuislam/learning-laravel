<?php

register_tarm([
	'title' 	 => 'Categorys',
	'page-title' => 'Categorys',
	'slug' 		 => 'add-category',
	'add-new' 	 		=> 'Add new Category',
	'add-new-route' 	=> 'route-name',
	'all-tarm-route' 	=> 'all-post-route-name',
	'class'      => 'Category', //opject name
]);


register_post_type([
	'title' 	 		=> 'post',
	'page-title' 		=> 'post',
	'add-new' 	 		=> 'Add new post',
	'add-new-route' 	=> 'route-name',
	'all-post-route' 	=> 'all-post-route-name',
	'slug' 		 		=> 'add-post',
	'parent' 	 		=> 'add-category',
	'class'      		=> 'postclass', //opject name
]);

