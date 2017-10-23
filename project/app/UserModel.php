<?php

namespace App;
use App\User;
use \Auth;
use Illuminate\Database\Eloquent\Model;
use \DB;
use \Carbon;
use \Validator;
use App\Rules\is_own_email;

class UserModel extends Model
{
    public function get_all_users(){
    	$users = DB::table('users')->offset(0)->limit(10)->get();
    	$users_count = $users->count();
    	$data_data = [];
    	if ($users_count >= 1) {
    		foreach ($users as $value) {
    			$data_data[] = [
    				'id' => $value->id,
    				'profile' => $this->get_gravatar($value->id),
    				'fname' => $value->fname,
    				'lname' => $value->lname,
    				'email' => $value->email,
    				'roll' => ucfirst($value->roll),
    				'created_at' => Carbon\Carbon::parse($value->created_at)->format('Y/m/d'),
    				'updated_at' => Carbon\Carbon::parse($value->updated_at)->format('Y/m/d')
    			];
    		}
    		return $data_data;
    	}else{
    		return false;
    	}
    	
    }

    public function get_gravatar($data){
    	if (is_numeric($data)) {
    		$data = (int)$data;
    		if ($this->user_exists($data)) {
    			$pic = $this->get_user($data);
    			$pic = $pic->email;
    			return $this->get_gravatar_img($pic, 35);
    		}
    	}else if (filter_var( $data, FILTER_VALIDATE_EMAIL )) {
    		if ($this->get_user_by_email($data)) {
    			return $this->get_gravatar_img($data, 35);
    		}
    	}
    	return md5('default');
    }

    public function user_exists($data){
    	$data = (int)$data;
    	$user = $this->get_user($data);
    	$user = $user->id;
    	return ($user) ? $user : false ;
    }

    public function get_user($data){
    	$data = (int)$data;
    	$user = DB::table('users')->where('id', $data)->first();
    	return ($user) ? $user : false ;
    }
    public function get_user_by_email($data){
    	$data = (int)$data;
    	$user = DB::table('users')->where('email', $data)->first();
    	$user = $user->email;
    	return ($user) ? $user : false ;
    }
	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source https://gravatar.com/site/implement/images/php/
	 */
	public function get_gravatar_img( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'https://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';

	        if (count($atts) > 0) {
		        foreach ( $atts as $key => $val )
		        {
		            $url .= ' ' . $key . '="' . $val . '"';
		        }
	        }

	        $url .= ' />';
	    }
	    return $url;
	}

    public function current_user(){
		$cur_user = Auth::user();
		$data = [
			'id'           => $cur_user->id,
			'fname'        => $cur_user->fname,
			'lname'        => $cur_user->lname,
			'email'        => $cur_user->email,
            'profile'      => $this->get_gravatar_img($cur_user->email, 21),
            'description'  => $this->get_user_meta($cur_user->id, 'description'),
            'website'      => $this->get_user_meta($cur_user->id, 'website'),
			'facebook'      => $this->get_user_meta($cur_user->id, 'facebook'),
		];
		return $data;
    }

    public function get_user_meta($id, $key){
        $id = (int)$id;
        $users = DB::table('user_meta')->select('meta_value')->where('user_id', $id)->where('key', $key)->first();
        return (count($users) == 1) ? $users->meta_value : false ;
    }

    public function process_user_data($data){
        $this->validator($data->all())->validate();
        return redirect()->back();
    }

    public function validator($data){
        return Validator::make($data, [
            'id'            => 'required|integer',
            'fname'         => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,25}$/',
            'lname'         => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{1,25}$/',
            'email'         => 'required|string|email|max:255',
            'email'         => ['required', new is_own_email($data['user_id'])],
            'facebook'      => 'url|max:1500',
            'website'       => 'url|max:1500',
        ]);
    }

}
