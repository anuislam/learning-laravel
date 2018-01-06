<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\UserModel;
use Session;

class googleController extends Controller{

    public function __construct(){
        $this->usermodel = new UserModel();  
    }

    public function google_action(){
  		if (!Auth::check()) {
  			return Socialite::driver('google')->scopes(['profile','email'])->redirect();
  		}
		  return redirect()->to('/');
    }

    public function google_calback(){

      if (Auth::check()) {
        return redirect()->to('/');
      }

      $user = Socialite::driver('google')->user();
      $google_user_email  = (isset($user->email)) ? $user->email : '' ;
      $site_user = $this->usermodel->get_user_by_email($google_user_email);
      if ($site_user) {   
        Auth::loginUsingId($site_user->id);
          return redirect()->to('/');
      }else{                    
        $value = [
          'user' => [
            'fname' => (isset($user->name)) ? $user->name : '' ,
            'lname' => (isset($user->nickname)) ? $user->nickname : '' ,
            'image' => (isset($user->avatar)) ? $user->avatar_original : '' ,
            'email' => (isset($user->email)) ? $user->email : '' ,
            'id'      => (isset($user->id)) ? $user->id : '' ,
            'provider' => 'google',
          ]
        ];
        Session::put('socialprovider', $value);
        return redirect()->route('show_confirm_registration');
      }  
        
    }
}
