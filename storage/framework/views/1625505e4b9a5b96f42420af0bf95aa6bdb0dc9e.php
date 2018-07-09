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

            <?php if(Session::has('new_role_create')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_role_create') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <form role="form" action="<?php echo e(Route('add_role_action')); ?>" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" required>
                
               

                <div class="form-group input_required">
                    <select style="width:100%" name="company_ids[]" class="selections " multiple="multiple">
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($company->id); ?>" placeholder="Select company" required><?php echo e($company->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <input class="form-control input_required" type="text" name="role_name" value="<?php echo e(old('role_name')); ?>" placeholder="Role Name" required>
                </div>

                <div class="form-group">
                    <select class="form-control input_required" name="is_active" required >
                        <option value="0">Not Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>

                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="Add Role" >
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