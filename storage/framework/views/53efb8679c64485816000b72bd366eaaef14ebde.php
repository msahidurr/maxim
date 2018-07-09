<?php $__env->startSection('page_heading','User List'); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

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
              <input class="form-control" placeholder="Search" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br>

            

            
            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class="">Serial</th>
                        <th class="">Name</th>
                        <th class="">Phone</th>
                        <th class="">Description</th>
                        <th class="">Address</th>
                        <th class="">Is Active</th>
                        <th class="">Take Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    <?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($company->name); ?></td>
                                <td><?php echo e($company->phone); ?></td>
                                <td><?php echo e($company->description); ?></td>
                                <td><?php echo e($company->address); ?></td>
                                
                                <td>
                                    <?php if($company->is_active == '1'): ?>
                                        Active
                                    <?php else: ?>
                                        Deactive
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(Route('update_company_acc_view')); ?>/<?php echo e($company->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Update'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                    <a class="delete_id" href="<?php echo e(Route('delete_company_acc_action')); ?>/<?php echo e($company->id); ?>" > <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'Delete&nbsp;'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
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