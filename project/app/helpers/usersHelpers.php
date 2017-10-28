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


?>