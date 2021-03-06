@extends('layouts.dashboard')

@section('dashboard_tab_title')
Edith media | Website
@endsection

@php
  $file_type = $meta->get_post_meta($media->id, 'file_type')
@endphp


@section('dashboard_content')
    <section class="content-header">
      <h1>
        Edith
        <small>media</small>
      </h1>
       @include('admin.inc.breadcrumb')
    </section>

  <section class="content">
        @if(Session::get('error_msg'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ Session::get('error_msg') }}
        </div>

        @endif

        @if(Session::get('success_msg'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ Session::get('success_msg') }}
              </div>
        @endif
        
    <div class="row">
      <div class="col-md-12">
{{ heml_card_open('fa fa-picture-o', 'Edith media') }}
            <div class="row">
              <div class="col-md-12 text-center">                
                
                @if(is_image($file_type))

                    {{ Html::image($mediamodel->get_image_src('full', $media->id)[0], $media->post_title, array('class' => 'mw-100')) }}
                
                @elseif($file_type == 'image/x-icon')

                  {{ Html::image(upload_dir_url($media->post_content), $media->post_title, array('class' => 'mw-100')) }}

                @else

                  {{ Html::image(upload_dir_url('default/fileicon.png'), $media->post_title, array('class' => 'mw-100')) }} 

                @endif
                
              </div>
            </div>
{{ heml_card_close() }}

{{ heml_card_open('fa fa-picture-o', 'Edith media') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->
            {!! Form::open(['url' => route('media.update', $media->id), 'method' => 'put']) !!} 


              <div class="form-group ">
                  <label for="mUrl">Media Url</label>      
                  <span aria-describedby="MediaTitle" class="form-control" id="mUrl">
                    
                        @if(is_image($file_type))

                            {{ $mediamodel->get_image_src('full', $media->id)[0] }}
                        @else

                          {{ upload_dir_url($media->post_content) }} 

                        @endif


                  </span>  
              </div>

                {{ text_field([
                    'name' => 'mtitle',
                    'title' => 'Media Title',
                    'value' => $media->post_title,
                    'atts' =>  ['placeholder' => 'Media Title', 'aria-describedby' => 'MediaTitle', 'class' => 'form-control']
                  ], $errors) }}

                {{ text_field([
                    'name' => 'alt',
                    'title' => 'Media alt title',
                    'value' => $meta->get_post_meta($media->id, 'alt'),
                    'atts' =>  ['placeholder' => 'Media alt title', 'aria-describedby' => 'Mediaalttitle', 'class' => 'form-control']
                  ], $errors) }}


                {{ textarea_field([
                    'name' => 'description',
                    'title' => 'Description',
                    'value' => $meta->get_post_meta($media->id, 'description'),
                    'atts' =>  ['placeholder' => 'Description', 'aria-describedby' => 'Description', 'class' => 'form-control']
                  ], $errors) }}



                  {!! Form::submit('Update media', ['class' => 'btn bg-olive btn-flat']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>
</section>
@endsection


@section('style')

@endsection

@section('script')
  {{ Html::script(asset('public').'/admin/js/core.js', ['type' => 'text/javascript']) }}
  {{ Html::script(asset('public').'/admin/js/upload.js', ['type' => 'text/javascript']) }}
@endsection