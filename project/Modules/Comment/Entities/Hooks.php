<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Form;
use Validator;
use Auth;
use DB;
use Session;
use Modules\Comment\Entities\CommentModel;
use App\BlogPost;

class Hooks extends Model{

	private $comment; 

    public function __construct() {

    	$this->comment = new CommentModel();
    	$this->postmodel = new BlogPost();

    	add_action('header_notification', [$this, 'comment_header_notification']);
    }

    public function comment_header_notification(){
    	$pennding = $this->comment->get_pending_all_comments();
		?>

          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-comments"></i>
				<?php
	    		if (count($pennding)) {
              		echo '<span class="label label-danger">'.count($pennding).'</span>';
	    		}?>
            </a>
        <?php
    	if (count($pennding) > 0) {
    		?>
    		<ul class="dropdown-menu">
    			<li class="header">You have <?php echo count($pennding); ?> pending <?php
		    		if (count($pennding) > 1) {
		    			echo 'Comments';
		    		}else{
		    			echo 'Comment';
		    		} ?>
    			</li>
    			<li>
		    		<ul class="menu">
		    		<?php
		    			foreach ($pennding as $pkey => $pvalue) {
							?>
							<li>
								<a href="<?php echo $this->postmodel->get_permalink($pvalue->post_id, 'single_post'); ?>" target="_blank">
									<div class="pull-left">
										<?php echo get_gravatar_custom_img( $pvalue->email, 50, 'mm', 'g', true, [
												'class' => 'img-circle',
												'alt' => '$pvalue->name',
											] ); ?>
									</div>
								<h4>
									<?php echo $pvalue->name ?>
									<small><i class="fa fa-clock-o"></i> <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($pvalue->created_at))->diffForHumans() ?></small>
								</h4>
									<p><?php echo read_more(5,  sanitize_text($pvalue->message)); ?></p>
								</a>
							</li>
							<?php
		    			}
		    			?>
		    		</ul>
	    		</li>
	    		<li class="footer"><a href="<?php echo route('admin-page', 'comments'); ?>">See All Comments</a></li>
    		</ul>
    		<?php
    	}
    	?>
		</li>
    	<?php
    }

}
