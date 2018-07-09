<?php $__env->startSection('page_heading','Role List'); ?>
<?php $__env->startSection('section'); ?>
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            <?php $__env->startSection('cotable_panel_title','List of Responsible people'); ?>
            <?php $__env->startSection('cotable_panel_body'); ?>

            <?php if(Session::has('role_delete_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('role_update_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>



            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-1">Serial</th>
                        <th class="col-sm-4">Role</th>
                        <th class="col-sm-4">Company Name</th>
                        <th class="col-sm-4">Status</th>
                        <th class="col-sm-2">Operation</th> 
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    <?php $__currentLoopData = $roleList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($role->name); ?></td>
                                <td><?php echo e($role->c_name); ?></td>
                                <td>
                                    <?php if($role->is_active == '1'): ?>
                                        Active
                                    <?php else: ?>
                                        Deactive
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(Route('role_update_action')); ?>/<?php echo e($role->cm_group_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Update'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                    <a href="<?php echo e(Route('role_delete_action')); ?>/<?php echo e($role->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'Delete'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                </td>
                            </tr>    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    
                    
                </tbody>
            </table>    
            <?php $__env->stopSection(); ?>
            <?php echo $__env->make('widgets.panel', array('header'=>true, 'as'=>'cotable'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
</div>
            
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>