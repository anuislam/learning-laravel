<?php

namespace App\Http\Controllers\admin;
use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserDatatable extends Controller
{
    public function index(){
		return DataTables::of(DB::table('users')->select('id','fname', 'lname', 'email', 'roll', 'created_at', 'updated_at'))
		->addColumn('action', function ($user) {
                return '<a href="'.route('user.edit', $user->id).'" class="btn btn-secondary">Edith</a> <a

			onclick="data_modal(this)" 
			data-title="Ready to Delete?"
			data-message=\'Are you sure you want to delete the user account?\'
			cancel_text="Cancel"
			submit_text="Delete"
			data-type="post"
			data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


                href="'.route('user.destroy', $user->id).'" class="btn btn-danger">Delete</a>';
            })
		->addColumn('profile', function ($user) {
                return '<img src="'.get_gravatar_custom_img( $user->email, 35 ).'" alt="'.$user->fname.' '.$user->lname.'" width="35" height="35">';
            })
		->escapeColumns(['*'])
		->make(true);

    }
}
