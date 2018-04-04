<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Validator;
use DB;
use Purifier;

class notifications extends Model{


    public function __construct(){
    }

    public function get_header_notification(){

        ob_start();

            do_action('header_notification');

        return ob_get_clean();
    }
    
}
