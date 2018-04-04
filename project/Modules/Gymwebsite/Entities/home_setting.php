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

class home_setting extends admin_page{

	public function page_setting(){
    	return [
    		'page_title' => 'Home',
    		'page_sub_title' => 'Settings',
    		'capability' => 'manage_option',
    	];
    }
	public function page_content_output($error_msg = ''){
		$option = get_option('home_settings');
		?>
		<?php echo Form::open(['url' =>  route('option-update', 'gym-home-setting'), 'method' => 'PUT']); ?>

		    <div class="row">
		      <div class="col-md-8">
		      	<?php echo heml_card_open('fa fa-circle-o', 'Home Settings'); ?>

				<?php 	text_field([
							'name' => 'class_sec_titile',
							'title' => 'Class Section Title',
							'value' => (empty($option['class_sec_titile']) === false) ? $option['class_sec_titile'] : old('class_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Class Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'class_sec_desc',
							'title' => 'Class Section Description',
							'value' => (empty($option['class_sec_desc']) === false) ? $option['class_sec_desc'] : old('class_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Class Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?> 

				<?php 	text_field([
							'name' => 'commit_sec_titile',
							'title' => 'Commit  Section Title',
							'value' => (empty($option['commit_sec_titile']) === false) ? $option['commit_sec_titile'] : old('commit_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Commit  Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'commit_sec_desc',
							'title' => 'Commit Section Description',
							'value' => (empty($option['commit_sec_desc']) === false) ? $option['commit_sec_desc'] : old('commit_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Commit  Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?> 

					<?php echo  media_uploader([
						'name' => 'commit_sec_bg_image',
						'title' => 'Commit Section BG Image',
						'value' => (empty($option['commit_sec_bg_image']) === false) ? $option['commit_sec_bg_image'] : old('commit_sec_bg_image'),
						'atts' =>  [
						'class'      => 'btn bg-purple btn-flat media_uploader_active'
						]
						], $error_msg); ?>



				<?php 	text_field([
							'name' => 'program_sec_titile',
							'title' => 'Program  Section Title',
							'value' => (empty($option['program_sec_titile']) === false) ? $option['program_sec_titile'] : old('program_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Program  Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'program_sec_desc',
							'title' => 'Program Section Description',
							'value' => (empty($option['program_sec_desc']) === false) ? $option['program_sec_desc'] : old('program_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Program  Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?>



				<?php 	text_field([
							'name' => 'trainer_sec_titile',
							'title' => 'Trainer  Section Title',
							'value' => (empty($option['trainer_sec_titile']) === false) ? $option['trainer_sec_titile'] : old('trainer_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Trainer  Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'trainer_sec_desc',
							'title' => 'Trainer Section Description',
							'value' => (empty($option['trainer_sec_desc']) === false) ? $option['trainer_sec_desc'] : old('trainer_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Trainer  Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?>


				<?php 	text_field([
							'name' => 'fitness_sec_titile',
							'title' => 'Fitness  Section Title',
							'value' => (empty($option['fitness_sec_titile']) === false) ? $option['fitness_sec_titile'] : old('fitness_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Fitness  Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'fitness_sec_desc',
							'title' => 'Fitness Section Description',
							'value' => (empty($option['fitness_sec_desc']) === false) ? $option['fitness_sec_desc'] : old('fitness_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Fitness  Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?>


				<?php 	text_field([
							'name' => 'fitness_sec_btn_text',
							'title' => 'Fitness  Section Button Text',
							'value' => (empty($option['fitness_sec_btn_text']) === false) ? $option['fitness_sec_btn_text'] : old('fitness_sec_btn_text'),
							'atts' =>  [
								'placeholder' => 'Fitness  Section Button Text',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	url_field([
							'name' => 'fitness_sec_btn_url',
							'title' => 'Fitness  Section Button url',
							'value' => (empty($option['fitness_sec_btn_url']) === false) ? $option['fitness_sec_btn_url'] : old('fitness_sec_btn_url'),
							'atts' =>  [
								'placeholder' => 'Fitness  Section Button url',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

					<?php echo  media_uploader([
						'name' => 'fitness_sec_bg_image',
						'title' => 'Fitness Section BG Image',
						'value' => (empty($option['fitness_sec_bg_image']) === false) ? $option['fitness_sec_bg_image'] : old('fitness_sec_bg_image'),
						'atts' =>  [
						'class'      => 'btn bg-purple btn-flat media_uploader_active'
						]
						], $error_msg); ?>

				<?php 	text_field([
							'name' => 'pricing_sec_titile',
							'title' => 'Pricing Section Title',
							'value' => (empty($option['pricing_sec_titile']) === false) ? $option['pricing_sec_titile'] : old('pricing_sec_titile'),
							'atts' =>  [
								'placeholder' => 'Pricing  Section Title',
	                      		'class' => 'form-control post_type_chack_slug',
								]
						], $error_msg); ?> 

				<?php 	textarea_field([
							'name' => 'pricing_sec_desc',
							'title' => 'Pricing Section Description',
							'value' => (empty($option['pricing_sec_desc']) === false) ? $option['pricing_sec_desc'] : old('pricing_sec_desc'),
							'atts' =>  [
								'placeholder' => 'Pricing  Section Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?>

				<?php 	textarea_field([
							'name' => 'pricing_sec_table',
							'title' => 'Price Tables',
							'value' => (empty($option['pricing_sec_table']) === false) ? $option['pricing_sec_table'] : old('pricing_sec_table'),
							'atts' =>  [
								'placeholder' => 'Pricing Tables',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?>


				<?php 	text_field([
							'name' => 'blog_sec_title',
							'title' => 'Blog Section Title',
							'value' => (empty($option['blog_sec_title']) === false) ? $option['blog_sec_title'] : old('blog_sec_title'),
							'atts' =>  [
								'placeholder' => 'Blog Section Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?> 


				<?php 	text_field([
							'name' => 'event_sec_title',
							'title' => 'Event Section Title',
							'value' => (empty($option['event_sec_title']) === false) ? $option['event_sec_title'] : old('event_sec_title'),
							'atts' =>  [
								'placeholder' => 'Blog Section Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?> 


				<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-left']); ?>
				<?php echo heml_card_close(); ?>
			  </div>
			</div>

		<?php echo Form::close(); 

	}
    public function option_validation($data){
    	return Validator::make($data, [
                'class_sec_titile'     => 'nullable|string|max:2500',
                'class_sec_desc'       => 'nullable|string|max:4000',
                'commit_sec_titile'     => 'nullable|string|max:2500',
                'commit_sec_desc'       => 'nullable|string|max:4000',
                'program_sec_titile'     => 'nullable|string|max:2500',
                'program_sec_desc'       => 'nullable|string|max:4000',
                'trainer_sec_titile'     => 'nullable|string|max:2500',
                'trainer_sec_desc'       => 'nullable|string|max:4000',
                'pricing_sec_titile'     => 'nullable|string|max:2500',
                'pricing_sec_desc'       => 'nullable|string|max:4000',
                'fitness_sec_titile'     => 'nullable|string|max:2500',
                'fitness_sec_desc'       => 'nullable|string|max:4000',
                'fitness_sec_btn_text'  => 'nullable|string|max:2500',
                'fitness_sec_btn_url'   => 'nullable|url',
                'commit_sec_bg_image'   => 'nullable',
                'fitness_sec_bg_image'  => 'nullable',
                'pricing_sec_table'   	=> 'nullable|string',
                'blog_sec_title'   		=> 'nullable|string|max:2500',
                'event_sec_title'   	=> 'nullable|string|max:2500',
            ]
        );
    }

    public function option_update($data){
        $option_save = new options('home_settings');

        $option_save->add_option('class_sec_titile', sanitize_text($data['class_sec_titile']));
        $option_save->add_option('class_sec_desc', sanitize_text($data['class_sec_desc']));     
        $option_save->add_option('commit_sec_titile', sanitize_text($data['commit_sec_titile']));
        $option_save->add_option('commit_sec_desc', sanitize_text($data['commit_sec_desc']));
        $option_save->add_option('program_sec_titile', sanitize_text($data['program_sec_titile']));
        $option_save->add_option('program_sec_desc', sanitize_text($data['program_sec_desc']));     
        $option_save->add_option('trainer_sec_titile', sanitize_text($data['trainer_sec_titile']));
        $option_save->add_option('trainer_sec_desc', sanitize_text($data['trainer_sec_desc']));     
        $option_save->add_option('pricing_sec_titile', sanitize_text($data['pricing_sec_titile']));
        $option_save->add_option('pricing_sec_desc', sanitize_text($data['pricing_sec_desc']));      
        $option_save->add_option('pricing_sec_table', sanitize_text($data['pricing_sec_table']));   
        $option_save->add_option('fitness_sec_titile', sanitize_text($data['fitness_sec_titile']));
        $option_save->add_option('fitness_sec_desc', sanitize_text($data['fitness_sec_desc']));     
        $option_save->add_option('fitness_sec_btn_text', sanitize_text($data['fitness_sec_btn_text']));
        $option_save->add_option('fitness_sec_btn_url', sanitize_url($data['fitness_sec_btn_url']));      
        $option_save->add_option('fitness_sec_bg_image', (int)$data['fitness_sec_bg_image']);     
        $option_save->add_option('commit_sec_bg_image', (int)$data['commit_sec_bg_image']);     
        $option_save->add_option('blog_sec_title', sanitize_text($data['blog_sec_title']));     
        $option_save->add_option('event_sec_title', sanitize_text($data['event_sec_title']));     
        $option_save->option_update();
        
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }
}
