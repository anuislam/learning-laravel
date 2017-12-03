<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserPermission;
use \Auth;
use \Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;

class adminpageController extends Controller{
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';

    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
    }

    public function index($url_data = ''){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('mix', $url_data) === false) {
             return abort(404);
        }

        if (verify_admin_page($url_data) === false) {
            return abort(404);
        }
        $url_data = str_replace('-', '_', $url_data);

        $path_obj = 'App\AdminPagesubmode\\'.$url_data; 
        if (!class_exists($path_obj)) {
            return abort(404);
        }

        $setting_obj = new $path_obj;

        $roll = $setting_obj->page_setting();
        $capability = (isset($roll['capability'])) ? $roll['capability'] : 'manage_option' ;
        if ($this->permission->user_can($capability, $current_user['id']) === false) {
            return abort(404);
        }

        return view('admin.admin-page',[
            'current_user'        => $current_user,
            'userpermission'      => $this->permission,
            'page'				  => $setting_obj
        ]);
    }


    public function update(Request $data, $option_type){

        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if (url_gard('mix', $option_type) === false) {
             return redirect()->back()->with('error_msg', 'Invalid Option type');
        }

        if (verify_admin_page($option_type) === false) {
            return redirect()->back()->with('error_msg', 'Invalid Option type');
        }

        $option_type = str_replace('-', '_', $option_type);

        $path_obj = 'App\AdminPagesubmode\\'.$option_type;        

        if (!class_exists($path_obj)) {
            return redirect()->back()->with('error_msg', 'Page Not Exists');
        }
        $setting_obj = new $path_obj;

        $roll = $setting_obj->page_setting();
        $capability = (isset($roll['capability'])) ? $roll['capability'] : 'manage_option' ;
        if ($this->permission->user_can($capability, $current_user['id']) === false) {
            return redirect()->back()->with('error_msg', 'You Have No Permission');
        }

        $setting_obj->option_validation($data->all())->validate();

        return $setting_obj->option_update($data->all());
    }


}
