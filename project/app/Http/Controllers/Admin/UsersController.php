<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class UsersController extends Controller
{
    private $usermodel = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel = new UserModel();
    }


    public function index()
    {
        $usermodel          = $this->usermodel;
        $current_user       = $usermodel->current_user();
        return view('admin.yourprofile',[
            'current_user'      => $current_user,
        ]);
    }


    public function all_users(){
        $usermodel      = $this->usermodel;
        $get_all_users  = $usermodel->get_all_users();
        $current_user   = $usermodel->current_user();

        return view('admin.AllUsers', [
            'get_all_users' => $get_all_users,
            'current_user'  => $current_user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $current_user   = $this->usermodel->current_user();
        return view('admin.addnewuser',[
            'current_user'      => $current_user,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_user = $this->usermodel;
        return $store_user->process_user_data($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $id = (int)$id;
        if (url_gard('integer', $id)) {            
            $current_user   = $this->usermodel->current_user();
            $edith_user     = $this->usermodel->edith_user_data($id);
            if ($edith_user) {
                return view('admin.edithprofile',[
                    'current_user'      => $current_user,
                    'edith_user'      => $edith_user,
                ]);
            }
        }
        return '<h1>404 page</h1>';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $id = (int)$id;
        if (url_gard('integer', $id)) {            
             return $this->usermodel->process_edith_user_data($request, $id);
        }
        return redirect()->back()->with('error_msg', 'Update faield.' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
      
    }


}
