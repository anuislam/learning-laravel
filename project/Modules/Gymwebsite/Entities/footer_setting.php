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

class footer_setting extends admin_page{

    public function page_setting(){
    	return [
    		'page_title' 	 => 'Footer',
    		'page_sub_title' => 'Settings',
    		'capability' 	 => 'manage_option',
    	];
    }


	public function page_content_output($error_msg = ''){

		$option = get_option('footer_settings');
		?>
		<?php echo Form::open(['url' =>  route('option-update', 'gym-footer-setting'), 'method' => 'PUT']); ?>

		    <div class="row">
		      <div class="col-md-8">
		      	<?php echo heml_card_open('fa fa-circle-o', 'Footer Settings'); ?>

					<?php 
						text_field([
							'name' => 'aboute_us',
							'title' => 'About Us Title',
							'value' => (empty($option['aboute_us']) === false) ? $option['aboute_us'] : old('aboute_us'),
							'atts' =>  [
								'placeholder' => 'About Us Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?> 

				<?php 	textarea_field([
							'name' => 'aboute_us_desc',
							'title' => 'About US Description',
							'value' => (empty($option['aboute_us_desc']) === false) ? $option['aboute_us_desc'] : old('aboute_us_desc'),
							'atts' =>  [
								'placeholder' => 'About US Description',
	                      		'class' => 'form-control',
								]
						], $error_msg); ?> 


					<?php 
						text_field([
							'name' => 'footer_addr_title',
							'title' => 'Footer Address Title',
							'value' => (empty($option['footer_addr_title']) === false) ? $option['footer_addr_title'] : old('footer_addr_title'),
							'atts' =>  [
								'placeholder' => 'Footer Address Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?>

				<?php 
					$footer_addr_data = (old('footer_addr')) ? old('footer_addr') : @unserialize($option['footer_addr']) ;
				 ?>

						<div class="footer_addr_main_section" >
							<h4>Footer Address</h4>
							<?php 
								if ($footer_addr_data) {
									foreach ($footer_addr_data as $footerkey => $footervalue) {
?>
						<div class="form-group <?php if($error_msg->has('footer_addr.'.$footerkey.'.icon')){
							echo 'has-error';
						}else if($error_msg->has('footer_addr.'.$footerkey.'.addr')){
							echo 'has-error';
						} ?>">
							<div item-count="<?php echo $footerkey; ?>" class="row footer_addr_items" style="margin-top:15px;">
								<div class="col-md-4">
									<?php echo Form::label( 'footer_addr['.$footerkey.'][icon]', 'Footer address icon', ['class' => 'control-label'] ); ?>
									<?php echo Form::text('footer_addr['.$footerkey.'][icon]', $footervalue['icon'], [
									'class' 		=> 'form-control',
									'placeholder' 	=> 'About Us Title',
									] ); ?>   
								    <?php if ($error_msg->has('footer_addr.'.$footerkey.'.icon')) : ?>
								      <span class="help-block">
								          <strong><?php echo $error_msg->first('footer_addr.'.$footerkey.'.icon');  ?></strong>
								      </span>
								    <?php endif; ?>
								</div>  
								<div class="col-md-8">
									<?php echo Form::label( 'footer_addr['.$footerkey.'][addr]', 'Footer address', ['class' => 'control-label'] ); ?>
									<a onclick="remove_footer_addr_field(this)" href="javascript:void(0)" class="label label-danger  pull-right">Remove</a>
									<?php echo Form::text('footer_addr['.$footerkey.'][addr]',$footervalue['addr'], [
									'class' 		=> 'form-control',
									'placeholder' 	=> 'Footer address',
									] ); ?>     
								    <?php if ($error_msg->has('footer_addr.'.$footerkey.'.addr')) : ?>
								      <span class="help-block">
								          <strong><?php echo $error_msg->first('footer_addr.'.$footerkey.'.addr');  ?></strong>
								      </span>
								    <?php endif; ?>	
								</div>  
							</div>
						</div>

<?php
									}
								}
							?>

							<div class="row" id="footer_addr_insert_before">
								<div class="col-md-12">
									<a onclick="add_new_footer_addr_field(this)" href="javascript:void(0)" class="btn bg-olive btn-flat pull-right" style="margin-top: 20px;">Add New</a>
								</div>
							</div>
						</div>

					<?php 
						text_field([
							'name' => 'footer_contact_title',
							'title' => 'Footer Contact Us Title',
							'value' => (empty($option['footer_contact_title']) === false) ? $option['footer_contact_title'] : old('footer_contact_title'),
							'atts' =>  [
								'placeholder' => 'Footer Contact Us Title',
	                      		'class' => 'form-control',
								]
						], $error_msg); 
					?>

				<?php 
					$footer_social = (old('social_link')) ?  old('social_link') : @unserialize($option['social_link']) ;
				 ?>

						<div class="footer_addr_main_section" >
							<h4>Social Links</h4>
							<?php 
								if ($footer_social) {
									foreach ($footer_social as $socialkey => $socialvalue) {
?>
						<div class="form-group <?php if($error_msg->has('social_link.'.$socialkey.'.icon')){
							echo 'has-error';
						}else if($error_msg->has('social_link.'.$socialkey.'.url')){
							echo 'has-error';
						} ?>">
							<div item-count="<?php echo $socialkey; ?>" class="row footer_addr_items" style="margin-top:15px;">
								<div class="col-md-4">
									<?php echo Form::label( 'social_link['.$socialkey.'][icon]', 'Social Icon', ['class' => 'control-label'] ); ?>
									<?php echo Form::text('social_link['.$socialkey.'][icon]', $socialvalue['icon'], [
									'class' 		=> 'form-control',
									'placeholder' 	=> 'Social Icon',
									] ); ?>   
								    <?php if ($error_msg->has('social_link.'.$socialkey.'.icon')) : ?>
								      <span class="help-block">
								          <strong><?php echo $error_msg->first('social_link.'.$socialkey.'.icon');  ?></strong>
								      </span>
								    <?php endif; ?>
								</div>  
								<div class="col-md-8">
									<?php echo Form::label( 'social_link['.$socialkey.'][url]', 'Social Url', ['class' => 'control-label'] ); ?>
									<a onclick="remove_footer_addr_field(this)" href="javascript:void(0)" class="label label-danger  pull-right">Remove</a>
									<?php echo Form::text('social_link['.$socialkey.'][url]',$socialvalue['url'], [
									'class' 		=> 'form-control',
									'placeholder' 	=> 'Social Url',
									] ); ?>     
								    <?php if ($error_msg->has('social_link.'.$socialkey.'.url')) : ?>
								      <span class="help-block">
								          <strong><?php echo $error_msg->first('social_link.'.$socialkey.'.url');  ?></strong>
								      </span>
								    <?php endif; ?>	
								</div>  
							</div>
						</div>

<?php
									}
								}
							?>

							<div class="row" id="footer_social_links_insert_before">
								<div class="col-md-12">
									<a onclick="add_new_footer_social_links(this)" href="javascript:void(0)" class="btn bg-olive btn-flat pull-right" style="margin-top: 20px;">Add New</a>
								</div>
							</div>
						</div>


				<?php 	textarea_field([
							'name' => 'footer_text',
							'title' => 'Footer Text',
							'value' => (empty($option['footer_text']) === false) ? $option['footer_text'] : old('footer_text'),
							'atts' =>  [
								'placeholder' => 'Footer Text',
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
                'aboute_us'        	     => 'nullable|string|max:255',
                'aboute_us_desc'         => 'nullable|string|max:2000',
                'footer_text'         => 'nullable|string|max:2000',
                'footer_addr_title'      => 'nullable|string|max:255',
                'footer_contact_title'   => 'nullable|string|max:255',
                'footer_addr.*.icon'     => 'nullable|string|max:55',
                'footer_addr.*.addr'     => 'nullable|string|max:255',
                'social_link.*.icon'     => 'nullable|string|max:100|',
                'social_link.*.url'      => 'nullable|url',
            ]
        );
    }

    public function option_update($data){
    	$savedata = [];
    	$social_data = [];
    	if (empty($data['footer_addr']) === false) {
    		foreach ($data['footer_addr'] as $footerkey => $footervalue) {
    			$savedata[] = [
    				'icon' => sanitize_text($footervalue['icon']),
    				'addr' => sanitize_text($footervalue['addr']),
    			];
    		}
    	}
    	if (empty($data['social_link']) === false) {
    		foreach ($data['social_link'] as $socialkey => $socialvalue) {
    			$social_data[] = [
    				'icon' => sanitize_text($socialvalue['icon']),
    				'url' => sanitize_url($socialvalue['url']),
    			];
    		}
    	}
        $option_save = new options('footer_settings');
        $option_save->add_option('aboute_us', sanitize_text($data['aboute_us']));      
        $option_save->add_option('footer_addr_title', sanitize_text($data['footer_addr_title']));      
        $option_save->add_option('footer_contact_title', sanitize_text($data['footer_contact_title']));      
        $option_save->add_option('aboute_us_desc', sanitize_text($data['aboute_us_desc']));      
        $option_save->add_option('footer_text', sanitize_text($data['footer_text']));      
        $option_save->add_option('footer_addr', serialize($savedata));
        $option_save->add_option('social_link', serialize($social_data));
        $option_save->option_update();
        
        return redirect()->back()->with('success_msg', 'Optuons Update Successful.');
    }


}
