<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use App\TarmModel;
use App\mediaModel;
use App\admin_page;
use App\post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use App\options;
use Shortcode;

class contact_us_page extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' 	 => 'Contact Page',
    		'page_sub_title' => 'Settings',
    		'capability' 	 => 'manage_option',
    	];
    }


	public function page_content_output($error_msg = ''){

		$option = get_option('contact_us_page');
		?>
		<?php echo Form::open(['url' =>  route('option-update', 'contact-page'), 'method' => 'PUT']); ?>

		    <div class="row">
		      <div class="col-md-8">
		      	<?php echo heml_card_open('fa fa-circle-o', 'Contact Us page Settings'); ?>

					<?php 
						textarea_editor([
							'name' => 'addr_content',
							'title' => 'Contact Address Content',
							'value' => (empty($option['addr_content']) === false) ? $option['addr_content'] : old('addr_content'),
							'atts' =>  [
								'style' 	  => 'min-height:500px;',
								]
						], $error_msg); 
					?> 

				<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-left', 'style' => 'margin-top:15px;']); ?>

				<?php echo heml_card_close(); ?>
			  </div>
			</div>
		<?php echo Form::close(); 	
	}

    public function option_validation($data){
    	return Validator::make($data, [
                'addr_content'        => 'nullable',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('contact_us_page');
        $option_save->add_option('addr_content', Purifier::clean($data['addr_content'], array(
          'AutoFormat.AutoParagraph' => false,
          'HTML.Nofollow' => true,
        )));      
        $option_save->option_update();
        
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }


}
