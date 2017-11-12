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
      <div class="col-md-12">

{{ heml_card_open('fa fa-picture-o', 'All Media') }}

        <div class="table-responsive">
          <table class="table table-bordered" id="tarm_opject_table" width="100%" cellspacing="0"
            tarms-url="{{ route('media_datatable') }}"
            tarms-data="{{ json_encode([
                            [
                              'data' => 'image',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                              ],
                            ['data' => 'post_title'],
                            ['data' => 'file_type'],
                            ['data' => 'author_name'],
                            [
                              'data' => 'post_status',
                              'searchable' => 'false',
                              'orderable'  => 'false',
                            ],
                            [
                              'data' => 'created_at',
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
                <th width="150" class="text-center">Image</th>
                <th>Media Title</th>
                <th>File Type</th>
                <th>Author</th>
                <th>Media Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              </tr>
            </tfoot>
          </table>
        </div>

{{ heml_card_close('All Media') }}

      </div>
    </div>

@endsection