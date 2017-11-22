@extends('layouts.dashboard')

@section('dashboard_tab_title')
Add New Media | Website
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        Add New 
        <small>Media</small>
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
      <div class="col-md-8">

{{ heml_card_open('fa fa-user', 'Add New Media') }}

<div class="upload" id="media_main_uploader" data-upload-options='{"action":"{{ route("media.store") }}"}'>
  
</div>

{{ heml_card_close('Add New Media') }}

<span id="image_preview_main" style="display: none;">
{{ heml_card_open('fa fa-user', 'Add New Media') }}

<div class="image_preview  my-3">
  <div class="row" id="media_preview_append">

  </div>
</div>
{{ heml_card_close() }}
</span>

      </div>
    </div>
</section>
@endsection


@section('style')

<!-- custom style -->

@endsection

@section('script')
  {{ Html::script(asset('public').'/admin/js/upload.js', ['type' => 'text/javascript']) }}
@endsection