<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use Form;
use DB;
use Module;
use App\UserPermission;

class Hooks extends Model{

    public function __construct() {
		$this->permission_module_load();
    }

    public function permission_module_load()    {
		if (Module::has('Permission')) {
			$module = Module::find('Permission');
			$module = $module->json('module.json');
			if ((int)$module->active === 1) {

				$user_rool = new UserPermission();
				$user_rool->role([
				   'role' => 'administrator',
				   'title' => 'Administrator',
				])->role([
				   'role' => 'author',
				   'title' => 'Author',
				])->role([
				   'role' => 'subscriber',
				   'title' => 'Subscriber',
				])
				->cap('administrator', [
				    'edith_user'        => true,
				    'edith_other_user'  => true,
				    'edith_post'        => true,
				    'edith_others_post'  => true,
				    'create_posts'  => true,
				    'read_post'          => true,
				    'read_others_post'  => true,
				    'delete_post'  => true,   
				    'delete_others_post' => true,
				    'manage_option'     => true,
				    'create_user'        => true,
				    'edith_roll'         => true,
				    'delete_user'        => true,
				    'change_password'    => true,
				    'create_tarm'        => true,
				    'upload_file'        => true,
				    'edith_media'        => true,
				    'edith_others_media'         => true,
				    'delete_media'  => true,   
				    'delete_others_media' => true,
				    'see_media'          => true,        
				    'see_others_media'   => true,
				    'edith_page'         => true,
				    'edith_other_page'   => true,
				    'read'     => true,
				])
				->cap('author', [
				    'edith_user'        => true,
				    'edith_other_user'  => true,
				    'change_password'  => true,
				    'create_tarm'  => true,
				    'upload_file'  => true,
				    'edith_media'  => true,
				    'delete_media'  => true,   
				    'see_media'          => true, 
				    'read'  => true,
				])
				->cap('subscriber', [
				    'change_password'        => true,
				    'read'        => true,
				]);

			}
		}
    }

}