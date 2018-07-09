<?php $__env->startSection('section'); ?>
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            
            <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            <?php endif; ?>
           
            

            <form role="form" action="<?php echo e(Route('company_user_update_action')); ?>" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="user_id" value="<?php echo e($selectedUser->user_id); ?>">
                
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="personal_name" value="<?php echo e($selectedUser->name); ?>" disabled>
                </div>

                <div class="form-group">
                    <select class="form-control input_required" name="roleId" >
                        <option value=""><?php echo e(trans('others.select_role_option_label')); ?></option>
                        <?php $__currentLoopData = $roleList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if($selectedUser->user_role_id == $role->id): ?> <?php echo e('selected'); ?> <?php endif; ?> value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <input class="form-control input_required" type="text" name="personal_name" value="<?php echo e($selectedUser->first_name); ?>" placeholder="<?php echo e(trans('others.employee_name_label')); ?>">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="personal_phone_number" value="<?php echo e($selectedUser->phone_no); ?>" placeholder="<?php echo e(trans('others.personal_phone_number_label')); ?>">
                </div>

                <div class="form-group">
                    <input class="form-control input_required" type="text" name="employee_address" value="<?php echo e($selectedUser->address); ?>" placeholder="<?php echo e(trans('others.employee_address_label')); ?>">
                </div>



                <div class="form-group">
                    <input class="form-control input_required" type="email" name="email" value="<?php echo e($selectedUser->email); ?>" placeholder="<?php echo e(trans('others.enter_email_address')); ?>" required="email">
                </div>

                <div class="form-group">
                        <input type="password" class="form-control input_required" name="password" value="" placeholder="Password<?php echo e(trans('others.enter_password')); ?>">
                </div>

                

                

                <div class="form-group">
                    <select class="form-control input_required" name="is_active">
                        
                        <option value="0"><?php echo e(trans('others.action_inactive_label')); ?></option>
                        <option <?php if($selectedUser->active_user == 1): ?> <?php echo e('selected'); ?> <?php endif; ?> value="1"><?php echo e(trans('others.action_active_label')); ?></option>
                    </select>
                </div>

                


                <div class="form-group">
                    <input class="form-control  btn btn-primary btn-outline" type="submit" value="Update User<?php echo e(trans('others.mxp_menu_create_user')); ?>" >
                </div>
            </form>
        </div>
    </div>
</div>
            
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>