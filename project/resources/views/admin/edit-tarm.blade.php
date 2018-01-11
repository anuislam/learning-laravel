@extends('layouts.dashboard')

@section('dashboard_tab_title')
 {{ $tarm_opject->edit_page_title($get_tarm) }}

@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        {{$tarm_opject->edit_page_title($get_tarm)}}
        <small>Control panel</small>
      </h1>
       {{ Breadcrumbs::render('edit-tarm', $get_tarm) }}
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

{{ heml_card_open($tarm_opject->page_icon(), $tarm_opject->edit_page_title($get_tarm)) }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     
  
                {{ $tarm_opject->tarm_edit_form_output($get_tarm, $errors) }}   
              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>
</section>

@endsection