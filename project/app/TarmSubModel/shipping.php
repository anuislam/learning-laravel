<?php

namespace App\TarmSubModel;

use App\TarmModel;
use App\mediaModel;
use App\post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;

class shipping extends TarmModel
{

	public function pate_tab_title(){
    	return 'shipping method';
    }
    public function pate_title(){
    	return 'Add shipping method';
    }
    public function page_icon(){
    	return 'fa fa-pencil';
    }

    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-tarms', 'shipping'), 'method' => 'POST']); 
			text_field([
				'name' => 'cat_name',
				'title' => 'Shipping Name',
				'value' => old('cat_name'),
				'atts' =>  ['placeholder' => 'Shipping Name', 'aria-describedby' => 'ShippingName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Shipping Slug',
				'value' => old('cat_slug'),
				'atts' =>  ['placeholder' => 'Shipping Slug', 'aria-describedby' => 'ShippingSlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Shipping Description',
				'value' => old('cat_description'),
				'atts' =>  ['placeholder' => 'Shipping Description', 'aria-describedby' => 'ShippingDescription', 'class' => 'form-control']
			], $errors);

			media_uploader([
				'name' => 'shiping_image',
				'title' => 'Upload Image',
				'value' => old('shiping_image'),
				'atts' =>  [
					'class' 		 => 'btn bg-purple btn-flat', 
					'cancel_text' 	 => 'Cancel shiping image',
					'submit_text' 	 => 'Select shiping image',
					 ]
			], $errors);

			media_uploader([
				'name' => 'shiping_image_two',
				'title' => 'Upload Image',
				'value' => old('shiping_image_two'),
				'atts' =>  [
					'class' 		 => 'btn bg-purple btn-flat', 
					'cancel_text' 	 => 'Cancel shiping image',
					'submit_text' 	 => 'Select shiping image',
					 ]
			], $errors);


			echo 	Form::submit('Add Shipping', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }


    public function tarm_validation($data){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,null,null,tarm-type,shipping',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,null,null,tarm-type,shipping',
                'cat_description'      => 'nullable',
                'shiping_image'      => 'nullable|integer',
                'shiping_image_two'      => 'nullable|integer',
            ], [
			    'cat_name.regex' 	=> 'The Shipping name format is invalid.',
			    'cat_name.required' => 'The Shipping name field is required.',
			    'cat_name.max' 		=> 'The Shipping name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The Shipping name has already been taken.',
			    'cat_name.string' 	=> 'The Shipping name must be given string.',

			    'cat_slug.regex' 	=> 'The Shipping slug format is invalid.',
			    'cat_slug.required' => 'The Shipping slug field is required.',
			    'cat_slug.max' 		=> 'The Shipping slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The Shipping slug has already been taken.',
			    'cat_slug.string' 	=> 'The Shipping slug must be given string.',
			]);
    }


    public function tarm_data_save($data, $tarm_type){
    	$data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
    	$id = DB::table('tarms')->insertGetId([
    		'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
    		'tarm-name' => sanitize_text($data['cat_name']),
    		'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
    		'tarm-type' => sanitize_text($tarm_type),
    		'created_at' => new \DateTime(),
    		'updated_at' => new \DateTime(),
    	]);
    	if ($id) {    
    		$this->update_tarm_meta($id, 'shiping_image', (int)$data['shiping_image']);		
    		$this->update_tarm_meta($id, 'shiping_image_two', (int)$data['shiping_image_two']);		
    		return redirect()->back()->with('success_msg', 'Shipping create successful.');
    	}
    	return redirect()->back()->with('error_msg', 'Operation failed.');
    }


