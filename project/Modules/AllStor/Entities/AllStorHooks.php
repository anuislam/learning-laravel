<?php

namespace Modules\AllStor\Entities;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use DB;
use App\UserPermission;
use Auth;
use Carbon;
use Module;
use Html;
use View;
use App\UserModel;
use App\BlogPost;
use Illuminate\Support\Str;

class AllStorHooks extends Model{
	private $permission = '';
	private $usermodel = '';
	private $post = '';

	public function __construct(){
		$this->permission   = new UserPermission();
		$this->usermodel    = new UserModel();
		$this->post    		= new BlogPost();
		add_action('site_header', [$this, 'AllStor_call_site_header_func']);
		add_action('site_footer', [$this, 'AllStor_call_site_footer_func']);
		add_action('not_found_page', [$this, 'AllStor_not_found_page_func']);
    }


    public function AllStor_not_found_page_func(){
    	echo View('allstor::404');
    }


    public function AllStor_call_site_footer_func(){
?>
  <?php echo Html::script(Module::asset('allstor:js').'/jquery-1.11.2.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/jquery.bxslider.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/fancybox/fancybox.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/fancybox/helpers/jquery.fancybox-thumbs.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/jquery.flexslider-min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/swiper.jquery.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/jquery.waypoints.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/progressbar.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/ion.rangeSlider.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/chosen.jquery.min.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/jQuery.Brazzers-Carousel.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/plugins.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/main.js', ['type' => 'text/javascript']); ?>
  <?php echo Html::script('//maps.googleapis.com/maps/api/js?key=AIzaSyDhAYvx0GmLyN5hlf6Uv_e9pPvUT3YpozE', ['type' => 'text/javascript']); ?>
  <?php echo Html::script(Module::asset('allstor:js').'/gmap.js', ['type' => 'text/javascript']); ?>
<?php

    }

    public function AllStor_call_site_header_func(){
		?>
		   <?php echo  Html::style('https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700ii%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic') ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/font-awesome.min.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/bootstrap.min.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/ion.rangeSlider.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/ion.rangeSlider.skinFlat.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/jquery.bxslider.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/jquery.fancybox.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/flexslider.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/swiper.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/style.css'); ?>
		  <?php echo  Html::style(Module::asset('allstor:css').'/media.css'); ?>
		<?php
    }


}
