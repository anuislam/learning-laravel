@extends('layouts.dashboard')

@section('dashboard_tab_title')
Create Tarm
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
      <div class="col-md-6">

{{ heml_card_open('fa fa-user', 'Create Tarm') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->
            {!! Form::open(['url' => route('stor-user'), 'method' => 'POST']) !!} 



                  {!! Form::submit('Add New User', ['class' => 'btn btn-primary']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Add New User.') }}

      </div>
      
      <div class="col-md-6">

{{ heml_card_open('fa fa-user', 'Create Tarm') }}

            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->
            {!! Form::open(['url' => route('stor-user'), 'method' => 'POST']) !!} 



                  {!! Form::submit('Add New User', ['class' => 'btn btn-primary']) !!} 

              {!! Form::close() !!}
              <!-- End Form -->

              </div>
            </div>

{{ heml_card_close('Add New User.') }}

      </div>
    </div>

@endsection