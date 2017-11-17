<?php

register_tarm([
	'id' 	 		 	=> 'shipping', //uniq
	'class' 	 	 	=> 'shipping',
]);

// register_post_type([
// 	'menu-title' 	 	=> 'Categorys',
// 	'id' 	 		 	=> 'threee', //uniq
// 	'title' 	 		=> 'post',
// 	'page-title' 		=> 'post',
// 	'add-new' 	 		=> 'Add new post',
// 	'add-new-route' 	=> 'route-name',
// 	'all-post-route' 	=> 'all-post-route-name',
// 	'slug' 		 		=> 'add-post',
// 	'parent' 	 		=> 'add-category',
// 	'class'      		=> 'postclass', //opject name
// ]);


/*********************************************
* Register Dashboard menu
**********************************************/


register_menu([
	'menu-title' 	 	=> 'Dashboard',
	'id' 	 		 	=> 'dashboard', //uniq
	'menu-icon' 	 	=> 'fa-dashboard', //uniq
	'url' 	 			=> 'dashboard', //uniq
	'capability' 	 	=> 'read', //uniq
]);


/*********************************************
* Register Category menu
**********************************************/

register_menu([
	'menu-title' 	 	=> 'Category',
	'id' 	 		 	=> 'add-category',
	'menu-icon' 	 	=> 'fa-list-ul', 
	'capability' 	 	=> 'create_tarm', 
	'url' 	 		 	=> ['create-tarms', '/'],
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

