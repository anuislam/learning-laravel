<?php 

register_menu([
	'menu-title' 	 	=> 'Comment',
	'id' 	 		 	=> 'comment',
	'menu-icon' 	 	=> 'fa-comments', 
	'capability' 	 	=> 'manage_option',
	'url' 	 		 	=> ['admin-page', 'comment'],
	'menu_position' 	 	=> 400, 
]);


add_admin_page([
	'id' 	 		 	=> 'comment', //uniq
	'class' 	 	 	=> 'Modules\Comment\Entities\Comment',
]);



new Modules\Comment\Entities\Commenthooks();