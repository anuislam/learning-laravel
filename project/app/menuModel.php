<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Validator;
class menuModel extends Model{

    public function insert_menu_item($data){
		$id = DB::table('menu_items')->insertGetId([
			'title' => sanitize_text($data['name']),
			'url' => sanitize_url($data['url']),
			'menu_id' => (int)$data['main_menu_id']
		]);
		if ($id) {
			return $id;
		}
		return false;
    }

    public function menu_exists($data) {
    	$menu = DB::table('menu_items')
    	->select('id')
    	->where('id', '=', (int)$data['id'])
    	->where('menu_id', (int)$data['menu_id'])->count();
    	return ($menu == 1) ? true : false;
    }

    public function menu_delete($data) {
    	$menu = DB::table('menu_items')
    	->where('id', '=', (int)$data['id'])
    	->where('menu_id', '=', (int)$data['menu_id'])
    	->delete();
    	return ($menu) ? true : false;
    }

    public function main_menu_exists($data) {
    	$menu = DB::table('menus')
    	->select('id')
    	->where('id', '=', (int)$data)
    	->count();
    	return ($menu == 1) ? true : false;
    }

    public function main_menu_save($name) {
    	$id = DB::table('menus')->insertGetId([
			'name' => sanitize_text($name),
	        'created_at' => new \DateTime(),
	        'updated_at' => new \DateTime(),
		]);
		if ($id) {
			return $id;
		}
		return false;
    }


    public function main_menu_validate($data){
		return Validator::make($data, [
		        'insert_main_menu' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,255}$/|unique:menus,name',
		    ], [
		  'insert_main_menu.regex'    => 'The Menu name format is invalid.',
		  'insert_main_menu.required' => 'The Menu name field is required.',
		  'insert_main_menu.max'      => 'The Menu name may not be greater than 255 characters.',
		  'insert_main_menu.string'   => 'The Menu name must be given string.',
		  'insert_main_menu.unique'   => 'The Menu name has already been taken.',

		]);
    }

    public function get_all_main_menu_for_admin_panel(){
    	$menu = DB::table('menus')
    	->offset(0)
        ->limit(50)
    	->get();

    	if ($menu) {
    		return $menu;
    	}
    	return false;
    }

    public function delete_menu_with_children($data){
        $data = (int)$data;
        DB::table('menus')->where('id', '=', $data)->delete();
        DB::table('menu_items')->where('menu_id', '=', $data)->delete();
    }
}
