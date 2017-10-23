<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
    	$usermodel   = new UserModel();
        $current_user   = $usermodel->current_user();
        return view('admin.dashboard',[
            'current_user'  => $current_user,
        ]);
    }
}
