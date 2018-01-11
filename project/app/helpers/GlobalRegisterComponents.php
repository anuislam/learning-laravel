<?php 
$GlobalTarms 	= [];
$GlobalPostType = [];
$Globalmenu = [];
$Globaldropdownmenu = [];
$GlobalImageCrop = [];
$GlobalMenupage = [];

$globalAction = '';

function set_obj(){
	global $globalAction;
	$globalAction = new App\Hooks();
}
set_obj();

function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1){
    global $globalAction;
    return $globalAction->add_filter($tag, $function_to_add, $priority, $accepted_args);
}


function remove_filter( $tag, $function_to_remove, $priority = 10 ){
    global $globalAction;    
    return $globalAction->remove_filter( $tag, $function_to_remove, $priority );
}


function remove_all_filters($tag, $priority = false) {
	global $globalAction;
	return $globalAction->remove_all_filters($tag, $priority);
}

function has_filter($tag, $function_to_check = false) {
	global $globalAction;
	return $globalAction->has_filter($tag, $function_to_check);
}

function apply_filters($tag, $value) {
	global $globalAction;
	return $globalAction->apply_filters($tag, $value);
}

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1 ){
    global $globalAction;
    return $globalAction->add_action($tag, $function_to_add, $priority, $accepted_args);
}

function do_action($tag, $arg = ''){
    global $globalAction;    
    return $globalAction->do_action($tag, $arg);
}

function has_action($hook, $function) {
	global $globalAction;
	return $globalAction->has_action($hook, $function);
}

function remove_action($hook, $function, $priority = '') {
	global $globalAction;
	return $globalAction->remove_action($hook, $function, $priority);
}

function remove_all_actions($hook, $priority = '') {
	global $globalAction;
	return $globalAction->remove_all_actions($hook, $priority);
}




function crop_image_size($data = []){
	global $GlobalImageCrop;
	$data['resize'] = (isset($data['resize'])) ? $data['resize'] : false ;
	$GlobalImageCrop[] = $data;
}

function register_tarm($data = []){
	global $GlobalTarms,$Globaldropdownmenu;
	$GlobalTarms[] = $data;
}

function add_admin_page($data = []){
	global $GlobalMenupage;
	$GlobalMenupage[] = $data;
}

function register_post_type($data = []){
	global $GlobalPostType,$Globalmenu;
	$GlobalPostType[] = $data;
}

function register_menu($data = []){
	global $Globalmenu;
	$Globalmenu[] = $data;
}

function register_dropdown_menu($id, $data = []){
	global $Globaldropdownmenu;
	$Globaldropdownmenu[] = [
		'id' => $id,
		'data' => $data
	];
}


function get_add_admin_page(){
	global $GlobalMenupage;
	return $GlobalMenupage;
}

function get_registered_tarms(){
	global $GlobalTarms;
	return $GlobalTarms;
}

function get_registered_post_type(){
	global $GlobalPostType;
	return $GlobalPostType;
}

function get_registered_menu(){
	global $Globalmenu;
	return $Globalmenu;
}
function get_registered_dropdown_menu(){
	global $Globaldropdownmenu;
	return $Globaldropdownmenu;
}

function get_crop_image_size(){
	global $GlobalImageCrop;
	return $GlobalImageCrop;
}

function verify_admin_page($data){
	$all_page = get_add_admin_page();
	if (is_array($all_page) === true) {
		foreach ($all_page as $page => $pagevalue) {
			if ($pagevalue['id'] == $data) {
				return $pagevalue['class'];
				break;
			}
		}
	}
	return false;
}

function verify_registered_tarm($data){
	$all_tarms = get_registered_tarms();
	if (is_array($all_tarms) === true) {
		foreach ($all_tarms as $tarm => $tarmvalue) {
			if ($tarmvalue['id'] == $data) {
				return $tarmvalue['class'];
				break;
			}
		}
	}
	return false;
}


function verify_registered_post_type($data){
	$all_post_type = get_registered_post_type();
	if (is_array($all_post_type) === true) {
		foreach ($all_post_type as $psot => $postvalue) {
			if ($postvalue['id'] == $data) {
				return $postvalue['class'];
				break;
			}
		}
	}
	return false;
}

