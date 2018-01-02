<?php $__env->startSection('dashboard_tab_title'); ?>
 <?php echo e($tarm_opject->edit_page_title($get_tarm)); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('dashboard_content'); ?>
    <section class="content-header">
      <h1>
        <?php echo e($tarm_opject->edit_page_title($get_tarm)); ?>

        <small>Control panel</small>
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
        
    <div class="row">
      <div class="col-md-8">

<?php echo e(heml_card_open($tarm_opject->page_icon(), $tarm_opject->edit_page_title($get_tarm))); ?>


            <div class="row">
              <div class="col-md-12">
                <!-- Start Form -->     
  
                <?php echo e($tarm_opject->tarm_edit_form_output($get_tarm, $errors)); ?>   
              
              <!-- End Form -->

              </div>
            </div>

<?php echo e(heml_card_close()); ?>


      </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>