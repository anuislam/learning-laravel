<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('post', function ($breadcrumbs, $data) {
	$firstdata = ucfirst($data);
    $breadcrumbs->push($firstdata, route('create_post_type', $data));
    $breadcrumbs->push($firstdata, route('all-posts', $data));
});

Breadcrumbs::register('add_new_post', function ($breadcrumbs, $data) {
	$firstdata = ucfirst($data);
    $breadcrumbs->push($firstdata, route('create_post_type', $data));
    $breadcrumbs->push('Add new '. $firstdata, route('create_post_type', $data));
});

Breadcrumbs::register('edit_post', function ($breadcrumbs, $data) {
	$firstdata = ucfirst($data->post_title);
	$post_type = ucfirst($data->post_type);
    $breadcrumbs->push($post_type, route('create_post_type', $data->post_type));
    $breadcrumbs->push($firstdata, route('edit_post_type', [$data->id, $data->post_type]));
});


//**************************************************************
// create tarms Breadcrumbs
//**************************************************************

Breadcrumbs::register('tarms', function ($breadcrumbs, $data) {
	$firstdata = 'Category';
	if (is_null($data) === false): 
	  $firstdata = ucfirst($data);
	endif ;
	
    $breadcrumbs->push('Add new '.$firstdata, route('create-tarms', $data));
    $breadcrumbs->push($firstdata, route('all-posts', $data));
});

Breadcrumbs::register('edit-tarm', function ($breadcrumbs, $data) {
	$data = json_decode(json_encode($data),true);
	$tarmstype = ucfirst($data['tarm-type']);	
	$firstdata = ucfirst($data['tarm-name']);	
    $breadcrumbs->push('Edit '.$tarmstype, route('edit-tarm', [$data['id'],($data['tarm-type'] == 'category') ? NULL : $data['tarm-type']]));
    $breadcrumbs->push($firstdata, '');
});


Breadcrumbs::register('media', function ($breadcrumbs) {
    $breadcrumbs->push('Media', route('media.index'));
    $breadcrumbs->push('Add New Media', route('media.create'));
});


Breadcrumbs::register('allmedia', function ($breadcrumbs) {
    $breadcrumbs->push('Media', route('media.index'));
    $breadcrumbs->push('All Media', route('media.create'));
});

Breadcrumbs::register('adminpage', function ($breadcrumbs, $data) {
    $breadcrumbs->push($data, '');
});

Breadcrumbs::register('addnewuser', function ($breadcrumbs) {
    $breadcrumbs->push('User', route('user.create'));
    $breadcrumbs->push('Add New User', '');
});

Breadcrumbs::register('alluser', function ($breadcrumbs) {
    $breadcrumbs->push('User', route('all-users'));
    $breadcrumbs->push('All User', '');
});

Breadcrumbs::register('yourprofile', function ($breadcrumbs) {
    $breadcrumbs->push('User', route('user.index'));
    $breadcrumbs->push('Your Profile', '');
});

Breadcrumbs::register('logfile', function ($breadcrumbs) {
    $breadcrumbs->push('Log', route('log_edit'));
    $breadcrumbs->push('Log File', '');
});

do_action('load_breadcrumbs');