<?php

function admin_menu_setup(){
	$post_type 	= get_registered_post_type();
	$tarms_type = get_registered_tarms();
	$menu_data 		= [];
	$menu_tarm_data = [];
	$tarm_data = [];
	if (is_array($post_type)) {
		$a2 = 0;
		foreach ($post_type as $post_key => $post_value) {			
			if (is_array($tarms_type)) {
				foreach ($tarms_type as $tarmkey => $tarmvalue) {
					if (@in_array($post_value['parent'], $tarmvalue)) {
						$post_value['tarms'][] = $tarmvalue;						
					}
				}
			}
			$menu_data[] = $post_value;
		}
	}
	return $menu_data;
}