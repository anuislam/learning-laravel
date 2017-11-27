<?php

register_tarm([
	'id' 	 		 	=> 'shipping', //uniq
	'class' 	 	 	=> 'shipping',
]);
register_tarm([
	'id' 	 		 	=> 'tags', //uniq
	'class' 	 	 	=> 'tags',
]);


/*********************************************
* Register Dashboard menu
**********************************************/

register_post_type([
	'id' 	 		 	=> 'page', //uniq
	'class'      		=> 'page', //opject name
]);

register_post_type([
	'id' 	 		 	=> 'post', //uniq
	'class'      		=> 'post', //opject name
]);




register_menu([
	'menu-title' 	 	=> 'Dashboard',
	'id' 	 		 	=> 'dashboard', //uniq
	'menu-icon' 	 	=> 'fa-dashboard', //uniq
	'url' 	 			=> 'dashboard', //uniq
	'capability' 	 	=> 'read', //uniq
]);


/*********************************************
* Register post menu
**********************************************/

register_menu([
	'menu-title' 	 	=> 'Post',
	'id' 	 		 	=> 'post',
	'menu-icon' 	 	=> 'fa-pencil-square-o', 
	'capability' 	 	=> 'edith_post', 
]);


register_dropdown_menu('post', [
	'menu-title' 	 	=> 'All Posts',
	'id' 	 		 	=> 'all-posts', //uniq
	'url' 	 		 	=> ['all-posts', 'post'], //route
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'edith_post', //uniq
]);

register_dropdown_menu('post', [
	'menu-title' 	 	=> 'Add New Post',
	'id' 	 		 	=> 'add-new-post', //uniq
	'url' 	 		 	=> ['create_post_type', 'post'], //route
	'menu-icon' 	 	=> 'fa-pencil',
	'capability' 	 	=> 'edith_post', //uniq
]);

/*********************************************
* Register Category menu
**********************************************/
register_dropdown_menu('post', [
	'menu-title' 	 	=> 'Category',
	'id' 	 		 	=> 'add-category', //uniq
	'url' 	 		 	=> ['create-tarms', '/'], //route
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'create_tarm', //uniq
]);

register_dropdown_menu('post', [
	'menu-title' 	 	=> 'Tags',
	'id' 	 		 	=> 'add-tags', //uniq
	'url' 	 		 	=> ['create-tarms', 'tags'], //route
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'create_tarm', //uniq
]);


/*********************************************
* Register page
**********************************************/


register_menu([
	'menu-title' 	 	=> 'Page',
	'id' 	 		 	=> 'page',
	'menu-icon' 	 	=> 'fa-pencil-square-o', 
	'capability' 	 	=> 'edith_page', 
]);

register_dropdown_menu('page', [
	'menu-title' 	 	=> 'All Page',
	'id' 	 		 	=> 'all-page', //uniq
	'url' 	 		 	=> ['all-posts', 'page'], //route
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'edith_post', //uniq
]);

register_dropdown_menu('page', [
	'menu-title' 	 	=> 'App New Page',
	'id' 	 		 	=> 'add-page', //uniq
	'url' 	 		 	=> ['create_post_type', 'page'], //route
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'edith_page', //uniq
]);


/*********************************************
* Register Shipping menu
**********************************************/

register_menu([
	'menu-title' 	 	=> 'Shipping',
	'id' 	 		 	=> 'add-shipping',
	'menu-icon' 	 	=> 'fa-list-ul', 
	'capability' 	 	=> 'create_tarm', 
	'url' 	 		 	=> ['create-tarms', 'shipping'],
]);



/*********************************************
* Register user menu
**********************************************/
register_menu([
	'menu-title' 	 	=> 'Users',
	'id' 	 		 	=> 'all-user', //uniq
	'menu-icon' 	 	=> 'fa-users', //uniq
	'capability' 	 	=> 'read', //uniq
]);


register_dropdown_menu('all-user', [
	'menu-title' 	 	=> 'Add New User',
	'id' 	 		 	=> 'add-new-user', //uniq
	'url' 	 		 	=> 'user.create', //uniq
	'menu-icon' 	 	=> 'fa-list-ul',
	'capability' 	 	=> 'read', //uniq
]);

register_dropdown_menu('all-user', [
	'menu-title' 	 	=> 'All Users',
	'id' 	 		 	=> 'all-users', //uniq
	'url' 	 		 	=> 'all-users', //uniq
	'capability' 	 	=> 'read', //uniq
]);

register_dropdown_menu('all-user', [
	'menu-title' 	 	=> 'Your Profile',
	'id' 	 		 	=> 'your-profile', //uniq
	'url' 	 		 	=> 'user.index', //uniq
	'capability' 	 	=> 'read', //uniq
]);


/*********************************************
* Register media menu
**********************************************/

register_menu([
	'menu-title' 	 	=> 'Media',
	'id' 	 		 	=> 'add-media',
	'menu-icon' 	 	=> 'fa-list-ul', 
	'capability' 	 	=> 'upload_file', 
]);


register_dropdown_menu('add-media', [
	'menu-title' 	 	=> 'Add New Media',
	'id' 	 		 	=> 'add_new_media', //uniq
	'capability' 	 	=> 'upload_file', //uniq
	'url' 	 		 	=> 'media.create',
]);

register_dropdown_menu('add-media', [
	'menu-title' 	 	=> 'All Media',
	'id' 	 		 	=> 'all_media', //uniq
	'capability' 	 	=> 'upload_file', //uniq
	'url' 	 		 	=> 'media.index',
]);


crop_image_size([
	'name' 		=> 'thumbnail', //must be give an uniq name
	'width' 	=> 150, 
	'height' 	=> 150,
	'resize' 	=> true,
]);

crop_image_size([
	'name' 		=> 'media_preview', //must be give an uniq name
	'width' 	=> 336, 
	'height' 	=> 336,
	'resize' 	=> false,
]);

crop_image_size([
	'name' 		=> 'full', //must be give an uniq name
	'width' 	=> 'auto', 
	'height' 	=> 'auto',
	'resize' 	=> false // fit image
]);

