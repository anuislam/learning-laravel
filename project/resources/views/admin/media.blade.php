@extends('layouts.dashboard')

@section('dashboard_tab_title')
All Media | Website
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        All 
        <small>Media</small>
      </h1>
       {{ Breadcrumbs::render('allmedia') }}
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

{{ heml_card_open('fa fa-picture-o', 'All Media') }}

          <table class="table table-bordered table-hover" id="tarm_opject_table" width="100%" cellspacing="0"
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
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              </tr>
            </tfoot>
          </table>

{{ heml_card_close() }}

      </div>
    </div>
</section>
@endsection