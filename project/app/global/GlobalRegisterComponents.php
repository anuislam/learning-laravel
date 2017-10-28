<?php 
$GlobalTarms 	= [];
$GlobalPostType = [];

function register_tarm($data = []){
	global $GlobalTarms;
	$GlobalTarms[] = $data;
}

function register_post_type($data = []){
	global $GlobalPostType;
	$GlobalPostType[] = $data;
}


function get_registered_tarms(){
	global $GlobalTarms;
	return $GlobalTarms;
}

function get_registered_post_type(){
	global $GlobalPostType;
	return $GlobalPostType;
}

