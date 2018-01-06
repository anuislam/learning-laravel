<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\UserModel;
use Session;

class facebookController extends Controller{

    public function __construct(){
        $this->usermodel = new UserModel();  
    }

    public function facebook_action(){
		if (!Auth::check()) {
			return Socialite::driver('facebook')->scopes(['email'])->redirect();
		}
		  return redirect()->to('/');
    }

    public function facebook_calback(){

      if (Auth::check()) {
        return redirect()->to('/');
      }


      $user = Socialite::driver('facebook')->user();
      $fb_user_email  = (isset($user->email)) ? $user->email : '' ;
      $site_user = $this->usermodel->get_user_by_email($fb_user_email);
      if ($site_user) {   
          Auth::loginUsingId($site_user->id);
          return redirect()->to('/');
        }else{                    
          $value = [
            'user' => [
              'fname' => (isset($user->name)) ? $user->name : '' ,
              'lname' => (isset($user->nickname)) ? $user->nickname : '' ,
              'image' => (isset($user->avatar)) ? $user->avatar : '' ,
              'email' => (isset($user->email)) ? $user->email : '' ,
              'id'      => (isset($user->id)) ? $user->id : '' ,
              'provider' => 'facebook',
            ]
          ];
          Session::put('socialprovider', $value);
          return redirect()->route('show_confirm_registration');
        }

    }
}
