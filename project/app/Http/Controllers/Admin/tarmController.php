<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;
use App\UserPermission;
use App\TarmModel;
use \Auth;
use \DB;
use DataTables;

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

            $tarm_opject = new $tarm_opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return '404 page';
            }

            return view('admin.createTarm',[
                    'current_user'      => $current_user,
                    'userpermission'    => $this->permission,
                    'tarm_opject'       => $tarm_opject,
                ]);

        }

        $tarm_opject = new TarmModel();

        if ($tarm_opject->user_can($current_user['id']) === false) {
            return '404 page';
        }

        return view('admin.createTarm',[
                'current_user'      => $current_user,
                'userpermission'    => $this->permission,
                'tarm_opject'       => $tarm_opject,
            ]);

    }


    public function stor(Request $request, $tarmname = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {
            if (url_gard('string', $tarmname) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if (verify_registered_tarm($tarmname) === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = 'App\TarmSubModel\\'.$tarmname;

            if (!class_exists($tarm_opject)) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = new $tarm_opject();

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
            if (url_gard('string', $tarmname) === false) {
               return false;
            }

            if (verify_registered_tarm($tarmname) === false) {
                return false;
            }

            $tarm_opject = 'App\TarmSubModel\\'.$tarmname;

            if (!class_exists($tarm_opject)) {
                return false;
            }

            $tarm_opject = new $tarm_opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return false;
            }

            return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', $tarmname))
            ->addColumn('action', function ($tarm) {
                $tarm_type = json_decode(json_encode($tarm), true);
                return '<a href="'.route('edit-tarm', $tarm->id).'/'.$tarm_type['tarm-type'].'" class="btn btn-secondary">Edith</a> <a

            onclick="data_modal(this)" 
            data-title="Ready to Delete?"
            data-message=\'Are you sure you want to delete this?\'
            cancel_text="Cancel"
            submit_text="Delete"
            data-type="post"
            data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


                href="'.route('delete-tarm', $tarm->id).'" class="btn btn-danger">Delete</a>';
            })        
            ->escapeColumns(['*'])
            ->make(true);
        }

       $tarm_opject = new TarmModel();

       if ($tarm_opject->user_can($current_user['id']) === false) {
           return false;
       }

       return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', 'category'))
        ->addColumn('action', function ($tarm) {
            global $tarmname;
            return '<a href="'.route('edit-tarm', $tarm->id).'/" class="btn btn-secondary">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete this?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('delete-tarm', $tarm->id).'" class="btn btn-danger">Delete</a>';
        })        
        ->escapeColumns(['*'])
        ->make(true);
    }


    public function edith_tarms($tarmid = '', $tarmname = ''){
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {

            if (url_gard('integer', $tarmid) === false) {
               return '404 page';
            }

            if (url_gard('string', $tarmname) === false) {
               return '404 page';
            }

            if (verify_registered_tarm($tarmname) === false) {
                return '404 page';
            }

            $tarm_opject = 'App\TarmSubModel\\'.$tarmname;

            if (!class_exists($tarm_opject)) {
                return '404 page';
            }

            $tarm_opject = new $tarm_opject();

            if ($tarm_opject->user_can($current_user['id']) === false) {
                return '404 page';
            }

            if ($tarm_opject->get_tarms($tarmid) === false) {
                return '404 page';
            }

            return view('admin.edit-tarm',[
                    'current_user'      => $current_user,
                    'userpermission'    => $this->permission,
                    'tarm_opject'       => $tarm_opject,
                    'get_tarm'          => $tarm_opject->get_tarms($tarmid),
                ]);

        }

        if (url_gard('integer', $tarmid) === false) {
           return '404 page';
        }


        $tarm_opject = new TarmModel();

        if ($tarm_opject->user_can($current_user['id']) === false) {
            return '404 page';
        }

        if ($tarm_opject->get_tarms($tarmid) === false) {
            return '404 page';
        }

        return view('admin.edit-tarm',[
                'current_user'      => $current_user,
                'userpermission'    => $this->permission,
                'tarm_opject'       => $tarm_opject,
                'get_tarm'          => $tarm_opject->get_tarms($tarmid),
            ]);
    }

    public function edit_tarm_update(Request $request , $tarm_id = '', $tarmname = '') {
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if (empty($tarmname) === false) {
            if (url_gard('string', $tarmname) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if (url_gard('integer', $tarm_id) === false) {
               return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            if (verify_registered_tarm($tarmname) === false) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = 'App\TarmSubModel\\'.$tarmname;

            if (!class_exists($tarm_opject)) {
                return redirect()->back()->with('error_msg', 'Operation failed.');
            }

            $tarm_opject = new $tarm_opject();

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

        DB::table('tarms')->where('id', $id)->delete();    
        return redirect()->back()->with('success_msg', 'Delete successful.' );
    }


}
