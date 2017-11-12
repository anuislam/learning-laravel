<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Image;
use \DB;
use \Auth;
use App\post;
use File;
use App\UserPermission;
use App\UserModel;
use DataTables;
use Validator;
use Purifier;

class mediaModel extends Model{

    private $permission = '';
    private $post = '';
    public function __construct(){
        $this->permission = new UserPermission();  
        $this->post 	  = new post();  
        $this->usermodel  = new UserModel();  
    }

	public function process_store_media($request){
		$cur_user = Auth::user();
		$ck_error = false;
		$folder = date('Y/m');		
		$return_data = [];
		if ($request->hasFile('file')) {	
			$image_size = get_crop_image_size();		
			$file 		= $request->file('file');
			$extension 	= $file->getClientOriginalExtension();
			$title 		= sanitize_text($file->getClientOriginalName());
			$title 		= str_replace(' ', '-', $title);
			$author 	= (int)$cur_user->id;
			$next_id 	= DB::select("show table status like 'posts'");

			if (is_image($file->getMimeType()) === true) {
				$image_name = [];
				if (is_array($image_size) === true) {
					foreach ($image_size as $image) {
						if ($image['name'] == 'full') {
							$image_name[$image['name']] = $folder.'/'.$next_id[0]->Auto_increment.'-full.'.$extension;
						}else{
							$image_name[$image['name']] = $folder.'/'.$next_id[0]->Auto_increment.'-'.$image['width'].'x'.$image['height'].'.'.$extension;
						}						
					}
				}

				$content 	= serialize($image_name);
			}else{
				$content 	= $folder.'/'.$next_id[0]->Auto_increment.'.'.$extension;
			}

			$public_path = public_path('upload').'/'.$folder;

			if (!file_exists($public_path)) {
				File::makeDirectory($public_path, $mode = 0777, true, true);
			}

			$insert_post_id = $this->insert_media([
				'post_title'   	=> $title,
		        'post_author'   => $author,
		        'post_content'  => $content,
		        'post_status'  => 'publish',
			], $file );

			if (is_image($file->getMimeType()) === true) {  
		        if (is_array($image_size) === true) {
		        	foreach ($image_size as $image) {		        		
		        		$this->upload_image(
		        			$image, 
		        			$file, 
		        			$public_path, 
		        			$next_id[0]->Auto_increment.'-full.'.$extension, //full name
		        			$next_id[0]->Auto_increment.'-'.$image['width'].'x'.$image['height'].'.'.$extension //name ny size 
		        			);
		        	}
		        }
		        $media_name = $next_id[0]->Auto_increment.'-full.'.$extension;
				$return_data['thumbnail'] 	 = upload_dir_url($folder.'/'.$next_id[0]->Auto_increment.'-150x150.'.$extension);
			}else{
	        	$file->move($public_path, $next_id[0]->Auto_increment.'.'.$extension);
	        	$media_name = $next_id[0]->Auto_increment.'.'.$extension;
	        	$return_data['thumbnail'] = upload_dir_url('default/fileicon.png');
	        }
		}

		$return_data['media_edith_url'] = false;
		$return_data['media_delete_url'] = false;
		if ($this->permission->user_can('edith_media', $cur_user->id)) {
			$return_data['media_edith_url'] = route('media.edit', $insert_post_id);
		}
		if ($this->permission->user_can('delete_media', $cur_user->id)) {
			$return_data['media_delete_url'] = route('media.destroy', $insert_post_id);
		}
		$return_data['media_url'] 	 = upload_dir_url($folder.'/'.$media_name);
		$return_data['media_id']  	 = $insert_post_id;
		$return_data['media_title']  = $title;
		$return_data['media_name']  = $media_name;
		$return_data['media_type']  = $extension;

		return [
                'type'      => 'success',
                'data'      => $return_data,
            ];
	}

