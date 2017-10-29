<?php
use \App\UserPermission;
function admin_menu_setup(){
	$dropdown_menu       = get_registered_dropdown_menu();
	$menus       		 = get_registered_menu();
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
			$main_menu_icon  		= (isset($value['menu-icon'])) ? $value['menu-icon'] : 'fa-pencil' ;
			$dropdown 				= (isset($value['dropdown'])) ? $value['dropdown'] : '' ;
			$main_menu_url 			= (isset($value['url'])) ? $value['url'] : '' ;
			$main_menu_url 			= admin_menu_route_settion( $main_menu_url );
			$main_menu_capability 	= (isset($value['capability'])) ? $value['capability'] : '' ;

			if ($permission->user_can($main_menu_capability, $user)) {
				if (empty($dropdown) === false) {
					?>
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="<?php echo $main_menu_title; ?>">
					  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#<?php echo $main_menu_id; ?>" data-parent="#dashboardMenu">
					    <i class="fa fa-fw <?php echo $main_menu_icon; ?>"></i>
					    <span class="nav-link-text"><?php echo $main_menu_title; ?></span>
					  </a>

					<ul class="sidenav-second-level collapse" id="<?php echo $main_menu_id; ?>">
					<?php
						foreach ($dropdown as $dropdownvalue) {
							$menu_title = (isset($dropdownvalue['menu-title'])) ? $dropdownvalue['menu-title'] : '' ;
							$menu_id = (isset($dropdownvalue['id'])) ? $dropdownvalue['id'] : '' ;
							$menu_url = (isset($dropdownvalue['url'])) ? $dropdownvalue['url'] : '' ;
							$menu_url = admin_menu_route_settion( $menu_url );
							$menu_capability = (isset($dropdownvalue['capability'])) ? $dropdownvalue['capability'] : '' ;

							if ($permission->user_can($menu_capability, $user)) {
								?>
								<li>
								  <a href="<?php echo $menu_url; ?>"><?php echo $menu_title; ?></a>
								</li>
								<?php
							}


						}
					?> 
					</ul> 
					</li><?php
				}else{
					?>					
						<li class="nav-item" data-toggle="tooltip" data-placement="right" title="<?php echo $main_menu_title; ?>">
						  <a class="nav-link" href="<?php echo $main_menu_url; ?>">
						    <i class="fa fa-fw <?php echo $main_menu_icon; ?>"></i>
						    <span class="nav-link-text"><?php echo $main_menu_title; ?></span>
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