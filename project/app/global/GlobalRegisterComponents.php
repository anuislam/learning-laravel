<?php 
$GlobalTarms 	= [];
$GlobalPostType = [];
$Globalmenu = [];
$Globaldropdownmenu = [];
function register_tarm($data = []){
	global $GlobalTarms,$Globaldropdownmenu;
	$GlobalTarms[] = $data;
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

function verify_registered_tarm($data){
	$all_tarms = get_registered_tarms();
	if (is_array($all_tarms) === true) {
		foreach ($all_tarms as $tarm => $tarmvalue) {
			if ($tarmvalue['id'] == $data) {
				return true;
				break;
			}
		}
	}
	return false;
}

