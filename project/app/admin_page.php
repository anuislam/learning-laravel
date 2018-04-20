<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use App\options;

class admin_page extends Model{

    public function page_setting(){
    	//sss
    	return false;
    }

    public function page_content_output($error_msg=''){
    	return false;
    }


    public function option_update($data){
    	return false;
    }

    public function option_validation($data){
    	return false;
    }

}
