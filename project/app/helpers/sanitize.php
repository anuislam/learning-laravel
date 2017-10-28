<?php

function sanitize_text($data){
	$data = strip_tags($data);
	$data = htmlentities($data);
	$data = htmlspecialchars($data);
	$data = filter_var($data, FILTER_SANITIZE_STRING);
	return $data;
}

function sanitize_url($data, $scheme = 'http://'){	
	if (empty($data) === false) {
		return parse_url($data, PHP_URL_SCHEME) === null ? filter_var($scheme . $data, FILTER_SANITIZE_URL) : filter_var($data, FILTER_SANITIZE_URL) ;
	}

	return '';
  	
}

function sanitize_email($data){	
	return filter_var($data, FILTER_SANITIZE_EMAIL);  	
}


function is_email($data){
	if (filter_var( $data, FILTER_VALIDATE_EMAIL )) {		
		return true;
	} 
	return true;
}