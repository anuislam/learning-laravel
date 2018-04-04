<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserPermission;
use \Auth;
use App\notifications;




class UsersController extends Controller
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


    public function index()
    {
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        if ($this->permission->user_can('read', $current_user['id'])) {
            return view('admin.yourprofile',[
                'current_user'      => $current_user,
                'userpermission'      => $this->permission,
                'notification'        => $this->notification->get_header_notification(),
            ]);
        }
        return abort(404);
    }


    public function all_users(){
         
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if ($this->permission->user_can('edith_other_user', $current_user['id'])) {
            return view('admin.AllUsers', [
                'current_user'        => $current_user,
                'userpermission'      => $this->permission,
                'notification'        => $this->notification->get_header_notification(),
            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $current_user   = $this->usermodel->current_user();

        if ($this->permission->user_can('create_user', $current_user['id']) === false) {
            return abort(404);
        }

        return view('admin.addnewuser',[
            'current_user'          => $current_user,
            'userpermission'        => $this->permission,
            'notification'        => $this->notification->get_header_notification(),
        ]);

    }

    public function stor_user(Request $request){
        $cur_user = Auth::user();
        if ($this->permission->user_can('create_user', $cur_user->id) === false) {
            return redirect()->back()->with('error_msg', 'Operation failed.' );
        }

        return $this->usermodel->insert_user($request);

        return redirect()->back()->with('error_msg', 'Operation failed.' );

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $cur_user = Auth::user();
        if ($this->permission->user_can('edith_user', $cur_user->id) === false) {
            return redirect()->back()->with('error_msg', 'Update failed.' );
        }

        $store_user = $this->usermodel;
        return $store_user->process_user_data($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if (url_gard('integer', $id)) {   

            $current_user   = $this->usermodel->current_user();

            if ($this->permission->user_can('edith_other_user', $current_user['id']) === false) {
                return abort(404);
            }


            $edith_user     = $this->usermodel->edith_user_data($id);
            if ($edith_user) {
                return view('admin.edithprofile',[
                    'current_user'          => $current_user,
                    'edith_user'            => $edith_user,
                    'userpermission'        => $this->permission,
                    'notification'        => $this->notification->get_header_notification(),
                ]);
            }
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $cur_user = Auth::user();
        if ($this->permission->user_can('edith_other_user', $cur_user->id) === false) {
            return redirect()->back()->with('error_msg', 'Update failed.' );
        }

        if (url_gard('integer', $id)) {           
             return $this->usermodel->process_edith_user_data($request, $id);
        }
        return redirect()->back()->with('error_msg', 'Update failed.' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $cur_user = Auth::user();
        if (url_gard('integer', $id) === false) {
            return redirect()->back()->with('error_msg', 'Invalid Url.' );
        }

        if ($this->permission->user_can('delete_user', $cur_user->id) === false) {
            return redirect()->back()->with('error_msg', 'You have no delete permission.' );
        }

        $deleteble_user = $this->usermodel->get_user($id);
        if ($deleteble_user) {
            if ('administrator' == $deleteble_user->roll) {
                return redirect()->back()->with('error_msg', 'Administrator not deletable.' );
            }

            return $this->usermodel->destroy_user($id);
        }


        return redirect()->back()->with('error_msg', 'Operation failed.' );
    }


    public function change_password(){
        $cur_user = Auth::user();
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();

        if ($this->permission->user_can('change_password', $cur_user->id) === false) {
            return abort(404);
        }

        return view('admin.changePassword',[
                    'current_user'          => $current_user,
                    'userpermission'        => $this->permission,
                    'notification'        => $this->notification->get_header_notification(),
                ]);
    }

    public function update_change_password(Request $request){   
        $cur_user = Auth::user();     
        $this->usermodel->change_password_validation($request->all())->validate();
        return $this->usermodel->update_password($cur_user, $request['password']);
        return redirect()->back()->with('error_msg', 'Operation failed.' );
    }

}
