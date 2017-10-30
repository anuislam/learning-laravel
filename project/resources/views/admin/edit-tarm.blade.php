@extends('layouts.dashboard')

@section('dashboard_tab_title')
 {{ $tarm_opject->edit_page_title($get_tarm) }}
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

{{ heml_card_open($tarm_opject->page_icon(), $tarm_opject->edit_page_title($get_tarm)) }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     
  
                {{ $tarm_opject->tarm_edit_form_output($get_tarm, $errors) }}   
              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close($tarm_opject->edit_page_footer_title($get_tarm)) }}

      </div>
    </div>

@endsection