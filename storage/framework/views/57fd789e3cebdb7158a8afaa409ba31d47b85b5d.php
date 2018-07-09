<?php $__env->startSection('section'); ?>
           
<div class="col-sm-12" id="demo">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            <?php endif; ?>

            <?php if(Session::has('new_user_create')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_user_create') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            

            <form role="form" action="<?php echo e(Route('create_user_action')); ?>" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


                <div class="form-group">
                    <select class="form-control input_required" name="company_id" id="companyId" >
                       <option value="">Select Company</option>    
                        
                        <?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <option value="<?php echo e($company->id); ?>">
                                    <?php echo e($company->name); ?>

                                </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control input_required" name="role_id" id="roleId" onchange="getPermission(this)"  disabled>
                        <option value="">Select Role</option>
                    </select>
                </div>


                <div class="form-group">
                    <input class="form-control input_required" type="text" name="personal_name" value="<?php echo e(old('personal_name')); ?>" placeholder="Employee Name"  >
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="personal_phone_number" value="<?php echo e(old('personal_phone_number')); ?>" placeholder="Personal Phone Number"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="employee_address" value="<?php echo e(old('employee_address')); ?>" placeholder="Employee Address"  >
                </div>                

                <div class="form-group">
                    <input class="form-control input_required" type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required="email">
                </div>

                <div class="form-group">
                        <input type="password" class="form-control input_required" name="password" value="" placeholder="Password">
                </div>

                <div class="form-group">
                        <input type="password" class="form-control input_required" name="password_confirmation" value="" placeholder="Password Confirmation">
                </div>

               
                <div class="form-group">
                    <select class="form-control input_required" name="is_active" >
                        <option value="1">Active</option>   
                        <option value="0">Deactive</option>
                    </select>
                </div>

                


                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="Add User" >
                </div>
            </form>
        </div>
    </div>
</div>
            
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>