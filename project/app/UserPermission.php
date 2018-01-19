<?php

namespace App;

use Modules\Permission\Entities\AddPermission;

if ( trait_exists( 'Modules\Permission\Entities\AddPermission' ) ) {    
	class UserPermission{
		use AddPermission;
	}
}