	public function upload_image($size, $file, $public_path, $file_name, $namebysize){
		$size['height'] = (isset($size['height'])) ? (int)$size['height'] : '' ;
		$size['width'] = (int)$size['width']; 
		$path = $public_path.'/'.$namebysize;
		if ($size['resize'] === true) {
			if ($size['name'] == 'full') {
				$file->move($public_path, $file_name);
			}else{
				$img = Image::make($file);
				$img->resize($size['width'], $size['height']);
				$img->save($path, 100);
			}
		}else{
			if ($size['name'] == 'full') {			        			
				$file->move($public_path, $file_name);
			}else{
				$img = Image::make($file);
				$img->fit($size['width'], $size['height']);
				$img->save($path, 100);
			}
		}
	}

	public function insert_media($data, $file){
		$data = (array)$data;

		$data['post_title'] = (isset($data['post_title'])) ? $data['post_title'] : '' ;
		$data['post_author'] = (isset($data['post_author'])) ? $data['post_author'] : '' ;
		$data['post_content'] = (isset($data['post_content'])) ? $data['post_content'] : '' ;
		$data['post_status'] = (isset($data['post_status'])) ? $data['post_status'] : 'pending' ;
		$data['post_type'] = 'media' ;
		$data['created_at'] = new \DateTime() ;
		$data['updated_at'] = new \DateTime() ;

		$id = DB::table('posts')->insertGetId($data);
		if ($id) {			
			if (is_image($file->getMimeType()) === true) {
				$this->post->update_post_meta($id, 'alt', $data['post_title']);
			}
			$this->post->update_post_meta($id, 'file_type', $file->getMimeType());
		}
		return $id;
	}
	public function get_media_datatable(){
		$cur_user = Auth::user();
		$db_qruery = DB::table('posts')->select('id','post_title', 'post_author', 'post_content', 'post_status', 'created_at', 'updated_at')->where('post_type', 'media');

        if ($this->permission->user_can('see_others_media', $cur_user->id) === false) {
            $db_qruery = DB::table('posts')->select('id','post_title', 'post_author', 'post_content', 'post_status', 'created_at', 'updated_at')->where('post_type', 'media')->where('post_author', $cur_user->id);
        }

		return DataTables::of($db_qruery)
            ->addColumn('image', function ($data) {
	    		$file_type = $this->post->get_post_meta($data->id, 'file_type');
				if (is_image($file_type) === true ) {
					$data_image = $this->get_image_src('thumbnail', $data->id);
					$full_img = $this->get_image_src('full', $data->id);
					return '<a href="'.$full_img[0].'"><img width="'.$data_image[1].'" height="'.$data_image[2].'" src="'.$data_image[0].'" alt="'.$data->post_title.'"></a>';
				}

					return '<a href="'.upload_dir_url($data->post_content).'"><img width="150" height="150" src="'.upload_dir_url('default/fileicon.png').'" alt="'.$data->post_title.'"></a>';
                        
                    })
            ->addColumn('file_type', function ($data) {
                        return $this->post->get_post_meta($data->id, 'file_type');;
                    })
            ->addColumn('author_name', function ($data) {
            			$user = $this->usermodel->get_user($data->post_author);
                        return $user->fname.' '. $user->lname;
                    })
            ->addColumn('action', function ($data) {
            			$cur_user = Auth::user();
						$return_data = '';
						if ($this->permission->user_can('edith_media', $cur_user->id)) {
							$return_data .= '<a href="'.route('media.edit', $data->id).'" class="btn btn-secondary">Edith</a> ';
						}
						if ($this->permission->user_can('delete_media', $cur_user->id)) {
							$return_data .= ' <a 
                        			onclick="data_modal(this)" 
                        			data-title="Ready to Delete?" 
                        			data-message="Are you sure you want to delete this media?" 
                        			cancel_text="Cancel" 
                        			submit_text="Delete"                   			
                        			data-type="post" data-parameters=\'{"_token":"'. csrf_token() .'", "_method": "DELETE"}\'
                        			href="'.route('media.destroy', $data->id).'" class="btn btn-danger"
                        		>Delete</a>';
						}

                        return $return_data;
                    })
            ->escapeColumns(['*'])
            ->make(true);
	}

