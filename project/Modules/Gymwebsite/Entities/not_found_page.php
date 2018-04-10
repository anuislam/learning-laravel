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

class not_found_page extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' 	 => '404 Page',
    		'page_sub_title' => 'Settings',
    		'capability' 	 => 'manage_option',
    	];
    }


	public function page_content_output($error_msg = ''){

		$option = get_option('not_found_page');
		?>
		<?php echo Form::open(['url' =>  route('option-update', '404-page'), 'method' => 'PUT']); ?>

		    <div class="row">
		      <div class="col-md-8">
		      	<?php echo heml_card_open('fa fa-circle-o', 'Header Settings'); ?>

					<?php echo  media_uploader([
						'name' => 'page_bg_image',
						'title' => 'Upload Bg Image',
						'value' => (empty($option['page_bg_image']) === false) ? $option['page_bg_image'] : old('page_bg_image'),
						'atts' =>  [
						'class'      => 'btn bg-purple btn-flat media_uploader_active'
						]
						], $error_msg); ?>


					<?php 
						text_field([
							'name' => 'page_title',
							'title' => '404 Page Title',
							'value' => (empty($option['page_title']) === false) ? $option['page_title'] : old('page_title'),
							'atts' =>  [
								'placeholder' => '404 Page Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 


					<?php 
						text_field([
							'name' => 'page_short_desc',
							'title' => '404 Page Short Description',
							'value' => (empty($option['page_short_desc']) === false) ? $option['page_short_desc'] : old('page_short_desc'),
							'atts' =>  [
								'placeholder' => '404 Page Short Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 

					<?php 
						text_field([
							'name' => 'page_sec_title',
							'title' => '404 Page Section Title',
							'value' => (empty($option['page_sec_title']) === false) ? $option['page_sec_title'] : old('page_sec_title'),
							'atts' =>  [
								'placeholder' => '404 Page Section Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 

					<?php 
						text_field([
							'name' => 'page_sec_desc',
							'title' => '404 Page Section Description',
							'value' => (empty($option['page_sec_desc']) === false) ? $option['page_sec_desc'] : old('page_sec_desc'),
							'atts' =>  [
								'placeholder' => '404 Page Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 

					<?php 
						textarea_field([
							'name' => 'page_sec_content',
							'title' => '404 Page Content',
							'value' => (empty($option['page_sec_content']) === false) ? $option['page_sec_content'] : old('page_sec_content'),
							'atts' =>  [
								'placeholder' => '404 Page Content',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 
					<?php 
						text_field([
							'name' => 'page_button_title',
							'title' => '404 Buttot text',
							'value' => (empty($option['page_button_title']) === false) ? $option['page_button_title'] : old('page_button_title'),
							'atts' =>  [
								'placeholder' => '404 Buttot text',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 


				<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-left']); ?>

				<?php echo heml_card_close(); ?>
			  </div>
			</div>
		<?php echo Form::close(); 	
	}

    public function option_validation($data){
    	return Validator::make($data, [
                'page_bg_image'        => 'nullable|integer',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('not_found_page');
        $option_save->add_option('page_bg_image', (int)$data['page_bg_image']);   
        $option_save->add_option('page_title', sanitize_text($data['page_title']));   
        $option_save->add_option('page_short_desc', sanitize_text($data['page_short_desc']));   
        $option_save->add_option('page_sec_title', sanitize_text($data['page_sec_title']));    
        $option_save->add_option('page_sec_desc', sanitize_text($data['page_sec_desc']));    
        $option_save->add_option('page_sec_content', sanitize_text($data['page_sec_content']));    
        $option_save->add_option('page_button_title', sanitize_text($data['page_button_title']));    
        $option_save->option_update();
        
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }


}
