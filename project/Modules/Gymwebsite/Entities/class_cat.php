<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use App\post_type;
use Form;
use App\TarmModel;
use App\UserPermission;
use Auth;
use Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;
use DB;
use Purifier;
use DataTables;
use Carbon;

class class_cat extends TarmModel{
    public function pate_tab_title(){
      return 'Class Category';
    }
    public function pate_title(){
      return 'Add Category';
    }
    public function page_icon(){
      return 'fa fa-pencil';
    }

    public function tarm_form_output($errors){
    echo Form::open(['url' => route('stor-tarms', 'class-cat'), 'method' => 'POST']); 
      text_field([
        'name' => 'cat_name',
        'title' => 'Class Name',
        'value' => old('cat_name'),
        'atts' =>  ['placeholder' => 'Class Name', 'class' => 'form-control']
      ], $errors);

      text_field([
        'name' => 'cat_slug',
        'title' => 'Class Slug',
        'value' => old('cat_slug'),
        'atts' =>  ['placeholder' => 'Class Slug', 'class' => 'form-control']
      ], $errors);

      textarea_field([
        'name' => 'cat_description',
        'title' => 'Class Description',
        'value' => old('cat_description'),
        'atts' =>  ['placeholder' => 'Class Description', 'class' => 'form-control']
      ], $errors);

      echo  Form::submit('Add Class', ['class' => 'btn bg-olive btn-flat',]);
    echo Form::close();
    }



    public function tarm_validation($data){
      $cur_user = Auth::user();
      return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name',
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug',
                'cat_description'      => 'nullable',
            ], [
          'cat_name.regex'  => 'The Class name format is invalid.',
          'cat_name.required' => 'The Class name field is required.',
          'cat_name.max'    => 'The Class name may not be greater than 255 characters.',
          'cat_name.unique'   => 'The Class name has already been taken.',
          'cat_name.string'   => 'The Class name must be given string.',

          'cat_slug.regex'  => 'The Class slug format is invalid.',
          'cat_slug.required' => 'The Class slug field is required.',
          'cat_slug.max'    => 'The Class slug may not be greater than 255 characters.',
          'cat_slug.unique'   => 'The Class slug has already been taken.',
          'cat_slug.string'   => 'The Class slug must be given string.',
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
        return redirect()->back()->with('success_msg', 'Class create successful.');
      }
      return redirect()->back()->with('error_msg', 'Operation failed.');
    }



    public function all_tarms_out_put(){
      
    ?>
        <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0" tarms-url='<?php echo route('tarms-all', 'class-cat'); ?>' tarms-data='<?php echo json_encode([
        ['data' => 'tarm-name'],
        ['data' => 'tarm-slug'],
        [
          'data'     => 'action',
          'searchable' => 'false',
          'orderable'  => 'false',
        ]
      ]);?>'>
          <thead>
            <tr>
              <th>Class name</th>
              <th>Class Slug</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Class name</th>
              <th>Class Slug</th>
              <th>Actions</th>
            </tr>
          </tfoot>
        </table>
    <?php
    }

    public function tarm_edit_form_output($value = '', $errors)
    {
      $value = json_decode(json_encode($value),true);
    echo Form::open(['url' => route('edit-tarm-update', [$value['id'], 'tags']), 'method' => 'PATCH']);
      text_field([
        'name' => 'cat_name',
        'title' => 'Class Name',
        'value' => $value['tarm-name'],
        'atts' =>  ['placeholder' => 'Class Name', 'class' => 'form-control']
      ], $errors);

      text_field([
        'name' => 'cat_slug',
        'title' => 'Class Slug',
        'value' => $value['tarm-slug'],
        'atts' =>  ['placeholder' => 'cat_name Slug', 'class' => 'form-control']
      ], $errors);

      textarea_field([
        'name' => 'cat_description',
        'title' => 'Class Description',
        'value' => $value['description'],
        'atts' =>  ['placeholder' => 'Class Description','class' => 'form-control']
      ], $errors);

      echo  Form::submit('Update Class', ['class' => 'btn bg-olive btn-flat',]);
    echo Form::close();
    }


    public function tarm_edit_validation($data, $tarm_id){
      $cur_user = Auth::user();
      return Validator::make($data, [
                'cat_name'      => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]{2,30}$/|unique:tarms,tarm-name,'.$tarm_id,
                'cat_slug'      => 'required|string|max:255|regex:/^[a-zA-Z0-9-]{2,30}$/|unique:tarms,tarm-slug,'.$tarm_id,
                'cat_description'      => 'nullable',
            ], [
          'cat_name.regex'  => 'The Class name format is invalid.',
          'cat_name.required' => 'The Class name field is required.',
          'cat_name.max'    => 'The Class name may not be greater than 255 characters.',
          'cat_name.unique'   => 'The Class name has already been taken.',
          'cat_name.string'   => 'The Class name must be given string.',

          'cat_slug.regex'  => 'The Class slug format is invalid.',
          'cat_slug.required' => 'The Class slug field is required.',
          'cat_slug.max'    => 'The Class slug may not be greater than 255 characters.',
          'cat_slug.unique'   => 'The Class slug has already been taken.',
          'cat_slug.string'   => 'The Class slug must be given string.',
      ]);
    }

    public function tarm_data_for_datatable($tarm_type){
        return DataTables::of(DB::table('tarms')->select('id', 'tarm-slug', 'tarm-name', 'tarm-type')->where('tarm-type', $tarm_type))
        ->addColumn('action', function ($tarm) {
            return '<a href="'.route('edit-tarm', [$tarm->id, 'class-cat']).'/" class="btn bg-purple btn-flat">Edith</a> <a

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
