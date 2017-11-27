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

class tags extends TarmModel
{

	public function pate_tab_title(){
    	return 'Post tag';
    }
    public function pate_title(){
    	return 'Add Tag';
    }
    public function page_icon(){
    	return 'fa fa-pencil';
    }

    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-tarms', 'tags'), 'method' => 'POST']); 
			text_field([
				'name' => 'cat_name',
				'title' => 'Tag Name',
				'value' => old('cat_name'),
				'atts' =>  ['placeholder' => 'Tag Name', 'aria-describedby' => 'TagName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Tag Slug',
				'value' => old('cat_slug'),
				'atts' =>  ['placeholder' => 'Tag Slug', 'aria-describedby' => 'TagSlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Tag Description',
				'value' => old('cat_description'),
				'atts' =>  ['placeholder' => 'Tag Description', 'aria-describedby' => 'TagDescription', 'class' => 'form-control']
			], $errors);

			echo 	Form::submit('Add tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }



    public function tarm_validation($data){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The tag name format is invalid.',
			    'cat_name.required' => 'The tag name field is required.',
			    'cat_name.max' 		=> 'The tag name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The tag name has already been taken.',
			    'cat_name.string' 	=> 'The tag name must be given string.',

			    'cat_slug.regex' 	=> 'The tag slug format is invalid.',
			    'cat_slug.required' => 'The tag slug field is required.',
			    'cat_slug.max' 		=> 'The tag slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The tag slug has already been taken.',
			    'cat_slug.string' 	=> 'The tag slug must be given string.',
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
    		return redirect()->back()->with('success_msg', 'Tag create successful.');
    	}
    	return redirect()->back()->with('error_msg', 'Operation failed.');
    }



    public function all_tarms_out_put(){
    	
		?>
	      <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', 'tags'); ?>' tarms-data='<?php echo json_encode([
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
	            <th>Tag name</th>
	            <th>Tag Slug</th>
	            <th>Actions</th>
	          </tr>
	        </thead>
	        <tfoot>
	          <tr>
	            <th>Tag name</th>
	            <th>Tag Slug</th>
	            <th>Actions</th>
	          </tr>
	        </tfoot>
	      </table>
		<?php
    }

    public function tarm_edit_form_output($value = '', $errors)
    {
    	$value = json_decode(json_encode($value),true);
		echo Form::open(['url' => route('edit-tarm-update', $value['id']).'/tags', 'method' => 'POST']);
		 echo Form::hidden('_method', 'PATCH');
			text_field([
				'name' => 'cat_name',
				'title' => 'Tag Name',
				'value' => $value['tarm-name'],
				'atts' =>  ['placeholder' => 'Tag Name', 'aria-describedby' => 'TagName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Tag Slug',
				'value' => $value['tarm-slug'],
				'atts' =>  ['placeholder' => 'tag Slug', 'aria-describedby' => 'TagSlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Tag Description',
				'value' => $value['description'],
				'atts' =>  ['placeholder' => 'tag Description', 'aria-describedby' => 'TagDescription', 'class' => 'form-control']
			], $errors);

			echo 	Form::submit('Update tag', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }


    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The tag name format is invalid.',
			    'cat_name.required' => 'The tag name field is required.',
			    'cat_name.max' 		=> 'The tag name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The tag name has already been taken.',
			    'cat_name.string' 	=> 'The tag name must be given string.',

			    'cat_slug.regex' 	=> 'The tag slug format is invalid.',
			    'cat_slug.required' => 'The tag slug field is required.',
			    'cat_slug.max' 		=> 'The tag slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The tag slug has already been taken.',
			    'cat_slug.string' 	=> 'The tag slug must be given string.',
			]);
    }




}
