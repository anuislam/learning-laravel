<?php 

function allstor_get_menu_top($parent = NULL, int $menu_id = 0){
  $sql = DB::table('menu_items');
  $menu_html = '';
  if (is_null($parent)) {
  $sql = $sql->whereRaw('parent_id IS NULL');
  }else{
    $sql = $sql->where('parent_id', '=', (int)$parent);
  }
  $menu_data = $sql->where('menu_id', '=', (int)$menu_id)->orderBy('menu_order', 'asc')->get();

  if (empty($menu_data) === false) {
  	$a1 = 0;
    foreach ($menu_data as $key => $value) {
	    $active = ($a1 == 0) ? 'class="active"' : '' ;	    
	    $a1++;
	    $menu_html .= '<li class="allstor_child_class"><a href="'.$value->url.'" '.$active.' >'.$value->title.'</a>';
	    $menu_html .= '<ul class="sub-menu">'.allstor_get_menu_top($value->id, $menu_id).'</ul>';
	    $menu_html .= '</li>';
    }
  }
  return $menu_html;
}

function allstor_get_menu_catalog($parent = NULL, int $menu_id = 0){
  $sql = DB::table('menu_items');
  $menu_html = '';
  if (is_null($parent)) {
  $sql = $sql->whereRaw('parent_id IS NULL');
  }else{
    $sql = $sql->where('parent_id', '=', (int)$parent);
  }
  $menu_data = $sql->where('menu_id', '=', (int)$menu_id)->orderBy('menu_order', 'asc')->get();

  if (empty($menu_data) === false) {
  	$a1 = 0;
    foreach ($menu_data as $key => $value) {
	    $active = ($a1 == 0) ? 'class="active"' : '' ;	    
	    $a1++;
	    $menu_html .= '<li><a href="'.$value->url.'">'.$value->title.'</a><i class="fa fa-angle-right"></i>';
	    $menu_html .= '<ul>'.allstor_get_menu_catalog($value->id, $menu_id).'</ul>';
	    $menu_html .= '</li>';
    }
  }
  return $menu_html;
}