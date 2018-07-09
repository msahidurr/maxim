<?php $__env->startSection('page_heading',trans('others.heading_update_role_label')); ?>
<?php $__env->startSection('section'); ?>
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            <?php endif; ?>


            
            <form role="form" action="<?php echo e(Route('role_update_action')); ?>/" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <input type="hidden" name="cm_group_id" value="<?php echo e($companysAllRoles[0]->cm_group_id); ?>">

                <div class="form-group">
                    <select style="width:100%" name="company_ids[]" class="selections" multiple="multiple">
                        <option value=""><?php echo e(trans('others.select_company_option_label')); ?></option>
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($company->id); ?>" <?php echo e((in_array($company->id, $onlyRoleCompanys)? 'selected':'')); ?>><?php echo e($company->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>


               


                <div class="form-group">
                    <input class="form-control" type="text" name="role_name" value="<?php echo e($companysAllRoles[0]->roleName); ?>" placeholder="<?php echo e($companysAllRoles[0]->roleName); ?>" required>
                </div>

                <div class="form-group">
                    <select class="form-control" name="is_active" required>
                        <option value="1" <?php echo e(($companysAllRoles[0]->is_active == 1)? 'selected' : ''); ?>><?php echo e(trans('others.action_active_label')); ?></option>
                        <option value="0" <?php echo e(($companysAllRoles[0]->is_active == 0)? 'selected' : ''); ?>><?php echo e(trans('others.action_inactive_label')); ?></option>
                </div>

                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="<?php echo e(trans('others.update_button')); ?>" >
                </div>
            </form>
        </div>
    </div>
</div>
   

<script type="text/javascript">
    $(".selections").select2();
</script>         
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>