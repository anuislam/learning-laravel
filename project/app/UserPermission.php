<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserModel;
use \DB;

class UserPermission extends Model
{


	private $user_rolls 	= [];
	private $user_roll_caps = [];
	private $get_all_roll_cap = [];

   public function __construct(){

        $this->add_user_roll('administrator');
        $this->add_user_roll('author');
        $this->add_user_roll('subscriber');

        $this->add_cap('administrator',[
            'edith_user'        => true,
            'edith_other_user'  => true,
            'edith_post'        => true,
            'edith_others_post'  => true,
            'manage_option'     => true,
            'create_user'    	 => true,
            'edith_roll'    	 => true,
            'delete_user'    	 => true,
            'change_password'    => true,
            'create_tarm'    	 => true,
            'upload_file'    	 => true,
            'edith_media'    	 => true,
            'edith_others_media'    	 => true,
            'delete_media'  => true,   
            'delete_others_media' => true,
            'see_media'    	 	 => true,        
            'see_others_media' 	 => true,
            'read'     => true,
        ]);
        $this->add_cap('author',[
            'edith_user'        => true,
            'edith_other_user'  => true,
            'change_password'  => true,
            'create_tarm'  => true,
            'upload_file'  => true,
            'edith_media'  => true,
            'delete_media'  => true,   
            'see_media'    	 	 => true, 
            'read'  => true,
        ]);
        $this->add_cap('subscriber', [
            'change_password'        => true,
            'read'        => true,
        ]);
        $this->get_all_roll_cap = $this->get_all_roll_cap();

   }

	public function add_user_roll($key, $title = null){
		$this->user_rolls[$key] = $key;
	}

	public function get_roll($first_val = 'Select a role'){
		$data = [];
		$data = ['' => $first_val];
		if (is_array($this->user_rolls)) {
			foreach ($this->user_rolls as $key => $value) {
				$data[$key] = ucfirst($value);
			}
		}

		return $data;
	}


	public function add_cap($roll, $cap = [])	{
		if (in_array($roll, $this->user_rolls)) {
			$this->user_roll_caps[$roll] = [
				'roll' 	=> ucfirst($roll),
				'cap' 	=> $cap,
			];
		}

		
	}

	public function get_all_roll_cap()
	{

		return $this->user_roll_caps;
	}


	public function user_can($rollname, $user_id = ''){
		$user_id = (int)$user_id;
		$user = new UserModel();
		$user_data = $user->get_user($user_id);	
		if ($user_data) {			
			$user_roll = $user_data->roll;
		}else{
			$user_roll = null;
		}
		$all_roll = $this->get_all_roll_cap;
		if (is_array($all_roll)) {
			if (array_key_exists($user_roll,$all_roll)) {
				foreach ($all_roll[$user_roll] as $key => $value) {				
					if ($key == 'cap') {
						if (is_array($value)) {
							foreach ($value as $capkey => $capvalue) {
								if ($rollname == $capkey) {
									if ($capvalue === false) {
										return false;
									}else{
										return true;
									}
									break;
								}
							}
						}
					}	
				}
			}

		}

		return false;
	}

}
