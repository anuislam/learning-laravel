<?php 

function is_approve($data){
	return ($data == 1) ? true : false ;
}

function is_pending($data){
	return ($data == 0) ? true : false ;
}