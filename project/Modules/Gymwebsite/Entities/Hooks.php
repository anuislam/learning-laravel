<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use DB;
use App\UserPermission;
use Auth;
use Carbon;
use Module;
use Html;
use View;
use App\UserModel;
use App\BlogPost;
use Route;
use Validator;
use Illuminate\Support\Str;
use Modules\Gymwebsite\Entities\joinrequest;

class hooks extends Model{
	private $permission = '';
	private $usermodel = '';
    private $post = '';
	private $joinrequest = '';

	public function __construct(){
		$this->permission   = new UserPermission();
		$this->usermodel    = new UserModel();
        $this->post         = new BlogPost();
		$this->joinrequest  = new joinrequest();
		add_action('site_header', [$this, 'gym_site_header']);
		add_action('site_footer', [$this, 'gym_site_footer']);
        add_action('not_found_page', [$this, 'gym_404_not_found_page']);
        add_action('ajax_send_join_request', [$this, 'ajax_send_join_request_func']);
        add_action('admin_footer', [$this, 'admin_join_request_modal_func']);
        add_action('page_meta_side', [$this, 'page_meta_side_func']);
        add_action('page_meta', [$this, 'page_meta_func']);
        add_action('page_meta_validation', [$this, 'page_meta_validation_func']);
		add_action('page_meta_save', [$this, 'page_meta_save_func']);
    }
    public function gym_site_header() {
    	 echo  Html::style('https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,900');
    	 echo  Html::style(Module::asset('gymwebsite:css/animate.css'));
    	 echo  Html::style(Module::asset('gymwebsite:css/icomoon.css'));
    	 echo  Html::style(Module::asset('gymwebsite:css/bootstrap.css'));
    	 echo  Html::style(Module::asset('gymwebsite:css/superfish.css'));
    	 echo  Html::style(Module::asset('gymwebsite:css/style.css'));
    	 echo  Html::script(Module::asset('gymwebsite:js/modernizr-2.6.2.min.js'), ['type' => 'text/javascript']);
    	 ?>
		<!--[if lt IE 9]>
		<?php echo  Html::script(Module::asset('gymwebsite:js/respond.min.js'), ['type' => 'text/javascript']); ?>
		<![endif]-->

    	 <?php

    }
    public function gym_site_footer() {
    	echo  Html::script(Module::asset('gymwebsite:js/jquery.min.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/jquery.easing.1.3.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/bootstrap.min.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/jquery.waypoints.min.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/jquery.stellar.min.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/hoverIntent.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/superfish.js'), ['type' => 'text/javascript']);
    	echo  Html::script(Module::asset('gymwebsite:js/main.js'), ['type' => 'text/javascript']);
    }
    public function gym_404_not_found_page() {
    	echo View('gymwebsite::404')->render();
    }

    public function ajax_send_join_request_func($request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'mobile' => 'required|integer|digits_between:8,30|numeric',
            'message' => 'required|string|max:3000',
            'program_title' => 'required|string|max:3000',
        ]);

        if ($validator->passes()) {
            echo json_encode(['success'=>'Thanks for join Request.']);
                $this->joinrequest->insert_order($request->all());
            return;
        }

        echo json_encode(['error'=>$validator->errors()->all()]);
        return;
        
    }

    public function admin_join_request_modal_func(){
        ?>

        <script type="text/javascript">
            function joinrequestviewmodal(th){
                var thisval = $(th).closest('tr')
                var title   = String(thisval.find('td:eq( 0)').html());
                var email   = String(thisval.find('td:eq( 1 )').html());
                var mobile   = String(thisval.find('td:eq( 2 )').html());
                var message   = String(thisval.find('td:eq( 3 )').html());
                open_modal({
                        title: title,
                        message: '<ul class="list-unstyled">'
                        +'<li><strong>Email:</strong>  '+email+'</li>'
                        +'<li><strong>Mobile:</strong>  '+mobile+'</li>'
                        +'<li><strong>Message:</strong>   '+message+'</li>'
                        +'</ul>',
                        cancel_text: 'Close',
                        close_icon:  String('fa-times'),
                        submit_text: 'Close',
                        popup_type: String('modal-primary'),
                        on_submit: {
                            type: 'ajax',
                            url: null,
                            parameters: function () {

                                $('#global_modal').modal('hide');

                                return;
                            }
                           },
                    });
            }

        </script>

        <?php
    }



    public function page_meta_func($error_msg){
        $post_id = Route::current()->post;
        if (empty($post_id) === false) {
          $Page_Short_description = $this->post->get_post_meta((int)$post_id, 'Page_Short_description');          
        }
        //$this->postmodel->get_post_meta($data->id, 'page_bg_image')
        echo heml_card_open('fa fa-pencil', 'Page Meta');

        text_field([
            'name' => 'Page_Short_description',
            'title' => 'Page Short Description',
            'value' => (empty($Page_Short_description) === false) ? $Page_Short_description : old('Page_Short_description'),
            'atts' =>  ['placeholder' => 'Page Short Description', 'class' => 'form-control']
          ], $error_msg);

        echo heml_card_close();
    }

    public function page_meta_side_func($error_msg){
        $post_id = Route::current()->post;
        if (empty($post_id) === false) {
          $page_bg_image = $this->post->get_post_meta((int)$post_id, 'page_bg_image');         
          $page_image = $this->post->get_post_meta((int)$post_id, 'page_image');       
        }
        //$this->postmodel->get_post_meta($data->id, 'page_bg_image')
        echo heml_card_open('fa fa-pencil', 'Page Bg Image');
        echo  media_uploader([
            'name' => 'page_bg_image',
            'title' => 'Upload Image',
            'value' => (empty($page_bg_image) === false) ? $page_bg_image : old('page_bg_image'),
            'atts' =>  [
            'class'      => 'btn bg-purple btn-flat media_uploader_active'
            ]
            ], $error_msg); 
        echo heml_card_close();

        echo heml_card_open('fa fa-pencil', 'Page Image');
        echo  media_uploader([
            'name' => 'page_image',
            'title' => 'Upload Image',
            'value' => (empty($page_image) === false) ? $page_image : old('page_image'),
            'atts' =>  [
            'class'      => 'btn bg-purple btn-flat media_uploader_active'
            ]
            ], $error_msg); 
        echo heml_card_close();
    }

    public function page_meta_validation_func($data){
        Validator::make($data, [
                        'page_bg_image'   => 'required|integer',
                        'page_image'   => 'required|integer',
                        'Page_Short_description'   => 'required|string|max:255',
                    ])->validate();
    }

    public function page_meta_save_func($value){        
      $this->post->update_post_meta($value['post_id'], 'page_bg_image', (int)$value['data']['page_bg_image']);
      $this->post->update_post_meta($value['post_id'], 'page_image', (int)$value['data']['page_image']);
      $this->post->update_post_meta($value['post_id'], 'Page_Short_description', sanitize_text($value['data']['Page_Short_description']));
    }
}
