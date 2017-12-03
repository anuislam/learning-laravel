<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Form;
use Auth;
use Validator;
use DB;
use Purifier;

class options extends Model{

    private $data_value = array();
    private $option_type 		= '';

    public function __construct($data){
        $this->option_type    = sanitize_text($data);  
    }

    public function add_option($opt_key, $val){
    	$this->data_value[$opt_key] = $val;
    }

    public function option_update(){
    	if ($this->option_exists()) {
    		$data = DB::table('options');
    		$data->where('options_key',  $this->option_type);
            $data->update([
                'options_value' => serialize($this->data_value)
            ]);
    	}else{
			DB::table('options')->insert([
			    'options_key' 	=> $this->option_type,
			    'options_value' => serialize($this->data_value)
			]);
    	}
    	return true;
    }

    public function option_exists(){
    	$data = DB::table('options')->select('options_key', 'options_value')->where('options_key', $this->option_type);

    	return ($data->count() > 0) ? $data->first() : false ;
    }

}
