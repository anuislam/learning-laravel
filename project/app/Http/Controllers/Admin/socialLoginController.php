<?php

namespace App\Http\Controllers\Admin;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
class socialLoginController extends Controller
{

    public function confirm_registration(Request $data) {
        if (!Auth::check()) {
            $socialprovider = Session::get('socialprovider');
            if ($socialprovider) {
                $data = $data->all();
                $usermodel = new UserModel();
                $usermodel->social_login_validator($data)->validate();
                $user_id = $usermodel->reginser_using_solcial([
                    'fname'     => $data['fname'],
                    'lname'     => $data['lname'],
                    'roll'      => 'author',
                    'email'     => $data['email'],
                    'password'  => $data['password'],
                    'provider'  => $socialprovider['user']['provider'],
                    'profile_image'  => $data['profile_image'],
                ]);
                session()->forget('socialprovider');
                session()->flush();
                Auth::loginUsingId($user_id);// login 
            }

        }
        return redirect()->to('/');
    }

    public function show_confirm_registration(){
        if (!Auth::check()) {
            $socialprovider = Session::get('socialprovider');
            if ($socialprovider) {            
                return view('auth.loginwithsocial', $socialprovider);
            }
            return redirect()->route('login');
        }
        return redirect()->to('/');
    }
}
