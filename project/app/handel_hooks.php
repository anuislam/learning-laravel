<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use DB;
use App\UserPermission;
use Auth;
use Carbon;
use App\UserModel;
use App\BlogPost;
use Illuminate\Support\Str;


class handel_hooks extends Model{
	private $permission = '';
	private $usermodel = '';
	private $post = '';
	private $comment = '';

	public function __construct(){
		$this->permission   = new UserPermission();
		$this->usermodel    = new UserModel();
		$this->post    		= new BlogPost();
		//add_action( 'editor_buttons',[$this, 'add_media_buttons'] );
    }

}
