<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;
use App\mediaModel;
use App\UserPermission;
use App\TarmModel;
use \Auth;
use \DB;
use DataTables;
use App\notifications;

class tarmController extends Controller
{

    private $usermodel = '';
    private $permission = '';
    private $notification = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel = new UserModel();
        $this->permission = new UserPermission();
        $this->notification    = new notifications(); 
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

            if (url_gard('mix', $url_data) === false) {
               return abort(404);
            }

            $opject = verify_registered_tarm($url_data);

            if ($opject === false) {
                return abort(404);
            }

            if(!class_exists($opject)){
                return abort(404);
            }

            $tarm_opject = new $opject;

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return abort(404);
            }

            return view('admin.createTarm',[
                    'current_user'      => $current_user,
                    'userpermission'    => $this->permission,
                    'tarm_opject'       => $tarm_opject,
                    'tarm_type_name'    => $url_data,
                    'notification'        => $this->notification->get_header_notification(),
                ]);

        }

        $tarm_opject = new TarmModel();

        if ($tarm_opject->user_can($current_user['id']) === false) {
            return abort(404);
        }

        return view('admin.createTarm',[
                'current_user'      => $current_user,
                'userpermission'    => $this->permission,
                'tarm_opject'       => $tarm_opject,
                'tarm_type_name'    => NULL,
                'notification'        => $this->notification->get_header_notification(),
            ]);

    }


    public function stor(Request $request, $tarmname = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {
            if (url_gard('mix', $tarmname) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $opject = verify_registered_tarm($tarmname);

            if ($opject === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if(!class_exists($opject)){
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = new $opject;

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            return $tarm_opject->tarm_data_process($request, $tarmname);
        }

       $tarm_opject = new TarmModel();

       if ($tarm_opject->user_can($current_user['id']) === false) {
           return redirect()->back()->with('error_msg', 'Operation failed.');
       }

       return $tarm_opject->tarm_data_process($request, 'category');
    }

    public function get_all(Request $request, $tarmname = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {
            if (url_gard('mix', $tarmname) === false) {
               return false;
            }

            $opject = verify_registered_tarm($tarmname);

            if ($opject === false) {
                return false;
            }

            if(!class_exists($opject)){
                return false;
            }

            $tarm_opject = new $opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return false;
            }
           return $tarm_opject->tarm_data_for_datatable($tarmname);
                       
        }

       $tarm_opject = new TarmModel();

       if ($tarm_opject->user_can($current_user['id']) === false) {
           return false;
       }

       return $tarm_opject->tarm_data_for_datatable('category');

    }


    public function edith_tarms($tarmid = '', $tarmname = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {

            if (url_gard('integer', $tarmid) === false) {
               return abort(404);
            }

            if (url_gard('mix', $tarmname) === false) {
               return abort(404);
            }


            $opject = verify_registered_tarm($tarmname);

            if ($opject === false) {
                 return abort(404);
            }

            if(!class_exists($opject)){
                 return abort(404);
            }

            $tarm_opject = new $opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return abort(404);
            }

            if ($tarm_opject->get_tarms($tarmid) === false) {
                return abort(404);
            }

            $chack_tarm = $tarm_opject->get_tarms($tarmid);
            $chack_tarm = json_decode(json_encode($chack_tarm), true);
            if ($chack_tarm['tarm-type'] != $tarmname) {
                return abort(404);
            }
            
            return view('admin.edit-tarm',[
                    'current_user'      => $current_user,
                    'userpermission'    => $this->permission,
                    'tarm_opject'       => $tarm_opject,
                    'get_tarm'          => $tarm_opject->get_tarms($tarmid),
                    'tarm_type_name'    => $tarmname,
                    'notification'        => $this->notification->get_header_notification(),
                ]);

        }

        if (url_gard('integer', $tarmid) === false) {
           return abort(404);
        }


        $tarm_opject = new TarmModel();

        if ($tarm_opject->user_can($current_user['id']) === false) {
            return abort(404);
        }

        if ($tarm_opject->get_tarms($tarmid) === false) {
            return abort(404);
        }

        $chack_tarm = $tarm_opject->get_tarms($tarmid);
        $chack_tarm = json_decode(json_encode($chack_tarm), true);
        if ($chack_tarm['tarm-type'] != 'category') {
            return abort(404);
        }

        return view('admin.edit-tarm',[
                'current_user'      => $current_user,
                'userpermission'    => $this->permission,
                'tarm_opject'       => $tarm_opject,
                'get_tarm'          => $tarm_opject->get_tarms($tarmid),
                'tarm_type_name'    => NULL,
                'notification'        => $this->notification->get_header_notification(),
            ]);
    }

    public function edit_tarm_update(Request $request , $tarm_id = '', $tarmname = '') {
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {
            if (url_gard('mix', $tarmname) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if (url_gard('integer', $tarm_id) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $opject = verify_registered_tarm($tarmname);

            if ($opject === false) {
                 return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if(!class_exists($opject)){
                 return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = new $opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if ($tarm_opject->get_tarms($tarm_id) === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }
            return $tarm_opject->tarm_edit_data_process($request, $tarm_id);
        }

       $tarm_opject = new TarmModel();


        if (url_gard('integer', $tarm_id) === false) {
           return redirect()->back()->with('error_msg', 'Operation failed.');
        }

        if ($tarm_opject->get_tarms($tarm_id) === false) {
            return redirect()->back()->with('error_msg', 'Operation failed.');
        }


       if ($tarm_opject->user_can($current_user['id']) === false) {
           return redirect()->back()->with('error_msg', 'Operation failed.');
       }

       return $tarm_opject->tarm_edit_data_process($request, $tarm_id);
    }


    public function delete_tarm($id='') {
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        $tarm_opject = new TarmModel();
        if (url_gard('integer', $id) === false) {
           return redirect()->back()->with('error_msg', 'Operation failed.');
        }

        if ($tarm_opject->get_tarms($id) === false) {
            return redirect()->back()->with('error_msg', 'Operation failed.');
        }

        if ($this->permission->user_can('delete_tarms', $current_user['id'])) {
            return redirect()->back()->with('error_msg', 'Operation failed.');
        }

        $tarm_opject->delete_tarm_with_meta((int)$id);   
        return redirect()->back()->with('success_msg', 'Delete successful.' );
    }


}
