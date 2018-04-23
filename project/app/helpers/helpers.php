<?php


function read_more($num, $text) {
    $limit = $num+1;
    $excerpt = explode(' ', sanitize_text($text), $limit);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
    return $excerpt;
}


	function get_gravatar_custom_img( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
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

	function url_gard($name, $value){
		if (empty($value) === false) {
			switch ($name) {
            case 'integer':
                return (preg_match('/^[0-9]{0,250}$/', $value)) ? true : false ;
                break;   
            case 'string':
                return (preg_match('/^[a-zA-Z]{0,250}$/', $value)) ? true : false ;
                break;  
            case 'mix':
                return (preg_match('/^[a-zA-Z0-9\-]{0,250}$/', $value)) ? true : false ;
                break;            
            default:
                return true;
                break;
	        
	        }		
	    }
	    return false;

    }

    function upload_dir_url($path = ''){
    	if (empty($path) === false) {
    		return asset('upload').'/'.$path;
    	}
    	return asset('upload');
    	
    }
    
    function upload_dir_path($path = ''){
    	if (empty($path) === false) {
    		return public_path('upload').'/'.$path;
    	}
    	return public_path('upload');
    }

    function is_image($type){
        $type = strtolower($type);

        if($type == 'image/x-icon') {
            return false;
        }
       
        if($type == 'image/svg+xml') {
            return false;
        }

        if(substr($type, 0, 5) == 'image') {
            return true;
        }

        return false;
    }


    function format_status_tag(int $value, array $data = []){
        if ($value == 0) {
            $datavalue = 'Pending';
        }else if ($value == 1) {
            $datavalue = 'Publish';
        }else if ($value == 3) {
             $datavalue = 'Poned';
        }else {
             $datavalue = 'Trush';
        }
        if (is_array($data)) {
            foreach ($data as $key => $btnvalue) {
               if ($value == $btnvalue) {
                   return '<span class="label label-'.$key.'">'.ucfirst($datavalue).'</span>';
                   break;
               }
            }
        }
    }


// $obj ===== post type object 
// $chak ===== chack user roll
// $def ===== default user roll

    function chack_post_type_user_roll($obj, $chak, $def) {
        $user = Auth::User()->id;
        $cap = $obj->post_type_setting();
        $cap = (isset($cap['capability'])) ? $cap['capability'] : '' ;
        $see_post = (isset($cap[$chak])) ? $cap[$chak] : $def ;
        $permission = new App\UserPermission();
        return $permission->user_can($see_post, $user);
    }


    function get_option($type){
        $option_get = new App\options($type);
        $option = $option_get->option_exists();
        return (isset($option->options_value)) ? @unserialize($option->options_value) : false;
    }

    function get_menu_list_array(){
        $data = DB::table('menus')->get();
        $ret_data = [];
        if ($data->count() > 0) {
            foreach ($data as $key => $value) {
                $ret_data[$value->id] = $value->name;
            }
        }

        return $ret_data;
    }



