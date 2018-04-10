<?php 

function post_permalink($slug){
  return route('single_post', $slug);
}

function gym_get_header_menu($parent = NULL, $menu_id = 0){
  $sql = DB::table('menu_items');
  $current_url = rtrim(url()->current(), '/');
  $menu_html = '';
  if (is_null($parent)) {
  $sql = $sql->whereRaw('parent_id IS NULL');
  }else{
    $sql = $sql->where('parent_id', '=', (int)$parent);
  }
  $menu_data = $sql->where('menu_id', '=', (int)$menu_id)->orderBy('menu_order', 'asc')->get();

  if (empty($menu_data) === false) {
    $a1 = 0;
    foreach ($menu_data as $key => $value) {
      $activeurl = ($current_url == rtrim($value->url, '/')) ? 'active' : '';
      $active = 'class="'.$activeurl.'"'; 
      $a1++;
      $menu_html .= '<li '.$active.' ><a href="'.$value->url.'">'.$value->title.'</a>';
      $menu_html .= '<ul class="fh5co-sub-menu">'.gym_get_header_menu($value->id, $menu_id).'</ul>';

      $menu_html .= '</li>';
    }
  }
  return $menu_html;
}



//**************************************************************
// Theme Option
//**************************************************************

register_dropdown_menu('appearance',[
  'menu-title'    => 'Header Settings',
  'id'            => 'gym-header-setting',
  'capability'    => 'manage_option',
  'url'           => ['admin-page', 'gym-header-setting'],
]);

register_dropdown_menu('appearance',[
  'menu-title'    => 'Footer Settings',
  'id'            => 'gym-footer-setting',
  'capability'    => 'manage_option',
  'url'           => ['admin-page', 'gym-footer-setting'],
]);

register_dropdown_menu('appearance',[
  'menu-title'    => 'Home Settings',
  'id'            => 'gym-home-setting',
  'capability'    => 'manage_option',
  'url'           => ['admin-page', 'gym-home-setting'],
]);

register_dropdown_menu('appearance',[
  'menu-title'    => '404 page Settings',
  'id'            => '404-page',
  'capability'    => 'manage_option',
  'url'           => ['admin-page', '404-page'],
]);

register_dropdown_menu('appearance',[
  'menu-title'    => 'Contact page Settings',
  'id'            => 'contact-page',
  'capability'    => 'manage_option',
  'url'           => ['admin-page', 'contact-page'],
]);


add_admin_page([
  'id'        => 'gym-header-setting', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\header_setting',
]);


add_admin_page([
  'id'        => 'gym-footer-setting', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\footer_setting',
]);

add_admin_page([
  'id'        => 'gym-home-setting', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\home_setting',
]);

add_admin_page([
  'id'        => 'joinrequest', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\joinrequest',
]);


add_admin_page([
  'id'        => '404-page', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\not_found_page',
]);

add_admin_page([
  'id'        => 'contact-page', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\contact_us_page',
]);


crop_image_size([
  'name'    => 'header_logo', //must be give an uniq name
  'width'   => 300, 
  'height'  => 70,
  'resize'  => false,
]);

crop_image_size([
  'name'    => 'header_slider', //must be give an uniq name
  'width'   => 1920, 
  'height'  => 1080,
  'resize'  => false,
]);

crop_image_size([
  'name'    => 'trainer_avatar', //must be give an uniq name
  'width'   => 600, 
  'height'  => 700,
  'resize'  => false,
]);


crop_image_size([
  'name'    => 'blog_thumb', //must be give an uniq name
  'width'   => 500, 
  'height'  => 332,
  'resize'  => false,
]);

crop_image_size([
  'name'    => 'post_image', //must be give an uniq name
  'width'   => 1200, 
  'height'  => 300,
  'resize'  => false,
]);


register_menu([
  'menu-title'    => 'Join Request',
  'id'        => 'joinrequest',
  'menu-icon'     => 'fa-list', 
  'capability'    => 'manage_option', 
  'menu_position'   => 101, 
  'url'         => ['admin-page', 'joinrequest'],
]);

register_menu([
  'menu-title'    => 'Clasess',
  'id'        => 'Clasess',
  'menu-icon'     => 'fa-pencil-square-o', 
  'capability'    => 'manage_option', 
  'menu_position'   => 101, 
]);

//**************************************************************
// Class dropdown
//**************************************************************
    register_dropdown_menu('Clasess', [
      'menu-title'    => 'All Class',
      'id'        => 'all-Class', //uniq
      'url'         => ['all-posts', 'class-schedule'], //route
      'capability'    => 'manage_option', //uniq
    ]);

    register_dropdown_menu('Clasess', [
      'menu-title'    => 'Add New Class',
      'id'        => 'add-new-class', //uniq
      'url'         => ['create_post_type', 'class-schedule'], //route
      'capability'    => 'manage_option', //uniq
    ]);

    register_dropdown_menu('Clasess', [
      'menu-title'    => 'Class Category',
      'id'        => 'class-category', //uniq
      'url'         => ['create-tarms', 'class-cat'], //route
      'capability'    => 'manage_option', //uniq
    ]);



