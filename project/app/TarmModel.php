<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;
use App\UserModel;
use App\UserPermission;
use \Auth;
use \DB;
use Validator;
use Purifier;
use Carbon;
use DataTables;

class TarmModel extends Model{


    private $usermodel = '';
    private $permission = '';

    public function __construct(){
        $this->usermodel = new UserModel();
        $this->permission = new UserPermission();  
    }

    public function pate_tab_title(){
    	return 'Categorys';
    }

    public function pate_title(){
    	return 'Add Category';
    }


    public function page_icon(){
    	return 'fa fa-pencil';
    }

    public function pate_sub_title(){
        return 'Control Panel';
    }

    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-tarms', '/'), 'method' => 'POST']); 
			text_field([
				'name' => 'cat_name',
				'title' => 'Category Name',
				'value' => old('cat_name'),
				'atts' =>  ['placeholder' => 'Category Name', 'aria-describedby' => 'CategoryName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Category Slug',
				'value' => old('cat_slug'),
				'atts' =>  ['placeholder' => 'Category Slug', 'aria-describedby' => 'CategorySlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Category Description',
				'value' => old('cat_description'),
				'atts' =>  ['placeholder' => 'Category Description', 'aria-describedby' => 'CategoryDescription', 'class' => 'form-control']
			], $errors);
			echo 	Form::submit('Add Category', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }


    public function tarm_validation($data){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The category name format is invalid.',
			    'cat_name.required' => 'The category name field is required.',
			    'cat_name.max' 		=> 'The category name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The category name has already been taken.',
			    'cat_name.string' 	=> 'The category name must be given string.',

			    'cat_slug.regex' 	=> 'The category slug format is invalid.',
			    'cat_slug.required' => 'The category slug field is required.',
			    'cat_slug.max' 		=> 'The category slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The category slug has already been taken.',
			    'cat_slug.string' 	=> 'The category slug must be given string.',
			]);
    }

