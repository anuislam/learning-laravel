@extends('layouts.dashboard')

@section('dashboard_tab_title')
 {{ $tarm_opject->pate_tab_title() }}
@endsection



@section('dashboard_content')
    <section class="content-header">
      <h1>
        {{$tarm_opject->pate_title()}}
        <small>{{$tarm_opject->pate_sub_title()}}</small>
      </h1>
       {{ Breadcrumbs::render('tarms', $tarm_type_name) }}
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
      <div class="col-md-5">

{{ heml_card_open($tarm_opject->page_icon(), $tarm_opject->pate_title()) }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     

  
                {{ $tarm_opject->tarm_form_output($errors) }}                

              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close() }}

      </div>
      
      <div class="col-md-7">

{{ heml_card_open('fa fa-user', $tarm_opject->pate_title()) }}

            <div class="row">
              <div class="col-md-12">


{{ $tarm_opject->all_tarms_out_put($errors) }}


              </div>
            </div>

{{ heml_card_close() }}

      </div>
    </div>
</section>
@endsection