	public function get_image_src($image_key, $media_id){
	    $media_id       = (int)$media_id;
	    $media_found    = false;
	    $full_image    = false;
	    $meta = DB::table('posts')
	    ->where('id', $media_id)->first();
	    $width 	= false;
	    $height = false;
	    $def_width = false;
	    $def_height = false;
	    $get_crop_image_size = get_crop_image_size();
	    if (is_array($get_crop_image_size)) {
	    	foreach ($get_crop_image_size as $size) {
	    		if ($size['name'] == $image_key) {
		    		$width 	= $size['width'];
		    		$height = $size['height'];
	    		}
	    	}
	    }

	    if (count($meta)  == 1 ) {
	        $image_size = @unserialize($meta->post_content);
	        if (is_array($image_size)) {
	            foreach ($image_size as $key => $value) {
	                if ($image_key == $key) {
	                    $media_found = true;
	                    return [upload_dir_url($value), $width, $height];
	                    break;
	                }
	                if ('full' == $key) {	                    
	                    $full_image = $value;
	                }
	            }
	        }
	    }
	    if ($media_found === false) {
	    	$file = upload_dir_path($full_image);
	    	if (file_exists($file)) {
		    	$img 	= Image::make(upload_dir_path($full_image));
		    	$def_width 		= $img->width();
		    	$def_height 	= $img->height();
	    	}
			return ($full_image) ? [upload_dir_url($full_image), $def_width, $def_height] : false ;
	    }
	    return false;
	}

	public function get_media($id){
		$media = $this->post->get_post($id);
		if ($media) {
			if ($media->post_type == 'media') {
				return $media;
			}
		}
		return false;
	}

	public function process_edith_media($request, $id){
		$this->edith_media_validator($request->all())->validate();

		$this->update_media($request, $id);
	}


	public function update_media($request, $id)	{
		$id = (int)$id;
	    $update['mtitle'] 			= sanitize_text($request['mtitle']);
	    $update['alt'] 				= sanitize_text($request['alt']);
	    $update['post_status'] 		= sanitize_text($request['media_status']);
	    $update['description'] 		= Purifier::clean($request['description'], array('AutoFormat.AutoParagraph' => false,'AutoFormat.RemoveEmpty'   => true));

		$data = DB::table('posts')
	              ->where('id',  $id)
	              ->update([
	              		'post_title' 	=> $update['mtitle'] ,
	              		'post_status' 	=> $update['post_status'] ,
	              		'updated_at' 	=> new \DateTime() ,
	              ]);  
	    $this->post->update_post_meta($id, 'alt', $update['alt']);	     
	    $this->post->update_post_meta($id, 'description', $update['description']);	     
	}


	public function edith_media_validator($data){
		return Validator::make($data, [
			    'mtitle' 		 => 'nullable|string|max:255',
			    'alt' 	 		 => 'nullable|string|max:255',
			    'description' 	 => 'nullable',
			    'media_status' 	 => 'required|string|max:30|regex:/^[a-zA-Z]{2,30}$/',
			], 
			[
				'mtitle.max' => 'The media title may not be greater than 255 characters.',
				'mtitle.string' => 'The media title must be given string.',

				'alt.max' => 'The Alt may not be greater than 255 characters.',
				'alt.string' => 'The Alt must be given string.',

				'media_status.max' => 'The media status may not be greater than 30 characters.',
				'media_status.required' => 'The media status field is required.',
				'media_status.regex' => 'The media status format is invalid.',
				'media_status.string' => 'The media status must be given string.',
			]
		);
	}

	public function process_delete_media($id){
		$media = $this->get_media($id);
		if ($media) {
			$file_type = $this->post->get_post_meta($media->id, 'file_type');
			if (is_image($file_type)) {
				$media_size = @unserialize($media->post_content);
				if (is_array($media_size)) {
					foreach ($media_size as $key => $value) {
						if (file_exists(upload_dir_path($value))) {
							unlink(upload_dir_path($value));
						}
					}
				}
			}else{
				if (file_exists(upload_dir_path($media->post_content))) {
					unlink(upload_dir_path($media->post_content));
				}				
			}
		}
		DB::table('posts')->where('id', $id)->delete();
		DB::table('post_meta')->where('post_id', $id)->delete();
	}

}
