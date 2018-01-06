<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\UserModel;
use Session;

class twitterController extends Controller{

    public function __construct(){
        $this->usermodel = new UserModel();  
    }

    public function twitter_action(){
  		if (!Auth::check()) {
  			return Socialite::driver('twitter')->redirect();
  		}
		  return redirect()->to('/');
    }

    public function twitter_calback(){

      if (Auth::check()) {
        return redirect()->to('/');
      }


      $user = Socialite::driver('twitter')->user();
      $twitter_user_email   = (isset($user->email)) ? $user->email : '' ;
      $site_user = $this->usermodel->get_user_by_email($twitter_user_email);
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
              'provider' => 'twitter',
            ]
          ];
          Session::put('socialprovider', $value);
          return redirect()->route('show_confirm_registration');
        }


    }
}
