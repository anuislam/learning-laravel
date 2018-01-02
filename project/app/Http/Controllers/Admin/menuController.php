<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\menuModel;
use App\UserPermission;
use App\UserModel;
use App\mediaModel;
use App\BlogPost;
use Validator;

class menuController extends Controller
{
	private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';

	public function __construct() {
	    $this->middleware('auth'); 
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();
	}

	public function add_item(Request $data){
        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('manage_option', $current_user['id']) === false) {   
            return false;
        }

		$data = $data->all();
		$menu = new menuModel();
		$insert = $menu->insert_menu_item([
			'name' => $data['name'],
			'url' => $data['url'],
			'main_menu_id' => $data['main_menu_id'],
		]);

		if ($insert) {
			$ret_data = [
				'status' => 'ok',
				'id' => $insert,
				'name' => $data['name'],
				'url' => $data['url']

			];
			return json_encode($ret_data);
		}else{
			echo 'not ok';
		}		
	}

	public function delete_item(Request $data){
        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('manage_option', $current_user['id']) === false) {   
            return false;
        }

		$data = $data->all();
		$menu = new menuModel();
		if ($menu->menu_exists($data)) {
			$menu->menu_delete($data);
			echo 'ok';
		}else{
			echo 'Error!';
		}
	}
	public function add_main_menu(Request $data){
        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('manage_option', $current_user['id']) === false) {   
            return false;
        }
		$menu = new menuModel();
		$data = $data->all();
		$menu->main_menu_validate($data)->validate();
		$id = $menu->main_menu_save($data['insert_main_menu']);
		if ($id) {			
			return redirect()
			->route('create_post_type',['nav-menu', 'menu-id'=>$id])
			->with('success_msg', 'Menu create successful.');
		}
		return redirect()->back()->with('error_msg', 'Failed to create Menu.');
	}

	public function delete_main_menu(Request $data){
        $current_user   = $this->usermodel->current_user();
        if ($this->permission->user_can('manage_option', $current_user['id']) === false) {   
            return false;
        }
        $menu = new menuModel();
		$data = $data->all();
		if ($menu->main_menu_exists((int)$data['menid'])) {
			$menu->delete_menu_with_children((int)$data['menid']);
			return redirect()->back()->with('success_msg', 'Menu delete successful.');
		}
		return redirect()->back()->with('error_msg', 'Failed to delete Menu.');
	}


}
