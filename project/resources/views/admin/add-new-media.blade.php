@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')

        @if(Session::get('error_msg'))
        <div class="alert alert-danger" role="alert">
          <strong>!Error</strong> {{ Session::get('error_msg') }}
        </div>
        @endif

        @if(Session::get('success_msg'))
        <div class="alert alert-success" role="alert">
          <strong>!Success</strong> {{ Session::get('success_msg') }}
        </div>
        @endif


    <div class="row">
      <div class="col-md-8">

{{ heml_card_open('fa fa-user', 'Add New Media') }}

<div class="upload" id="media_main_uploader" data-upload-options='{"action":"{{ route("media.store") }}"}'>
  
</div>

{{ heml_card_close('Add New Media') }}

<span id="image_preview_main" style="display: none;">
{{ heml_card_open('fa fa-user', 'Add New Media') }}

<div class="image_preview  my-3">
  <div class="row" id="media_preview_append"><!-- 

    <div class="col-6">
      <div class="row my-4">
        <div class="col-md-5">
          <a href="">
            <img src="http://laravel-project.com/public/upload/17-150x150.jpg" alt="" class="rounded w-100">
          </a>
        </div>
        <div class="col-md-7">
          <div class="d-block mb-4">
            File name   : bla bla bla <br />
            File title  : bla bla bla <br />
            File alt    : bla bla bla <br />
          </div>
          <a href="#" class="btn btn btn-secondary">Edith</a>
          <a href="#" class="btn btn btn-danger">Delete</a>
        </div>
      </div>
    </div> -->

  </div>
</div>
{{ heml_card_close('Add New Media') }}
</span>

      </div>
    </div>

@endsection