    public function tarm_data_process($request, $tarm_type){
    	$this->tarm_validation($request->all())->validate();
    	return $this->tarm_data_save($request, $tarm_type);
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
    		return redirect()->back()->with('success_msg', 'Category create successful.');
    	}
    	return redirect()->back()->with('error_msg', 'Operation failed.');
    }

    public function user_can($user_id){
    	if ($this->permission->user_can('create_tarm', $user_id)) {
			return true;
        }
        return false;
    }


    public function all_tarms_out_put(){
    	
		?>
	      <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', '/'); ?>' tarms-data='<?php echo json_encode([
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
	            <th>Category name</th>
	            <th>Category Slug</th>
	            <th>Actions</th>
	          </tr>
	        </thead>
	        <tfoot>
	          <tr>
	            <th>Category name</th>
	            <th>Category Slug</th>
	            <th>Actions</th>
	          </tr>
	        </tfoot>
	      </table>
		<?php
    }

    public function tarm_edit_form_output($value = '', $errors)
    {
    	$value = json_decode(json_encode($value),true);
		echo Form::open(['url' => route('edit-tarm-update', $value['id']), 'method' => 'POST']);
		 echo Form::hidden('_method', 'PATCH');
			text_field([
				'name' => 'cat_name',
				'title' => 'Category Name',
				'value' => $value['tarm-name'],
				'atts' =>  ['placeholder' => 'Category Name', 'aria-describedby' => 'CategoryName', 'class' => 'form-control']
			], $errors);

			text_field([
				'name' => 'cat_slug',
				'title' => 'Category Slug',
				'value' => $value['tarm-slug'],
				'atts' =>  ['placeholder' => 'Category Slug', 'aria-describedby' => 'CategorySlug', 'class' => 'form-control']
			], $errors);

			textarea_field([
				'name' => 'cat_description',
				'title' => 'Category Description',
				'value' => $value['description'],
				'atts' =>  ['placeholder' => 'Category Description', 'aria-describedby' => 'CategoryDescription', 'class' => 'form-control']
			], $errors);
			echo 	Form::submit('Update Category', ['class' => 'btn bg-olive btn-flat',]);
		echo Form::close();
    }

    public function get_tarms($id){
        $id = (int)$id;
        $data = DB::table('tarms')->where('id', $id)->first();
        return ($data) ? $data : false ;
    }


    public function tarm_edit_data_process($request, $tarm_id ) {
    	$this->tarm_edit_validation($request->all(), $tarm_id)->validate();
    	return $this->tarm_edit_data_update($request, $tarm_id);
    }

    public function tarm_edit_validation($data, $tarm_id){
    	$cur_user = Auth::user();
    	return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,100}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,100}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
			    'cat_name.regex' 	=> 'The category name format is invalid.',
			    'cat_name.required' => 'The category name field is required.',
			    'cat_name.max' 		=> 'The category name may not be greater than 255 characters.',
			    'cat_name.unique' 	=> 'The category name has already been taken.',
			    'cat_name.string' 	=> 'The category name must be given string.',

			    'cat_slug.regex' 	=> 'The category slug format is invalid.',
			    'cat_slug.required' => 'The category slug field is required.',
			    'cat_slug.max' 		=> 'The category slug may not be greater than 255 characters.',
			    'cat_slug.unique' 	=> 'The category slug has already been taken.',
			    'cat_slug.string' 	=> 'The category slug must be given string.',
			]);
    }

    public function tarm_edit_data_update($data, $tarm_id){
        $data['cat_slug'] = sunatize_slug_text($data['cat_slug']);
    	$data = DB::table('tarms')
                    ->where('id',  $tarm_id)
                    ->update([
			    		'tarm-slug' => sanitize_text(strtolower($data['cat_slug'])),
			    		'tarm-name' => sanitize_text($data['cat_name']),
			    		'description' => Purifier::clean($data['cat_description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true)),
			    		'updated_at' => new \DateTime(),
                    ]);

    	return redirect()->back()->with('success_msg', 'Update successful.');
    }

    public function edit_page_title($value='')
    {
    	$value = json_decode(json_encode($value),true);
    	return $value['tarm-name'];
    }
    public function edit_page_footer_title($value='')
    {
    	return 'Last Updated '. Carbon\Carbon::parse($value->updated_at)->format('Y/m/d - h:i:s');
    }


    public function update_tarm_meta($id, $key, $value){
        $id = (int)$id;
        if ($this->tarm_meta_exists($id, $key)) {
            $data = DB::table('tarm_meta')
                    ->where('tarm_id',  $id)
                    ->where('meta_key',  $key)
                    ->update([
                        'meta_value' => $value
                    ]);            
        }else{
            $data = DB::table('tarm_meta')->insert([
                'tarm_id' => $id,
                'meta_key' => $key,
                'meta_value' => $value
            ]);
        }
        return ($data) ? true : false ;

    }

    public function tarm_meta_exists($id, $key){
        $id = (int)$id;
        $tarm_meta = DB::table('tarm_meta')->select('id')->where('tarm_id', $id)->where('meta_key', $key)->first();
        return (count($tarm_meta) > 0) ? true : false ;
    }

    public function get_tarm_meta($id, $key){
        $id = (int)$id;
        $tarm_meta = DB::table('tarm_meta')->select('meta_value')->where('tarm_id', $id)->where('meta_key', $key)->first();
        return (count($tarm_meta) == 1) ? $tarm_meta->meta_value : false ;
    }

    public function get_tarm_query(array $data){
        $query = DB::table('tarms');
        if (isset($data['tarm-type']) === true) {
                $query->where('tarm-type', $data['tarm-type']);
        }
        $tarm_data = $query->get();
        return ( $tarm_data->count() > 0 ) ? $tarm_data : false ;
    }

    public function delete_tarm_with_meta($id){        
        DB::table('tarms')->where('id', $id)->delete();    
        DB::table('tarm_meta')->where('tarm_id', $id)->delete(); 
    }

    public function tarm_data_for_datatable($tarm_type){
        return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', $tarm_type))
        ->addColumn('action', function ($tarm) {
            global $tarmname;
            return '<a href="'.route('edit-tarm', $tarm->id).'/" class="btn bg-purple btn-flat">Edith</a> <a

        onclick="data_modal(this)" 
        data-title="Ready to Delete?"
        data-message=\'Are you sure you want to delete this?\'
        cancel_text="Cancel"
        submit_text="Delete"
        data-type="post"
        data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'


            href="'.route('delete-tarm', $tarm->id).'" class="btn bg-maroon btn-flat">Delete</a>';
        })        
        ->escapeColumns(['*'])
        ->make(true);
    }

}