    public function all_tarms_out_put(){
    	
		?>
	      <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url="<?php echo route('tarms-all', 'shipping'); ?>" tarms-data='<?php echo json_encode([
    		['data' => 'tarm-name'],
    		['data' => 'tarm-slug'],
    		[
    			'data' 		 => 'action',
    			'searchable' => 'false',
    			'orderable'  => 'false',
    		]
    	]);?>'>
	        <thead>
	          <tr>
	            <th>Shipping name</th>
	            <th>Shipping Slug</th>
	            <th>Actions</th>
	          </tr>
	        </thead>
	        <tfoot>
	          <tr>
	            <th>Shipping name</th>
	            <th>Shipping Slug</th>
	            <th>Actions</th>
	          </tr>
	        </tfoot>
	      </table>
		<?php
    }

    public function tarm_edit_form_output($value = '', $errors)
    {
    	$value = json_decode(json_encode($value),true);
		echo Form::open(['url' => route('edit-tarm-update', $value['id']).'/shipping', 'method' => 'POST']);
		 echo Form::hidden('_method', 'PATCH');
			text_field([
				'name' => 'cat_name',
				'title' => 'Shipping Name',
				'value' => $value['tarm-name'],
				'atts' =>  ['placeholder' => 'Category Name', 'aria-describedby' => 'CategoryName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Shipping Slug',
				'value' => $value['tarm-slug'],
				'atts' =>  ['placeholder' => 'Category Slug', 'aria-describedby' => 'CategorySlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Shipping Description',
				'value' => $value['description'],
				'atts' =>  ['placeholder' => 'Shipping Description', 'aria-describedby' => 'ShippingDescription', 'class' => 'form-control']
			], $errors);

			media_uploader([
				'name' => 'shiping_image',
				'title' => 'Upload Image',
				'value' => $this->get_tarm_meta($value['id'], 'shiping_image'),
				'atts' =>  [
					'class' 		 => 'btn bg-purple btn-flat', 
					'cancel_text' 	 => 'Cancel shiping image',
					'submit_text' 	 => 'Select shiping image',
					 ]
			], $errors);

			media_uploader([
				'name' => 'shiping_image_two',
				'title' => 'Upload Image',
				'value' => $this->get_tarm_meta($value['id'], 'shiping_image_two'),
				'atts' =>  [
					'class' 		 => 'btn bg-purple btn-flat', 
					'cancel_text' 	 => 'Cancel shiping image',
					'submit_text' 	 => 'Select shiping image',
					 ]
			], $errors);

			echo 	Form::submit('Update Shipping', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id.',id,tarm-type,shipping',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id.',id,tarm-type,shipping',
                'cat_description'      => 'nullable',                
                'shiping_image'      	=> 'nullable|integer',
                'shiping_image_two'      => 'nullable|integer'
            ], [
			    'cat_name.regex' 	=> 'The Shipping name format is invalid.',
			    'cat_name.required' => 'The Shipping name field is required.',
			    'cat_name.max' 		=> 'The Shipping name may not be greater than 1 characters.'.serialize($data),
			    'cat_name.unique' 	=> 'The Shipping name has already been taken.',
			    'cat_name.string' 	=> 'The Shipping name must be given string.',

			    'cat_slug.regex' 	=> 'The Shipping slug format is invalid.',
			    'cat_slug.required' => 'The Shipping slug field is required.',
			    'cat_slug.max' 		=> 'The Shipping slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The Shipping slug has already been taken.',
			    'cat_slug.string' 	=> 'The Shipping slug must be given string.',
			]);
    }


    public function tarm_edit_data_update($data, $tarm_id){
    	$data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
    	$update_data = DB::table('tarms')
                    ->where('id',  $tarm_id)
                    ->update([
			    		'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
			    		'tarm-name' => sanitize_text($data['cat_name']),
			    		'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
			    		'updated_at' => new \DateTime(),
                    ]);
		if ($update_data) {
			$this->update_tarm_meta($tarm_id, 'shiping_image', (int)$data['shiping_image']);		
			$this->update_tarm_meta($tarm_id, 'shiping_image_two', (int)$data['shiping_image_two']);
		}	

    	return redirect()->back()->with('success_msg', 'Update successful.');
    }



}
