<?php 

function post_is_pending($value){
	return ($value == 0 ) ? true : false ;
}
function post_is_publish($value){
	return ($value == 1 ) ? true : false ;
}
function post_is_trush($value){
	if ($value == 2) {
		return true;
	} else if ($value > 3) {
		return true;
	}
	return false;
}
function post_is_poned($value){
	return ($value == 3 ) ? true : false ;
}
