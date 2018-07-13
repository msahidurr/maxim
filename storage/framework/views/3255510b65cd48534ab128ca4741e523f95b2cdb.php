<?php $__env->startSection('page_heading',
trans('others.update_product_label')); ?>
<?php $__env->startSection('section'); ?>
<div class="container-fluid">
        <div class="row">
             <div class="col-md-12 ">   <!--col-md-offset-2 -->
            	<?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo e(trans('others.update_product_label')); ?></div>
                    <div class="panel-body">
                        <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                        <form class="form-horizontal" action="<?php echo e(Route('update_product_action')); ?>/<?php echo e($data->product_id); ?>" method="POST" autocomplete="off">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_code_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control  input_required" name="p_code" value="<?php echo e($data->product_code); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_name_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_name" value="<?php echo e($data->product_name); ?>">
                                        </div>
                                    </div>                         

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_description_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_description" value="<?php echo e($data->product_description); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_brand_label')); ?></label>
                                       <div class="col-md-6">
                                            <select class="form-control " name="p_brand" required value="">                   
                                                 <option value="<?php echo e($data->brand); ?>"><?php echo e($data->brand); ?></option>
                                                 <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <option value="<?php echo e($brand->brand_name); ?>"><?php echo e($brand->brand_name); ?></option>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                            </select>
                                        </div>
                                    </div>                                    

                                    <!-- <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.others_color_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="others_color" value="<?php echo e($data->others_color); ?>">
                                        </div>
                                    </div> -->

                                </div>


                                <div class="col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_erp_code_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control  input_required" name="p_erp_code" value="<?php echo e($data->erp_code); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_unit_price_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_unit_price" value="<?php echo e($data->unit_price); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_weight_qty_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_weight_qty" value="<?php echo e($data->weight_qty); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><?php echo e(trans('others.product_weight_amt_label')); ?></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="p_weight_amt" value="<?php echo e($data->weight_amt); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4"></label>
                                        <div class="col-md-6">
                                            <div class="select">
                                                <select class="form-control" type="select" name="is_active" >
                                                    <option value="<?php echo e($data->status); ?>">
                                                        <?php echo e(($data->status == 1) ? "Active" : "Inactive"); ?>

                                                    </option>
                                                    <option  value="1" name="is_active" ><?php echo e(trans('others.action_active_label')); ?></option>
                                                    <option value="0" name="is_active" ><?php echo e(trans('others.action_inactive_label')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
	                            <div class="col-md-offset-10">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        <?php echo e(trans('others.update_button')); ?>

                                	</button>
                                </div>
                            </div>
                        </form>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".selections").select2();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>