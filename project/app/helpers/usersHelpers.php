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
                return (is_numeric($value) === true) ? true : false ;
                break;   
            case 'string':
                return (is_string($value) === true) ? true : false ;
                break;            
            default:
                return true;
                break;
	        
	        }		
	    }
	    return false;

    }


?>