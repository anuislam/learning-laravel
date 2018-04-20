<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use DB;
use App\UserPermission;
use Auth;
use Carbon;
use App\UserModel;
use App\BlogPost;
use Html;
use Module;
use Illuminate\Support\Str;


class handel_hooks{
	private $permission = '';
	private $usermodel = '';
	private $post = '';
	private $comment = '';

	public function __construct(){
		$this->permission   = new UserPermission();
		$this->usermodel    = new UserModel();
		$this->post    		= new BlogPost();
		add_action( 'site_footer', [$this, 'as_admin_bar'] );
		add_action( 'site_footer', [$this, 'as_admin_load_script'], 99 );
		add_action( 'site_header', [$this, 'as_frontend_load_style'], 99 );	
    }


    public function as_frontend_load_style(){
    	if ($this->usermodel->is_login() === true) {
			echo Html::style(asset('admin/css/frontend.css'));
    	}
    }
    
    public function as_admin_bar(){
    	if ($this->usermodel->is_login() === true) {
	    	$user = $this->usermodel->current_user();    		
	    	?>
			<div class="ascms_main_header">
				<div class="ascms_logo">
					<a href="<?php echo route('dashboard'); ?>" class="ascms-logo">
					  <!-- logo for regular state and mobile devices -->
					  <span class="ascms-logo-lg"><b>AS</b>cms</span>
					</a>
				</div>
				<div class="ascmsmenu">
					<ul>
						<li class="ascms_user_menu">
							<a href="javascript:void(0)" onclick='as_cms_post("<?php echo route('logout'); ?>", {"_token":"<?php echo csrf_token(); ?>"})' >								
								<span>Log Out</span>
							</a>
						</li>
						<li class="ascms_user_menu">
							<a href="<?php echo route('user.index'); ?>">
								<?php echo Html::image(get_gravatar_custom_img($user['email'], 25), $user['fname'].$user['lname'] ); ?>  
								<span><?php echo $user['fname'].' '.$user['lname']; ?></span>
							</a>
						</li>
						<?php do_action('frontend_admin_bar', $user); ?>
					</ul>
				</div>
			</div>

	    	<?php
	    }
    }

    public function as_admin_load_script(){
    	if ($this->usermodel->is_login() === true) {
			echo Html::script(asset('admin/js/frontend.js'));
    	}
    }

}
