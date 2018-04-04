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

class header_setting extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' 	 => 'Header',
    		'page_sub_title' => 'Settings',
    		'capability' 	 => 'manage_option',
    	];
    }


	public function page_content_output($error_msg = ''){

		$option = get_option('header_settings');
		?>
		<?php echo Form::open(['url' =>  route('option-update', 'gym-header-setting'), 'method' => 'PUT']); ?>

		    <div class="row">
		      <div class="col-md-8">
		      	<?php echo heml_card_open('fa fa-circle-o', 'Header Settings'); ?>

					<?php echo  media_uploader([
						'name' => 'header_logo',
						'title' => 'Upload header logo',
						'value' => (empty($option['header_logo']) === false) ? $option['header_logo'] : old('header_logo'),
						'atts' =>  [
						'class'      => 'btn bg-purple btn-flat media_uploader_active'
						]
						], $error_msg); ?>

					<?php echo  media_uploader([
						'name' => 'header_slider',
						'title' => 'Upload header slider',
						'value' => (empty($option['header_slider']) === false) ? $option['header_slider'] : old('header_slider'),
						'atts' =>  [
						'class'      => 'btn bg-purple btn-flat media_uploader_active'
						]
						], $error_msg); ?>

					<?php echo select_field([
	                    'name' => 'menu_id',
	                    'title' => 'Menu Id',
	                    'value' => (empty($option['menu_id']) === false) ? $option['menu_id'] : old('menu_id'),
	                    'items' => get_menu_list_array(),
	                    'atts' =>  [
	                      'placeholder' => 'Select Menu Id',
	                      'class' => 'form-control post_type_chack_slug',
	                    ]
	                  ], $error_msg); ?>

					<?php 
						textarea_editor([
							'name' => 'slider_content',
							'title' => 'Slider Content',
							'value' => (empty($option['slider_content']) === false) ? $option['slider_content'] : old('slider_content'),
							'atts' =>  [
							'style' => 'min-height:200px;'
						]
						], $error_msg); 
					?> 

					<?php 
						text_field([
							'name' => 'slider_tagline',
							'title' => 'Slider Tagline',
							'value' => (empty($option['slider_tagline']) === false) ? $option['slider_tagline'] : old('slider_tagline'),
							'atts' =>  [
								'placeholder' => 'Slider Tagline',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); 
					?> 

					<?php 
						text_field([
							'name' => 'slider_button',
							'title' => 'Button Text',
							'value' => (empty($option['slider_button']) === false) ? $option['slider_button'] : old('slider_button'),
							'atts' =>  [
								'placeholder' => 'Button Text',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); 
					?> 

					<?php 
						text_field([
							'name' => 'slider_btn_url',
							'title' => 'Slider Button Url',
							'value' => (empty($option['slider_btn_url']) === false) ? $option['slider_btn_url'] : old('slider_btn_url'),
							'atts' =>  [
								'placeholder' => 'Slider Button Url',
	                      		'class' => 'form-control post_type_chack_slug',
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
                'header_logo'        => 'nullable',
                'header_slider'        => 'nullable',
                'slider_content'     => 'nullable',
                'menu_id'        	 => 'integer',
                'slider_button'      => 'string',
                'slider_btn_url'     => 'url',
                'slider_tagline'     => 'string',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('header_settings');
        $option_save->add_option('header_logo', (int)$data['header_logo']);
        $option_save->add_option('header_slider', (int)$data['header_slider']);
        $option_save->add_option('menu_id', (int)$data['menu_id']);
        $option_save->add_option('slider_content', Purifier::clean($data['slider_content']));
        $option_save->add_option('slider_tagline', Purifier::clean($data['slider_tagline']));
        $option_save->add_option('slider_button', sanitize_text($data['slider_button']));      
        $option_save->add_option('slider_btn_url', sanitize_url($data['slider_btn_url']));     
        $option_save->option_update();
        
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }


}
