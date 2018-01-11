<?php
use \App\UserPermission;

function multid_sort($arr, $index) {
    $b = array();
    $c = array();
    foreach ($arr as $key => $value) {
        $b[$key] = $value[$index];
    }

    asort($b);

    foreach ($b as $key => $value) {
        $c[] = $arr[$key];
    }

    return $c;
}



function admin_menu_setup(){
	$dropdown_menu       = get_registered_dropdown_menu();
	$menus       		 = get_registered_menu();
	$menus = multid_sort($menus, 'menu_position');
	$menu_data 			= [];
	if (is_array($menus)) {
		foreach ($menus as $menu) {			
			if (is_array($dropdown_menu)) {
				foreach ($dropdown_menu as $dropkey => $dropvalue) {
					if (@in_array($menu['id'], $dropvalue)) {
						$menu['dropdown'][] = $dropvalue['data'];						
					}
				}
			}
			$menu_data[] = $menu;
		}
	}
	return $menu_data;
}


function get_admin_sidebar_menu($user){
	$admin_menu = admin_menu_setup();
	$permission 	= new UserPermission();
	if (is_array($admin_menu)) {
		foreach ($admin_menu as $key => $value) {
			$main_menu_title 		= (isset($value['menu-title'])) ? $value['menu-title'] : '' ;
			$main_menu_id 	 		= (isset($value['id'])) ? $value['id'] : '' ;
			$main_menu_icon  		= (isset($value['menu-icon'])) ? $value['menu-icon'] : 'fa-circle-o' ;
			$dropdown 				= (isset($value['dropdown'])) ? $value['dropdown'] : '' ;
			$main_menu_url 			= (isset($value['url'])) ? $value['url'] : '' ;
			$main_menu_url 			= admin_menu_route_settion( $main_menu_url );
			$main_menu_capability 	= (isset($value['capability'])) ? $value['capability'] : '' ;

			if ($permission->user_can($main_menu_capability, $user)) {
				if (empty($dropdown) === false) {
					?>
					<li class="treeview" title="<?php echo $main_menu_title; ?>">
						<a href="#">
							<i class="fa fa-fw <?php echo $main_menu_icon; ?>"></i>
							<span><?php echo $main_menu_title; ?></span>
						</a>
					<ul class="treeview-menu">
						<?php
						foreach ($dropdown as $dropdownvalue) {
							$menu_title = (isset($dropdownvalue['menu-title'])) ? $dropdownvalue['menu-title'] : '' ;
							$menu_id = (isset($dropdownvalue['id'])) ? $dropdownvalue['id'] : '' ;
							$menu_url = (isset($dropdownvalue['url'])) ? $dropdownvalue['url'] : '' ;
							$menu_url = admin_menu_route_settion( $menu_url );
							$menu_capability = (isset($dropdownvalue['capability'])) ? $dropdownvalue['capability'] : '' ;
							$menu_icon = (isset($dropdownvalue['menu-icon'])) ? $dropdownvalue['menu-icon'] : 'fa fa-circle-o' ;

							if ($permission->user_can($menu_capability, $user)) {
								?>
								<li 
									class="<?php echo admin_dashboard_active_menu($menu_url, true); ?>"
								 ><a href="<?php echo $menu_url; ?>"><i class="fa <?php echo $menu_icon; ?>"></i> <?php echo $menu_title; ?></a></li>

								</li>
								<?php
							}
						}
					?> 
					</ul>
					</li>

				<?php
				}else{
					?>	

		<li title="<?php echo $main_menu_title; ?>" class="<?php echo admin_dashboard_active_menu($main_menu_url); ?>">
          <a href="<?php echo $main_menu_url; ?>">
            <i class="fa <?php echo $main_menu_icon; ?>"></i> <span><?php echo $main_menu_title; ?></span>
          </a>
        </li>				
					<?php
				}

			}
		}
	}
}


function admin_menu_route_settion( $route='' )
{
	if (empty($route) === false) {
		return ( is_array($route) === true) ? route($route[0], $route[1]) : route($route) ;
	}
	return false;
}


function admin_dashboard_active_menu($url, $sub = false){
	$curr_url = url()->current();
	if ($url == $curr_url) {
		if ($sub === true) {
			return 'sub_active';
		}
		return 'active';
	}
	return false;
}