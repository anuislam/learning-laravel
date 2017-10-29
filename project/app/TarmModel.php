<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Form;

class TarmModel extends Model{

    public function pate_tab_title(){
    	return 'Categorys';
    }

    public function pate_title(){
    	return 'Add Category';
    }


    public function page_icon(){
    	return 'fa fa-facebook';
    }

    public function tarm_form_output($errors){
		echo Form::open(['url' => route('stor-user'), 'method' => 'POST']); 

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
				'value' => old('description'),
				'atts' =>  ['placeholder' => 'Category Description', 'aria-describedby' => 'CategoryDescription', 'class' => 'form-control']
			], $errors);


			echo 	Form::submit('Add Category', ['class' => 'btn btn-primary mt-3',]);
		echo Form::close();
    }


    public function tarm_validation(){
    	return 'fa fa-facebook';
    }

    public function tarm_data_process(){
    	return 'fa fa-facebook';
    }

    public function tarm_data_save(){
    	return 'fa fa-facebook';
    }

}
