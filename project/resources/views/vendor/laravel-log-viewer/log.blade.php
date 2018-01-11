@extends('layouts.dashboard')


@section('dashboard_tab_title')
Laravel Log Viewer
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        Log
        <small>Files</small>
      </h1>
       {{ Breadcrumbs::render('logfile') }}
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

  {{ heml_card_open('fa fa-file-code-o', 'Laravel Log Viewer') }}
<div class="row">
  <div class="col-sm-12">

    @if($current_file)
      <a href="?dl={{ base64_encode($current_file) }}" class="btn bg-purple btn-flat" ><span class="glyphicon glyphicon-download-alt"></span>
        Download file</a>

      <a 
        id="delete-log" 
        href="?del={{ base64_encode($current_file) }}" 
        class="btn bg-orange btn-flat margin"
        data-title="Delete log file"
        data-message="Are you sure you want to delete log file?"
        cancel_text="Cacel"
        submit_text="Delete"
        ><span
            class="glyphicon glyphicon-trash"></span> Delete file</a>
      @if(count($files) > 1)
        <a 
        id="delete-all-log" 
        href="?delall=true" 
        class="btn bg-maroon btn-flat"
        data-title="Delete log file"
        data-message="Are you sure you want to delete all log file?"
        cancel_text="Cacel"
        submit_text="Delete"
        ><span class="glyphicon glyphicon-trash"></span> Delete all files</a>
      @endif
    @endif

  </div>
</div>

  <div class="row" style="padding:15px 0;">
    <div class="col-sm-2">
      <div class="list-group">
        @foreach($files as $file)
          <a href="?l={{ base64_encode($file) }}"
             class="list-group-item @if ($current_file == $file) llv-active @endif">
            {{$file}}
          </a>
        @endforeach
      </div>
    </div>
    <div class="col-sm-10 table-container">
      @if ($logs === null)
        <div>
          Log file >50M, please download it.
        </div>
      @else
        <table class="table table-bordered table-hover" id="table-log" width="100%" cellspacing="0" >
          <thead>
            <tr>
              <th>Level</th>
              <th>Context</th>
              <th>Date</th>
              <th>Content</th>
            </tr>
          </thead>
          <tbody>

            @foreach($logs as $key => $log)
              <tr data-display="stack{{{$key}}}">
                <td class="text-{{{$log['level_class']}}}"><span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign"
                                                                 aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                <td class="text">{{$log['context']}}</td>
                <td class="date">{{{$log['date']}}}</td>
                <td class="text">
                  @if ($log['stack']) <a class="pull-right expand btn btn-default btn-xs"
                                         data-display="stack{{{$key}}}"><span
                        class="glyphicon glyphicon-search"></span></a>@endif
                  {{{$log['text']}}}
                  @if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif
                  @if ($log['stack'])
                    <div class="stack" id="stack{{{$key}}}"
                         style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                    </div>@endif
                </td>
              </tr>
            @endforeach

          </tbody>
          <tfoot>
            <tr>
              <th>Level</th>
              <th>Context</th>
              <th>Date</th>
              <th>Content</th>
            </tr>
           </tfoot>
         </table>
      @endif      
    </div>
  </div>
  {{ heml_card_close() }}

</section>
@endsection



@section('script')
<script>
  $(document).ready(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [1, 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $('#delete-log, #delete-all-log').click(function (e) {
      e.preventDefault();
      var current_tag = $(this);
      open_modal({
          title: String(current_tag.attr('data-title')),
          message: String(current_tag.attr('data-message')),
          cancel_text: String(current_tag.attr('cancel_text')),
          close_icon:  String('fa-times'),
          submit_text: String(current_tag.attr('submit_text')),
          popup_type: String('modal-danger'),
          on_submit: {
              type: 'url',
              url: String(current_tag.attr('href')),
              parameters: null
             },
      });
    });
  });
</script>
@endsection
