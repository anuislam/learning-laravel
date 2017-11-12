@extends('layouts.dashboard')

@section('dashboard_tab_title')
Admin Dashboard
@endsection


@section('dashboard_content')
    <!-- Breadcrumbs-->
    @include('admin.inc.breadcrumb')



<!-- Start datatalbe -->

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
    

{{ heml_card_open('fa fa-user', 'All Users') }}

        <div class="table-responsive">
          <table class="table table-bordered" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="{{ route('user-datatable') }}"
            tarms-data="{{ json_encode([
                            [
                              'data' => 'profile',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                              ],
                            ['data' => 'fname'],
                            ['data' => 'lname'],
                            ['data' => 'email'],
                            [
                              'data'     => 'created_at',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data'     => 'roll',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data'     => 'action',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ]
                          ]) }}"
          >
            <thead>
              <tr>
                <th width="30" class="text-center">Profile</th>
                <th>Frist Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>join At</th>
                <th>Roll</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Profile</th>
                <th>Frist Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>join At</th>
                <th>Roll</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
        </div>
{{ heml_card_close('All Users.') }}

    <!-- end datatable -->

@endsection