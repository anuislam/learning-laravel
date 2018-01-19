<?php 

//**************************************************************
// register menu
//**************************************************************

register_menu([
	'menu-title' 	 	=> 'Product',
	'id' 	 		 	=> 'product',
	'menu-icon' 	 	=> 'fa-shopping-cart', 
	'capability' 	 	=> 'manage_product', 
	'menu_position' 	=> 220, 
]);

	register_dropdown_menu('product', [
		'menu-title' 	 	=> 'Add New product',
		'id' 	 		 	=> 'add-new-product', //uniq
		'url' 	 		 	=> ['create_post_type', 'product'], //route
		'capability' 	 	=> 'add_product', //uniq
	]);

//**************************************************************
// add user role
//**************************************************************

$user_role = new App\UserPermission();
$user_role->cap('administrator', [
            'add_product'   => true,
            'manage_product'   => true,
        ]);

//**************************************************************
// register post type
//**************************************************************


register_post_type([
	'id' 	 		 	=> 'product', //uniq
	'class' 	 	 	=> 'Modules\Eccommerce\Entities\product', //opject name
]);
