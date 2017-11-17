<?php 
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
                return (preg_match('/^[a-zA-Z0-9]{0,250}$/', $value)) ? true : false ;
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
    		return asset('public/upload').'/'.$path;
    	}
    	return asset('public/upload');
    	
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
        
        if(substr($type, 0, 5) == 'image') {
            return true;
        }
        return false;
    }