<?php $__env->startSection('section'); ?>
           
<div class="col-sm-12 add_packet" id="demo">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-2   ">
            <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            <?php endif; ?>

            <form role="form" action="<?php echo e(Route('add_packet_action')); ?>" method="post">

                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                    <div class="form-group">
                        <label><?php echo e(trans('others.packet_name_label')); ?></label>
                        <input class="form-control input_required" type="text" name="name" value="<?php echo e(old('name')); ?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('others.quantity_label')); ?></label>
                        <input class="form-control input_required" type="text" name="quantity" value="<?php echo e(old('quantity')); ?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('others.unit_quantity_label')); ?></label>
                        <input class="form-control " type="text" name="unit_quantity" value="<?php echo e(old('unit_quantity')); ?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('others.option_select_unit_label')); ?></label>
                        <select name="unit_id" class="form-control input_required">
                            <option value=""><?php echo e(trans('others.option_select_unit_label')); ?></option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('others.status_label')); ?></label>
                        <select name="is_active" class="form-control input_required">
                            <option value="0"><?php echo e(trans('others.action_inactive_label')); ?></option>
                            <option value="1"><?php echo e(trans('others.action_active_label')); ?></option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="company_id" value="<?php echo e(Auth::user()->company_id); ?>">
                    <input type="hidden" name="group_id" value="<?php echo e($request->session()->get('group_id')); ?>">
                    <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->user_id); ?>">
                    
    
                    <div class="form-group" style="float: right; width: 60%; margin-right: 10%">
                        <input style="float: left; width: 100% !important" class="form-control btn btn-primary btn-outline" type="submit" value="<?php echo e(trans('others.add_packet_button')); ?>" >
                    </div>
            </form>
        </div>
    </div>
</div>
            
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>