
  <div class="modal fade" id="global_modal" tabindex="-1" role="dialog" aria-labelledby="global_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="global_modal_label"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" id="close_icon"></span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" id="data_cancel" type="button" data-dismiss="modal"></button>
          <button class="btn btn-primary" id="data_submit" type="button"></button>
        </div>
      </div>
    </div>
  </div>  


  <div class="modal fade" id="global_media_uploader" tabindex="-1" role="dialog" aria-labelledby="global_media_upload_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="global_media_upload_label">this is uploader titme</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" id="close_icon">
              <i class="fa fa-times" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="modal-body">



<nav class="nav nav-tabs" id="myTab" role="tablist">
  <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload Files</a>
  <a class="nav-item nav-link active" id="nav_media_uploader_tab" data-toggle="tab" href="#nav_media_uploader_tab_content" role="tab" aria-controls="nav-profile" aria-selected="false">Media Library</a>
</nav>
<div class="tab-content" id="uploder-nav-tabContent">
  <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

    <div 
        id="active_global_media_uploader"
        data-upload-options='{"action":"{{ route("media.store") }}"}'
    ></div>

  </div>
  <div class="tab-pane fade show active" id="nav_media_uploader_tab_content" role="tabpanel" aria-labelledby="nav-profile-tab">
      <div class="row">
        <div class="col-md-8">
          <span class="niceScroll"  id="uploader_media_image_list_content">            

          <div class="form-group pt-3 position-relative">
              <span class="searcg_loader">
                <i class="fa fa-refresh fa-spin"></i>
              </span>
              <input placeholder="Search by Media Title" aria-describedby="SearchbyMediaTitle" class="form-control" name="uploader_media_search" type="text" value="" id="uploader_media_search"> </div>


            <ul class="row medial_uploder_image_list">


            </ul>
           </span>
        </div>
        <div class="col-md-4 my-2" id="uploader_info">
          <span class="uploader_info_main niceScroll">

            <div class="form-group text-center my-2" id="uploader_info_image">
              <i class="fa fa-refresh fa-spin" style="display: none;"></i>
              <span>
                {{ HTML::image(upload_dir_url('default/largefileicon.png'), 'picture', array('class' => 'img-thumbnail')) }}
              </span>
            </div>          

            {!! Form::open(['url' => route('update-uploder'), 'method' => 'put', 'id' => 'media_uploader_form']) !!} 
              {!! Form::hidden( 'uploader_media_id', '', ['id' => 'uploader_media_id'] ); !!}
             <div class="form-group ">
                <label for="media_direct_url">Media Url</label>
                <input class="form-control" type="text" placeholder="Media Url" readonly id="media_direct_url">   
             </div>
                
              {{ text_field([
                  'name' => 'uploader_title',
                  'title' => 'Media Title',
                  'value' => '',
                  'atts' =>  ['placeholder' => 'Media Title', 'aria-describedby' => 'MediaTitle', 'class' => 'form-control']
                ], $errors) }}

              {{ text_field([
                  'name' => 'uploader_alt',
                  'title' => 'Media alt title',
                  'value' => '',
                  'atts' =>  ['placeholder' => 'Media alt title', 'aria-describedby' => 'Mediaalttitle', 'class' => 'form-control']
                ], $errors) }}


              {{ textarea_field([
                  'name' => 'uploader_description',
                  'title' => 'Description',
                  'value' => '',
                  'atts' =>  ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control']
                ], $errors) }}

            {!! Form::close() !!}

          </span>
        </div>
      </div>
  </div>
  
</div>


        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" id="uploder_cancel" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" id="uploder_submit" type="button" >Select</button>
        </div>
      </div>
    </div>
  </div>