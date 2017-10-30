<?php

namespace App\TarmSubModel;

use App\TarmModel;
use Form;
use Auth;
use Validator;

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
			echo 	Form::submit('Add Shipping', ['class' => 'btn btn-primary mt-3',]);
		echo Form::close();
    }


    public function tarm_validation($data){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
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



    public function all_tarms_out_put(){
    	
		?>
	    <div class="table-responsive">
	      <table class="table table-bordered" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url="<?php echo route('tarms-all', 'shipping'); ?>" tarms-data='<?php echo json_encode([
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
	    </div>
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
			echo 	Form::submit('Update Category', ['class' => 'btn btn-primary mt-3',]);
		echo Form::close();
    }


    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The Shipping name format is invalid.',
			    'cat_name.required' => 'The Shipping name field is required.',
			    'cat_name.max' 		=> 'The Shipping name may not be greater than 255 characters.'.$tarm_id,
			    'cat_name.unique' 	=> 'The Shipping name has already been taken.',
			    'cat_name.string' 	=> 'The Shipping name must be given string.',

			    'cat_slug.regex' 	=> 'The Shipping slug format is invalid.',
			    'cat_slug.required' => 'The Shipping slug field is required.',
			    'cat_slug.max' 		=> 'The Shipping slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The Shipping slug has already been taken.',
			    'cat_slug.string' 	=> 'The Shipping slug must be given string.',
			]);
    }


}
