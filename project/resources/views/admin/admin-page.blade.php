@extends('layouts.dashboard')

@php
$setting = $page->page_setting();
@endphp

@section('dashboard_tab_title')
{{ $setting['page_title'] }}
@endsection


@section('dashboard_content')
    <section class="content-header">
      <h1>
        {{ $setting['page_title'] }}
        <small>{{ $setting['page_sub_title'] }}</small>
      </h1>
       {{ Breadcrumbs::render('adminpage', $setting['page_title']) }}
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

  {{ $page->page_content_output($errors) }}

</section>
@endsection
