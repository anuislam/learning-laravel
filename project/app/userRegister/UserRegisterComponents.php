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

register_menu([
	'menu-title' 	 	=> 'Dashboard',
	'id' 	 		 	=> 'dashboard', //uniq
	'menu-icon' 	 	=> 'fa-dashboard', //uniq
	'url' 	 			=> 'dashboard', //uniq
	'capability' 	 	=> 'read', //uniq
]);

register_menu([
	'menu-title' 	 	=> 'Users',
	'id' 	 		 	=> 'all-user', //uniq
	'menu-icon' 	 	=> 'fa-users', //uniq
	'capability' 	 	=> 'read', //uniq
]);

register_menu([
	'menu-title' 	 	=> 'Category',
	'id' 	 		 	=> 'add-category',
	'menu-icon' 	 	=> 'fa-list-ul', 
	'capability' 	 	=> 'create_tarm', 
	'url' 	 		 	=> ['create-tarms', '/'],
]);

register_menu([
	'menu-title' 	 	=> 'Shipping',
	'id' 	 		 	=> 'add-shipping',
	'menu-icon' 	 	=> 'fa-list-ul', 
	'capability' 	 	=> 'create_tarm', 
	'url' 	 		 	=> ['create-tarms', 'shipping'],
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

