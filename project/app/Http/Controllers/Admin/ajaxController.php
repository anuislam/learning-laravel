<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\handelAjax;

class ajaxController extends Controller{

    public function handle_ajax_request(Request $data){
        $dataval = $data->all();   
        if($data->ajax()){ 
	        $action = $dataval['action'];	
	        ob_start();
	        	do_action( 'ajax_'.$action, $data );
	        return ob_get_clean();    
        }
    }
}
