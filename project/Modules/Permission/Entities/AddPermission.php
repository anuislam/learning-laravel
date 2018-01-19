<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use App\options;
use App\UserModel;
use DB;



trait AddPermission{
    private $option = '';
    private $role = [];
    private $user_role_caps = [];

    public function __construct(){
        $this->option = new options('user_role');
    }

    public function role($role = []){
        if ($this->get_role($role['role']) === false) {            
            $all_role = $this->get_all_user_roll_and_cap();
            $all_role = (empty($all_role) === false) ? $all_role : [] ;
            $all_role = array_merge($all_role, [
                $role['role']   => [
                    $role['role']   => $role['role'],
                    'title'         => $role['title'],
                    'cap'           => '',
                ]
            ]);            
            $this->option->add_option('user_role', $all_role);
            $this->option->option_update();
        }
        return $this;
    }

    public function cap($role, $cap = []){
        $all_role = $this->get_all_user_roll_and_cap();
        if (array_key_exists($role, $all_role)){
            if (empty($all_role[$role]['cap']) === false) {
                $all_role[$role]['cap'] = array_merge($all_role[$role]['cap'], $cap);
            }else{
                $all_role[$role] = [
                    'role'  => $role,
                    'title'     => $all_role[$role]['title'],
                    'cap'   => $cap,
                ];
            }
            $this->option->add_option('user_role', $all_role);
            $this->option->option_update();
        }
        return $this;
    }

    public function get_role($role){
        $ret_data = false;
        $data = get_option('user_role');
        if (is_array($data['user_role'])) {
            foreach ($data['user_role'] as $key => $value) {
                if ($role == $key) {
                    $ret_data = $data['user_role'][$key];
                    break;
                }
            }
        }
        return $ret_data;
    }

    public function get_cap($role, $cap){
        $ret_data = false;
        $data = $this->get_role($role);
        if (empty($data['cap']) === false) {
            foreach ($data['cap'] as $key => $value) {
                if ($cap == $key) {
                    if ($value) {
                        $ret_data = $key;
                    }
                    break;
                }
            }
        }
        return $ret_data;
    }

    public function add(){
        $this->option->add_option('user_role', $this->user_role_caps);
        $this->option->option_update();
    }

    public function get_all_user_roll_and_cap(){
        $data = get_option('user_role');
        $data = $data['user_role'];
        return $data;
    }
    public function user_can($rollname, $user_id){
        $user = new UserModel();
        $user_data = $user->get_user($user_id);
        if ($user_data) {           
            $user_role = $user_data->roll;
        }else{
            $user_role = null;
        }
        return $this->get_cap($user_role, $rollname);
    }

    public function remove_cap($role, $cap){
        $all_role = $this->get_all_user_roll_and_cap();
        if (array_key_exists($role, $all_role)){
            if (empty($all_role[$role]['cap'][$cap]) === false) {
                unset($all_role[$role]['cap'][$cap]);
            }
            $this->option->add_option('user_role', $all_role);
            $this->option->option_update();
        }
        return $this;
    }

}
