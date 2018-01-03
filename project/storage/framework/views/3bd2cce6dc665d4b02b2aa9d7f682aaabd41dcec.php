<?php
$setting = $page->page_setting();
?>

<?php $__env->startSection('dashboard_tab_title'); ?>
<?php echo e($setting['page_title']); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('dashboard_content'); ?>
    <section class="content-header">
      <h1>
        <?php echo e($setting['page_title']); ?>

        <small><?php echo e($setting['page_sub_title']); ?></small>
      </h1>
       <?php echo $__env->make('admin.inc.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>

  <section class="content">
    <?php if(Session::get('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Error!</h4>
      <?php echo e(Session::get('error_msg')); ?>

    </div>

    <?php endif; ?>

    <?php if(Session::get('success_msg')): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo e(Session::get('success_msg')); ?>

      </div>
    <?php endif; ?>

  <?php echo e($page->page_content_output($errors)); ?>


</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>