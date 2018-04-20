<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DotenvEditor;
use Auth;
use App\notifications;


class DashboardController extends Controller
{
    private $notification = '';
    public function __construct()
    {
        $this->middleware('auth');
         $this->notification    = new notifications(); 
    }


    public function index()
    {
    	$usermodel   = new UserModel();
        $current_user   = $usermodel->current_user();
        return view('admin.dashboard',[
            'current_user'          => $current_user,
            'notification'          => $this->notification->get_header_notification(),
        ]);
    }
}
