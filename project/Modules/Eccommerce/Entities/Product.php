<?php

namespace Modules\Eccommerce\Entities;

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

class product extends post_type{
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    private $tarmmodel = '';

    public function __construct()
    {
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
        $this->tarmmodel    = new TarmModel();  
        parent::__construct();
    }

    public function post_type_setting(){
      return [
        'add_new_title'            => 'Add New',
        'all_post_title'            => 'All ',
        'edit_post_title'            => 'Edit ',
        'page_sub_title'        => 'Product',
        'capability'          => [
          'edith_post'          => 'manage_product', 
          'edith_others_post'  	=> 'manage_product',  
          'read_post'          	=> 'manage_product', 
          'read_others_post'   	=> 'manage_product', 
          'delete_post'        	=> 'manage_product', 
          'delete_others_post' 	=> 'manage_product', 
          'create_posts'       	=> 'add_product', 
        ],

      ];
    }

  public function post_content_output($error_msg = ''){
   ?>
	
	<?php echo Form::open(['url' =>  route('stor_post', ['product']), 'method' => 'post']); ?>
	<div class="row">
		<div class="col-sm-8">
			<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>
			<?php echo text_field([
			                    'name' => 'product_title',
			                    'title' => 'Product title',
			                    'value' => old('product_title'),
			                    'atts' =>  [
			                      'placeholder' => 'Product title', 
			                      'class' => 'form-control',
			                    ]
			                  ], $error_msg); ?>
			<?php echo heml_card_close(); ?>

			<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>


			<?php 			
	 			textarea_editor([
                    'name' => 'product_content',
                    'title' => 'Product content',
                    'value' => old('product_content'),
                    'atts' =>  [
                      'style' => 'min-height:400px;'
                      ]
                  ], $error_msg); 
                  ?>

			<?php echo heml_card_close(); ?>

			<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>
			<?php echo  textarea_field([
                    'name' => 'product_short_content',
                    'title' => 'Product short description',
                    'value' => old('product_short_content'),
                    'atts' =>  [
                      'placeholder' => 'Product short description',
                      'style' => 'min-height:250px;width:100%;'
                      ]
                  ], $error_msg); ?>
			<?php echo heml_card_close(); ?>


			<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>

          <div class="nav-tabs-custom admin_vertical_tab">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#general" data-toggle="tab">General</a></li>
              <li><a href="#inventory" data-toggle="tab">Inventory</a></li>
              <li><a href="#shipping" data-toggle="tab">Shipping</a></li>
              <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="general">

					<?php echo number_field([
								'name' => 'regular_price',
								'title' => 'Regular price',
								'value' => old('regular_price'),
								'atts' =>  [
								'placeholder' => 'Regular price', 
								'class' => 'form-control',
							]
						], $error_msg); ?>

					<?php echo number_field([
								'name' => 'sale_price',
								'title' => 'Sale price',
								'value' => old('sale_price'),
								'atts' =>  [
								'placeholder' => 'Sale price', 
								'class' => 'form-control',
							]
						], $error_msg); ?>

					<div class="form-group">
						<div class="checkbox icheck">
							<label>
								<?php echo Form::checkbox('sale_price_schedule', 'yes', false, [
									'id' => 'sale_price_schedule'
									]); ?> Schedule
							</label>
						</div>
					</div>

					<?php echo date_range_field([
								'name' => 'sale_price_dates',
								'title' => 'Sale price Schedule Range',
								'value' => old('sale_price_dates'),
								'atts' =>  [
									'placeholder' => 'Sale price Schedule Range', 
									'class' => 'form-control pull-right daterangepicker_action schedule_toggle',
								]
						], $error_msg); ?>
               </div>               
               <div class="tab-pane" id="inventory">

					<?php echo text_field([
								'name' => 'product_sku',
								'title' => 'Sku Id',
								'value' => old('product_sku'),
								'atts' =>  [
								'placeholder' => 'Sku Id', 
								'class' => 'form-control',
							]
						], $error_msg); ?>


					<div class="form-group">
						<div class="checkbox icheck">
							<label>
								<?php echo Form::checkbox('manage_stock', 'yes', false, [
									'id' => 'manage_stock',
									]); ?> Enable stock management at product level
							</label>
						</div>
					</div>

					<?php echo number_field([
								'name' => 'stock_quantity',
								'title' => 'Stock quantity',
								'value' => old('stock_quantity'),
								'atts' =>  [
								'placeholder' => 'Stock quantity', 
								'class' => 'form-control stock_manage_toggle',
							]
						], $error_msg); ?>

                <?php echo select_field([
                    'name' => 'stock_status',
                    'title' => 'Stock status',
                    'value' => old('stock_status'),
                    'atts' =>  ['class' => 'form-control select2', 'style' => 'width: 100%;'],
                    'items' =>  [
                    	'instock' => 'In stock',
                    	'outofstock' => 'Out of stock',
                    ],
                  ], $error_msg) ?>


					<div class="form-group">
						<div class="checkbox icheck">
							<label>
								<?php echo Form::checkbox('sold_individually', 'yes', false, [
									'class' => ''
									]); ?> Enable this to only allow one of this item to be bought in a single order
							</label>
						</div>
					</div>

               </div>       
               <div class="tab-pane" id="shipping">

					<?php echo text_field([
								'name' => 'weight',
								'title' => 'Weight (kg)',
								'value' => old('weight'),
								'atts' =>  [
								'placeholder' => 'Weight (kg)', 
								'class' => 'form-control',
							]
						], $error_msg); ?>
						<div class="form-group">
							<div class="row">	
								<div class="col-sm-12">		
									<label>Dimensions (cm)</label>								
								</div>					
							</div>
							<div class="row">
								<div class="col-sm-4">
    								<?php echo Form::text( 'product_length', '', [
    									'class' => 'form-control',
    									'placeholder' => 'Length',
    									] ); ?>
								</div>	
								<div class="col-sm-4">
    								<?php echo Form::text( 'product_width', '', [
    									'class' => 'form-control',
    									'placeholder' => 'Width',
    									] ); ?>
								</div>	
								<div class="col-sm-4">
    								<?php echo Form::text( 'product_height', '', [
    									'class' => 'form-control',
    									'placeholder' => 'Height',
    									] ); ?>
								</div>	
							</div>
						</div>

                <?php echo select_field([
                    'name' => 'shipping_class',
                    'title' => 'Shipping class',
                    'value' => old('shipping_class'),
                    'atts' =>  ['class' => 'form-control select2', 'style' => 'width: 100%;'],
                    'items' =>  [
                    	'instock' => 'set up your class from tarm',
                    ],
                  ], $error_msg) ?>


               </div>    

               <div class="tab-pane" id="advanced">
				<?php echo  textarea_field([
	                    'name' => 'purchase_note',
	                    'title' => 'Purchase note',
	                    'value' => old('purchase_note'),
	                    'atts' =>  [
	                      'placeholder' => 'Purchase note',
	                      'rows' => '2',
	                      'cols' => '50',
	                      'style' => 'min-height:80px;width:100%;resize:vertical;'
	                      ]
	                  ], $error_msg); ?>
	                 <div class="form-group">
						<div class="checkbox icheck">
							<label>
								<?php echo Form::checkbox('comment_status', 'yes', true, [
									'class' => 'sdopijsdjjsjdi'
									]); ?> Enable reviews
							</label>
						</div>
					</div>
               </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

			<?php echo heml_card_close(); ?>

		</div>
		
            <div class="col-sm-4">
            	<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>

	                <?php echo  select_field([
	                    'name' => 'product_status',
	                    'title' => 'Product Status',
	                    'value' => old('product_status'),
	                    'atts' =>  [
	                        'class' => 'form-control select2', 
	                        'style' => 'width: 100%;',
	                      ],
	                    'items' =>  [
	                    	'publish' => 'Publish',
	                    	'pending' => 'Pending',
	                    	'trush' => 'trush'
	                    ],
	                  ], $error_msg); 

	                	submib_button([
	                		'title' => 'Submit',
	                		'attr' => [
	                			'class' => 'btn bg-olive btn-flat pull-right',
	                		]
	                	]);

	                  ?>
					
				<?php echo heml_card_close(); ?>

            	<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>

	                <?php echo  select_field([
	                    'name' => 'post_tags[]',
	                    'title' => 'Post Tags',
	                    'value' => old('post_tags'),
	                    'atts' =>  [
	                        'aria-describedby' => 'Userrool', 
	                        'class' => 'form-control select2', 
	                        'style' => 'width: 100%;',
	                        'multiple' => 'multiple',
	                      ],
	                    'items' =>  $this->get_post_type_tarm([
	                          'tarm-type' => 'tags'
	                        ]),
	                  ], $error_msg); ?>
				<?php echo heml_card_close(); ?>

            	<?php echo heml_card_open('fa fa-shopping-cart', 'Product title'); ?>
	                  
	                <?php echo  select_field([
	                    'name' => 'post_tags[]',
	                    'title' => 'Post Tags',
	                    'value' => old('post_tags'),
	                    'atts' =>  [
	                        'aria-describedby' => 'Userrool', 
	                        'class' => 'form-control select2', 
	                        'style' => 'width: 100%;',
	                        'multiple' => 'multiple',
	                      ],
	                    'items' =>  $this->get_post_type_tarm([
	                          'tarm-type' => 'tags'
	                        ]),
	                  ], $error_msg); ?>
				<?php echo heml_card_close(); ?>

            	<?php echo heml_card_open('fa fa-image', 'Product image'); ?>
				<?php echo  media_uploader([
						'name' => 'product_image',
						'title' => 'Upload Product Image',
						'value' => old('product_image'),
						'atts' =>  [
							'class'      => 'btn bg-purple btn-flat media_uploader_active', 
							'cancel_text'    => 'Cancel post image',
							'submit_text'    => 'Select post image',
							'uploader_title'    => 'Upload Product Image',
					]
				], $error_msg); ?>
				<?php echo heml_card_close(); ?>

            	<?php echo heml_card_open('fa fa-image', 'Product image');

            		media_gallery_uploader([
						'name' => 'product_gallery',
						'title' => 'Upload Product Image',
						'value' => old('product_gallery'),
						'id' 	=> 'image_gallery_list',
						'cancel_text'	=> 'Cancel Product image',
						'submit_text'	=> 'Select product image',
						'button_title'	=> 'Add Image',
						'button_class'	=> 'btn btn-block bg-purple',
					], $error_msg);

            	 ?>

			


				<?php echo heml_card_close(); ?>
            </div>
	</div>
	<?php echo Form::close(); ?>

   <?php
  } 


  public function post_type_validation($data){
      return Validator::make($data, [
                'product_title'      	=> 'required|string|max:255|',
                'product_content'      	=> 'nullable',
                'product_status' 			=> 'required|string',
            ]);
  }


}
