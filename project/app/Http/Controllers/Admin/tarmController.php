<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;
use App\UserPermission;
use App\TarmModel;
use \Auth;
use \DB;

class tarmController extends Controller
{

    private $usermodel = '';
    private $permission = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel = new UserModel();
        $this->permission = new UserPermission();  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($url_data = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($url_data) === false) {
            if (url_gard('string', $url_data) === false) {
               return '404 page';
            }

            if (verify_registered_tarm($url_data) === false) {
                return '404 page';
            }

            $tarm_opject = 'App\TarmSubModel\\'.$url_data;

            if (!class_exists($tarm_opject)) {
                return '404 page';
            }

            return view('admin.createTarm',[
                    'current_user'      => $current_user,
                    'userpermission'    => $this->permission,
                    'tarm_opject'       => new $tarm_opject(),
                ]);

        }

        return view('admin.createTarm',[
                'current_user'      => $current_user,
                'userpermission'      => $this->permission,
                'tarm_opject'       => new TarmModel(),
            ]);

    }

}
