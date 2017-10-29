@extends('layouts.dashboard')

@section('dashboard_tab_title')
 {{ $tarm_opject->pate_tab_title() }}
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
      <div class="col-md-5">

{{ heml_card_open($tarm_opject->page_icon(), $tarm_opject->pate_title()) }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->           

  
                {{ $tarm_opject->tarm_form_output($errors) }}                

              
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close($tarm_opject->pate_title()) }}

      </div>
      
      <div class="col-md-7">

{{ heml_card_open('fa fa-user', 'Create Tarm') }}

            <div class="row">
              <div class="col-md-12">

                <div class="table-responsive">
                  <table class="table table-bordered" id="tarm_opject_table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Frist Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Frist Name</th>
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
            </div>

{{ heml_card_close('Add New User.') }}

      </div>
    </div>

@endsection