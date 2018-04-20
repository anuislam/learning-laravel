<?php

//**************************************************************
// Setting up admin dashboard menu
//**************************************************************

register_menu([
	'menu-title' 	 	=> 'Dashboard',
	'id' 	 		 	=> 'dashboard', //uniq
	'menu-icon' 	 	=> 'fa-dashboard', //uniq
	'url' 	 			=> 'dashboard', //uniq
	'capability' 	 	=> 'read', //uniq
	'menu_position' 	 	=> 1, 
]);

//**************************************************************
// Page
//**************************************************************

register_menu([
	'menu-title' 	 	=> 'Page',
	'id' 	 		 	=> 'page',
	'menu-icon' 	 	=> 'fa-columns', 
	'capability' 	 	=> 'edith_page', 
	'menu_position' 	 	=> 200, 
]);
//**************************************************************
// Page dropdown
//**************************************************************

		register_dropdown_menu('page', [
			'menu-title' 	 	=> 'All Pages',
			'id' 	 		 	=> 'all-page', //uniq
			'url' 	 		 	=> ['all-posts', 'page'], //route
			'capability' 	 	=> 'edith_post', //uniq
		]);

		register_dropdown_menu('page', [
			'menu-title' 	 	=> 'App New Page',
			'id' 	 		 	=> 'add-page', //uniq
			'url' 	 		 	=> ['create_post_type', 'page'], //route
			'capability' 	 	=> 'edith_page', //uniq
		]);




//**************************************************************
// Register media menu
//**************************************************************

register_menu([
	'menu-title' 	 	=> 'Media',
	'id' 	 		 	=> 'add-media',
	'menu-icon' 	 	=> 'fa-picture-o', 
	'capability' 	 	=> 'upload_file', 
	'menu_position' 	 	=> 300, 
]);

//**************************************************************
// Register media menu dropdown
//**************************************************************
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



//**************************************************************
// Register appearance menu
//**************************************************************



register_menu([
	'menu-title' 	 	=> 'Appearance',
	'id' 	 		 	=> 'appearance',
	'menu-icon' 	 	=> 'fa-paint-brush ', 
	'capability' 	 	=> 'manage_option',
	'menu_position' 	 	=> 500, 
]);



//**************************************************************
// Nav menu
//**************************************************************

	register_dropdown_menu('appearance',[
		'menu-title' 	 	=> 'Nav Menu',
		'id' 	 		 	=> 'nav-menu',
		'capability' 	 	=> 'manage_option',
		'url' 	 		 	=> ['create_post_type', 'nav-menu'],
	]);

	register_dropdown_menu('appearance',[
		'menu-title' 	 	=> 'Theme',
		'id' 	 		 	=> 'theme',
		'capability' 	 	=> 'manage_option',
		'url' 	 		 	=> ['admin-page', 'theme']
	]);




//**************************************************************
// Register Module menu
//**************************************************************

	register_dropdown_menu('appearance',[
		'menu-title' 	 	=> 'Modules',
		'id' 	 		 	=> 'modules',
		'capability' 	 	=> 'manage_option',
		'url' 	 		 	=> ['admin-page', 'modules']
	]);


//**************************************************************
// Upload Module Menu
//**************************************************************

	register_dropdown_menu('appearance',[
		'menu-title' 	 	=> 'Upload Module',
		'id' 	 		 	=> 'upload-module',
		'capability' 	 	=> 'manage_option',
		'url' 	 		 	=> ['admin-page', 'upload-module']
	]);


//**************************************************************
// Register user menu
//**************************************************************
register_menu([
	'menu-title' 	 	=> 'Users',
	'id' 	 		 	=> 'all-user', //uniq
	'menu-icon' 	 	=> 'fa-users', //uniq
	'capability' 	 	=> 'read', //uniq
	'menu_position' 	 	=> 600, 
]);

//**************************************************************
// Register user menu dropdown
//**************************************************************
	register_dropdown_menu('all-user', [
		'menu-title' 	 	=> 'Add New User',
		'id' 	 		 	=> 'add-new-user', //uniq
		'url' 	 		 	=> 'user.create', //uniq
		'capability' 	 	=> 'create_user', //uniq
	]);

	register_dropdown_menu('all-user', [
		'menu-title' 	 	=> 'All Users',
		'id' 	 		 	=> 'all-users', //uniq
		'url' 	 		 	=> 'all-users', //uniq
		'capability' 	 	=> 'edith_other_user', //uniq
	]);

	register_dropdown_menu('all-user', [
		'menu-title' 	 	=> 'Your Profile',
		'id' 	 		 	=> 'your-profile', //uniq
		'url' 	 		 	=> 'user.index', //uniq
		'capability' 	 	=> 'read', //uniq
	]);


//**************************************************************
// Register Settings menu
//**************************************************************

register_menu([
	'menu-title' 	 	=> 'Settings',
	'id' 	 		 	=> 'settings',
	'menu-icon' 	 	=> 'fa-link', 
	'capability' 	 	=> 'manage_option',
	'menu_position' 	 	=> 700, 
]);

//**************************************************************
// Register Settings menu dropdown
//**************************************************************

		register_dropdown_menu('settings', [
			'menu-title' 	 	=> 'Genarel',
			'id' 	 		 	=> 'genarel-setting', //uniq
			'capability' 	 	=> 'manage_option', //uniq
			'url' 	 		 	=> ['admin-page', 'genarel'],
		]);


		register_dropdown_menu('settings', [
			'menu-title' 	 	=> 'Log',
			'id' 	 		 	=> 'log-setting', //uniq
			'capability' 	 	=> 'manage_option', //uniq
			'url' 	 		 	=> 'log_edit',
		]);


//***********************************************************************
//***********************************************************************
//***********************************************************************
//End menu setup
//***********************************************************************
//***********************************************************************
//***********************************************************************





//**************************************************************
// Crop image size
//**************************************************************


crop_image_size([
	'name' 		=> 'full', //must be give an uniq name
	'width' 	=> 'auto', 
	'height' 	=> 'auto',
	'resize' 	=> false // fit image
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





//***********************************************************************
//***********************************************************************
//***********************************************************************
//Crop image
//***********************************************************************
//***********************************************************************
//***********************************************************************


//**************************************************************
// Register post type
//**************************************************************

register_post_type([
	'id' 	 		 	=> 'page', //uniq
	'class' 	 	 	=> 'App\registerModel\page', //opject name
]);

register_post_type([
	'id' 	 		 	=> 'nav-menu', //uniq
	'class' 	 	 	=> 'App\registerModel\nav_menu', //opject name
]);


//***********************************************************************
//***********************************************************************
//***********************************************************************
//End Register texonomis
//***********************************************************************
//***********************************************************************
//***********************************************************************

//**************************************************************
// Register admin page 
//**************************************************************


add_admin_page([
	'id' 	 		 	=> 'genarel', //uniq
	'class' 	 	 	=> 'App\registerModel\genarel',
]);

add_admin_page([
	'id' 	 		 	=> 'modules', //uniq
	'class' 	 	 	=> 'App\registerModel\modules',
]);

add_admin_page([
	'id' 	 		 	=> 'theme', //uniq
	'class' 	 	 	=> 'App\registerModel\themeManagement',
]);
add_admin_page([
	'id' 	 		 	=> 'upload-module', //uniq
	'class' 	 	 	=> 'App\registerModel\uploadModule',
]);




//**************************************************************
// register_page_template
//**************************************************************


register_page_template([
  'name' => 'Default',
  'path' => 'gymwebsite::page',
]);

