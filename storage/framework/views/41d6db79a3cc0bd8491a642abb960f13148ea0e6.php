<?php $__env->startSection('page_heading',trans('others.mxp_menu_company_list')); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

<?php if(Session::has('journal_posting_status')): ?>
    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('journal_posting_status') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>


<div class="create_form_btn" style="margin-bottom: 20px;">
    <a href="<?php echo e(Route('journal_posting_form_view')); ?>">
        <button class="btn btn-success"><?php echo e(trans('others.add_journal_posting_label')); ?></button>
    </a>
</div>


<div class="col-sm-12">
    <div class="row">


        <?php $__env->startSection('cotable_panel_body'); ?>

            <?php if(Session::has('role_delete_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('role_update_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('company_delete')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('company_delete') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>


            <div class="input-group add-on">
              <input class="form-control" placeholder="<?php echo e(trans('others.search_placeholder')); ?>" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br>




            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        
                        <th>SL</th>
                        <th>Date</th>
                        <th>Particulars</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
            <?php $__env->stopSection(); ?>
            <?php echo $__env->make('widgets.panel', array('header'=>true, 'as'=>'cotable'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>