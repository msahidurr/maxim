<?php $__env->startSection('page_heading',trans('others.mxp_menu_vat_tax_list')); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

<?php if(Session::has('vat_tax_message')): ?>
    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('vat_tax_message') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>


<div class="create_form_btn" style="margin-bottom: 20px;">
    <a href="<?php echo e(Route('add_vat_tax_view')); ?>">
        <button class="btn btn-success"><?php echo e(trans('others.add_vat_tax_label')); ?></button>
    </a>
</div>


<div class="col-sm-12">
    <div class="row">
        
            <div class="input-group add-on">
              <input class="form-control" placeholder="<?php echo e(trans('others.search_placeholder')); ?>" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br>

            <?php $__env->startSection('cotable_panel_body'); ?>

            <?php if(Session::has('packet_delete_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('packet_delete_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('packet_update_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('packet_update_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
                

            
            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class=""><?php echo e(trans('others.serial_no_label')); ?></th>
                        <th class=""><?php echo e(trans('others.name_label')); ?></th>
                        
                        <th class=""><?php echo e(trans('others.status_label')); ?></th>
                        <th class=""><?php echo e(trans('others.action_label')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    <?php $__currentLoopData = $vatTaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($vattax->name); ?></td>
                                
                                
                                <td>
                                    <?php if($vattax->status == '1'): ?>
                                        <?php echo e(trans('others.action_active_label')); ?>

                                    <?php else: ?>
                                        <?php echo e(trans('others.action_inactive_label')); ?>

                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <a class="delete_id" href="<?php echo e(Route('delete_vat_tax_action')); ?>/<?php echo e($vattax->id); ?>" > <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                </td>
                            </tr>    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    
                    
                </tbody>
            </table>    
            <?php $__env->stopSection(); ?>
            <?php echo $__env->make('widgets.panel', array('header'=>true, 'as'=>'cotable'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
    </div>
</div>
            
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>