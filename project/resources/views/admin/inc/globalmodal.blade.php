<div class="modal fade" id="global_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="global_modal_label" >Danger Modal</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="data_cancel"></button>
        <button type="button" class="btn btn-outline" id="data_submit" ></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


        <div class="modal fade" id="global_media_uploader">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="global_media_upload_label"></h4>
              </div>
              <div class="modal-body">


<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#nav-home" aria-controls="home" role="tab" data-toggle="tab">Upload Files</a></li>
    <li role="presentation" class="active"><a href="#nav_media_uploader_tab_content" aria-controls="profile" role="tab" data-toggle="tab">Media Library</a></li>
  </ul>



<div class="tab-content" id="uploder-nav-tabContent">

  <div class="tab-pane" id="nav-home" role="tabpanel">

    <div 
        id="active_global_media_uploader"
        data-upload-options='{"action":"{{ route("media.store") }}"}'
    ></div>

  </div>

  <div class="tab-pane active" id="nav_media_uploader_tab_content" role="tabpanel" >
      <div class="row">
        <div class="col-md-8">
          <span class="uploader_slimScroll"  id="uploader_media_image_list_content">            

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
          <span class="uploader_info_main uploader_slimScroll">

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
                <button type="button" class="btn btn-default pull-left" id="uploder_cancel" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="uploder_submit" >Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>





