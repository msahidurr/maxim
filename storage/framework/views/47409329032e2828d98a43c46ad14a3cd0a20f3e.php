
<?php $__env->startSection('page_heading',
trans('others.add_product_label')); ?>
<?php $__env->startSection('section'); ?>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
		  rel="stylesheet">
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            	<?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo e(trans('others.add_product_label')); ?></div>
                    <div class="panel-body">                  
                        <form class="form-horizontal" action="<?php echo e(Route('add_product_action')); ?>" method="POST" autocomplete="off">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                            <div class="row">
                            	<div class="col-sm-12 col-md-6">
                            		<div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_code_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control  input_required" name="p_code" value="<?php echo e(old('p_code')); ?>" placeholder="Item code">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_name_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_name" value="<?php echo e(old('p_name')); ?>" placeholder="Item Name">
		                                </div>
		                            </div>

                         

		                            <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_description_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_description" value="<?php echo e(old('p_description')); ?>" placeholder="Description">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_brand_label')); ?></label>
		                               <div class="col-md-6">
										   		<div class="product-brand-list" style="width:80%; float: left;">
													<select class="form-control" name="p_brand" value="" style="width: 95% !important;">
														 <option value="<?php echo e(old('p_brand')); ?>"><?php echo e((!empty(old('p_brand'))) ? old('p_brand') :"Choose Brand"); ?></option>

														 <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														 <option value="<?php echo e($brand->brand_name); ?>"><?php echo e($brand->brand_name); ?></option>
														 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
											   <div class="add-brand-btn" style="width:20%; float: left; padding-top: 5px;">
												   <i class="material-icons">
													   add_circle_outline
												   </i>
											   </div>
		                                </div>

		                            </div>

		                            <!-- <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.others_color_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="others_color" value="<?php echo e(old('others_color')); ?>" placeholder="Others Color">
		                                </div>
		                            </div> -->
		                            
                            	</div>

                            	<div class="col-sm-12 col-md-6">

                            		<div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_erp_code_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control input_required" name="p_erp_code" value="<?php echo e(old('p_erp_code')); ?>" placeholder="ERP code">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_unit_price_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_unit_price" value="<?php echo e(old('p_unit_price')); ?>" placeholder="Unit Price">
		                                </div>
		                            </div>

                            		<div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_weight_qty_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_weight_qty" value="<?php echo e(old('p_weight_qty')); ?>" placeholder="Weight QTY">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-4 control-label"><?php echo e(trans('others.product_weight_amt_label')); ?></label>
		                                <div class="col-md-6">
		                                    <input type="text" class="form-control" name="p_weight_amt" value="<?php echo e(old('p_weight_amt')); ?>" placeholder="Weight AMT">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                            	<label class="col-md-4 control-label"></label>
		                                <div class="col-sm-6">
		                                    <div class="select">
		                                        <select class="form-control" type="select" name="is_active" >
		                                            <option  value="1" name="is_active" ><?php echo e(trans('others.action_active_label')); ?></option>
		                                            <option value="0" name="is_active" ><?php echo e(trans('others.action_inactive_label')); ?></option>
		                                        </select>
		                                    </div>
		                                </div>
		                            </div>

                            	</div>
                            </div>

                            

                            <div class="form-group">
	                            <div class="col-sm-offset-10 col-xs-offset-8">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        <?php echo e(trans('others.save_button')); ?>

                                	</button>
                                </div>
                            </div>
                        </form>
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