register_menu([
  'menu-title'    => 'Program',
  'id'        => 'program',
  'menu-icon'     => 'fa-pencil-square-o', 
  'capability'    => 'manage_option', 
  'menu_position'   => 101, 
]);

    register_dropdown_menu('program', [
      'menu-title'    => 'All Programs',
      'id'        => 'all-program', //uniq
      'url'         => ['all-posts', 'program'], //route
      'capability'    => 'manage_option', //uniq
    ]);    

    register_dropdown_menu('program', [
      'menu-title'    => 'Add new Program',
      'id'        => 'add-new-program', //uniq
      'url'         =>  ['create_post_type', 'program'], //route
      'capability'    => 'manage_option', //uniq
    ]);

register_menu([
  'menu-title'    => 'Event',
  'id'            => 'event',
  'menu-icon'     => 'fa-pencil-square-o', 
  'capability'    => 'manage_option', 
  'menu_position' => 106, 
]);

    register_dropdown_menu('event', [
      'menu-title'    => 'All Events',
      'id'            => 'all-event', //uniq
      'url'           => ['all-posts', 'event'], //route
      'capability'    => 'manage_option', //uniq
    ]);    

    register_dropdown_menu('event', [
      'menu-title'    => 'Add new event',
      'id'            => 'add-new-program', //uniq
      'url'           =>  ['create_post_type', 'event'], //route
      'capability'    => 'manage_option', //uniq
    ]);



register_menu([
  'menu-title'    => 'Trainer',
  'id'        => 'trainer',
  'menu-icon'     => 'fa-list', 
  'capability'    => 'manage_option', 
  'menu_position'   => 105, 
]);


    register_dropdown_menu('trainer', [
      'menu-title'    => 'All Trainer',
      'id'        => 'all-trainer', //uniq
      'url'         => ['all-posts', 'trainer'], //route
      'capability'    => 'manage_option', //uniq
    ]);    

    register_dropdown_menu('trainer', [
      'menu-title'    => 'Add new Trainer',
      'id'        => 'add-new-trainer', //uniq
      'url'         =>  ['create_post_type', 'trainer'], //route
      'capability'    => 'manage_option', //uniq
    ]);


//**************************************************************
// Register post type
//**************************************************************

register_post_type([
  'id'        => 'event', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\Event', //opject name
]);

register_post_type([
  'id'        => 'class-schedule', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\add_new_class', //opject name
]);
register_post_type([
  'id'        => 'program', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\program', //opject name
]);

register_post_type([
  'id'        => 'trainer', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\trainer', //opject name
]);

register_tarm([
  'id'          => 'class-cat', //uniq
  'class'       => 'Modules\Gymwebsite\Entities\class_cat',
]);




Shortcode::add('pricing_table', function($atts, $content, $name){
  $a = Shortcode::atts(array(
    'plan' => '',
    'price' => '',
    'month' => '',
    'usd' => '$',
    'desc' => '',
    'button' => 'btn-default',
    'select' => 'btn-default',
    ),
    $atts
  );
    ob_start(); ?>

      <div class="col-md-3 animate-box">
        <div class="price-box animate-box">
          <h2 class="pricing-plan"><?php echo @$a['plan'] ?></h2>
          <div class="price"><sup class="currency"><?php echo @htmlspecialchars($a['usd']) ?></sup><?php echo @$a['price'] ?><small>/<?php echo @$a['month'] ?></small></div>
          <p><?php echo @$a['desc'] ?></p>
          <ul class="classes">
            <?php echo Shortcode::compile($content); ?>
          </ul>
          <a href="#" class="btn <?php echo @$a['button'] ?>">Select Plan</a>
        </div>
      </div>

    <?php
    return ob_get_clean();
});


Shortcode::add('pricing_item', function($atts, $content, $name) 
{
 $a = Shortcode::atts(array(
  'color' => ''
  ), $atts);
  
  return '<li  class="'.$a['color'].'" >'.$content.'</li>';
});


register_page_template([
  'name' => 'About Us',
  'path' => 'gymwebsite::aboutus',
]);

register_page_template([
  'name' => 'Contact Us',
  'path' => 'gymwebsite::ContactUs',
]);

register_page_template([
  'name' => 'Classes',
  'path' => 'gymwebsite::Classes',
]);

register_page_template([
  'name' => 'Schedule',
  'path' => 'gymwebsite::Schedule',
]);

register_page_template([
  'name' => 'Trainers',
  'path' => 'gymwebsite::Trainers',
]);