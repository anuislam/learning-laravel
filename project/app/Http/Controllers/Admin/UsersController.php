<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $usermodel          = new UserModel();
        $current_user       = $usermodel->current_user();
        return view('admin.yourprofile',[
            'current_user'      => $current_user,
        ]);
    }


    public function all_users(){
        $usermodel      = new UserModel();
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_user = new UserModel();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




}
