<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;
use App\mediaModel;
use App\UserPermission;
use \Auth;
use App\post;


class uploderController extends Controller {
    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new post();  
    }

    public function index(){

        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('upload_file', $current_user['id']) === false) {
            return false;
        }

        $media = $this->mediaModel->get_all_medial([
                'limit' => 50,
                'offset' => 0
            ]);
        ob_start();

        	if ($media) {
        		foreach ($media as $mediavalue) {  
                    $img = $this->mediaModel->get_image_src('thumbnail', $mediavalue->id);
                    $media_direct_url = $this->mediaModel->get_image_src('full', $mediavalue->id);
                    $media_preview  = $this->mediaModel->get_image_src('media_preview', $mediavalue->id);
                    $alt            = $this->postmodel->get_post_meta($mediavalue->id, 'alt');
        			$description       = $this->postmodel->get_post_meta($mediavalue->id, 'description');     
                    $file_type       = $this->postmodel->get_post_meta($mediavalue->id, 'file_type');
                    if (is_image($file_type) === false) {
                       $media_preview = [upload_dir_url('default/largefileicon.png'), '', ''];
                       $media_direct_url = [upload_dir_url($mediavalue->post_content), '', ''];
                    }
        			?>

						<li class="col-3"
                            media_preview="<?php echo $media_preview[0]; ?>"
                            media_direct_url="<?php echo $media_direct_url[0]; ?>"
                            media_id="<?php echo $mediavalue->id; ?>"
                            media_title="<?php echo $mediavalue->post_title; ?>"
                            media_alt="<?php echo $alt; ?>"
                            media_type="<?php echo $file_type; ?>"
                            media_description="<?php echo $description; ?>"
                        >
							<div class="media_uploader_image">
							  <span class="media_uploder_image_select fa fa-check">
							  </span>                  
							  <img src="<?php echo $img[0]; ?>" alt="<?php echo $mediavalue->post_title; ?>" class="img-thumbnail">
							</div>
							<input type="radio" name="media_uploader">
						</li>

        			<?php
        		}
        	}

    	return ob_get_clean();
    }

    public function search(Request $data){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->permission->user_can('upload_file', $current_user['id']) === false) {            
            return false;
        }

        if (empty($data['search_value']) === true){
            $media = $this->mediaModel->get_all_medial([
                'limit' => 50,
                'offset' => 0
            ]);
        }

            $media = $this->mediaModel->get_all_medial([
                'limit' => 50,
                'offset' => 0,
                'search_query' => [
                    'post_title' => sanitize_text($data['search_value'])
                ],

            ]);



        ob_start();

        if ($media) {
            foreach ($media as $mediavalue) {  
                $img = $this->mediaModel->get_image_src('thumbnail', $mediavalue->id);
                $media_direct_url = $this->mediaModel->get_image_src('full', $mediavalue->id);
                $media_preview  = $this->mediaModel->get_image_src('media_preview', $mediavalue->id);
                $alt            = $this->postmodel->get_post_meta($mediavalue->id, 'alt');
                $description       = $this->postmodel->get_post_meta($mediavalue->id, 'description');     
                $file_type       = $this->postmodel->get_post_meta($mediavalue->id, 'file_type');
                if (is_image($file_type) === false) {
                   $media_preview = [upload_dir_url('default/largefileicon.png'), '', ''];
                   $media_direct_url = [upload_dir_url($mediavalue->post_content), '', ''];
                }
                ?>

                    <li class="col-3"
                        media_preview="<?php echo $media_preview[0]; ?>"
                        media_direct_url="<?php echo $media_direct_url[0]; ?>"
                        media_id="<?php echo $mediavalue->id; ?>"
                        media_title="<?php echo $mediavalue->post_title; ?>"
                        media_alt="<?php echo $alt; ?>"
                        media_type="<?php echo $file_type; ?>"
                        media_description="<?php echo $description; ?>"
                    >
                        <div class="media_uploader_image">
                          <span class="media_uploder_image_select fa fa-check">
                          </span>                  
                          <img src="<?php echo $img[0]; ?>" alt="<?php echo $mediavalue->post_title; ?>" class="img-thumbnail">
                        </div>
                        <input type="radio" name="media_uploader">
                    </li>

                <?php
            }
        }

        return ob_get_clean();
    }

    public function delete(){
    	return 'dssdsdsdddd';
    }
    public function update(Request $request, $id){
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();
        if (url_gard('integer', $id) === false) {
             return false;
        }

        if ($this->permission->user_can('edith_media', $current_user['id']) === false) {
            return false;
        }

        $media = $this->mediaModel->get_media($id);
        if ($media === false) {
           return false;
        }


        if ($current_user['id'] != $media->post_author) {
            if ($this->permission->user_can('edith_others_media', $current_user['id']) === false) {
                return false;
            }
        }
        return $this->mediaModel->process_uploader_update_media($request, $id);

    }
}
