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

$user_rool = new App\UserPermission();
$user_rool->cap('administrator', [
    'manage_comment'        => true,
    'edit_comment'        	=> true,
    'edit_others_comment'   => true,
    'delete_comment'        => true,
    'delete_others_comment' => true,
]);

register_menu([
	'menu-title' 	 	=> 'All Comments',
	'id' 	 		 	=> 'all-comments',
	'menu-icon' 	 	=> 'fa-comments', 
	'capability' 	 	=> 'manage_comment', 
	'menu_position' 	=> 108, 
	'url' 				=> ['admin-page', 'comments'], 
]);

add_admin_page([
	'id' 	 		 	=> 'comments', //uniq
	'class' 	 	 	=> 'Modules\Comment\Entities\allComments',
]);

add_admin_page([
	'id' 	 		 	=> 'edit-comment', //uniq
	'class' 	 	 	=> 'Modules\Comment\Entities\editComment',
]);

new Modules\Comment\Entities\Hooks();