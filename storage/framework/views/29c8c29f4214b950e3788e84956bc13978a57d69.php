<?php $__env->startSection('page_heading','Page Header'); ?>
<!-- trans('others.mxp_menu_add_new_role')) -->

<!-- <style type="text/css">
	.panel-body{
		-webkit-box-shadow: -40px 54px 201px -200px rgba(0,0,0,0.75);
-moz-box-shadow: -40px 54px 201px -200px rgba(0,0,0,0.75);
box-shadow: -40px 54px 201px -200px rgba(0,0,0,0.75);
Copy Text
	}
</style> -->
<?php $__env->startSection('section'); ?>
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
                    <!-- <div class="panel-heading"><?php echo e(trans('others.add_party_label')); ?></div> -->
                    	<div class="panel-body">
                    		<form class="" action="<?php echo e(Route('page_header_action')); ?>" role="form" method="POST" >
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                    		<div class="row">
                    			<div class="col-md-4">
                    				<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_title_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_title" value="<?php echo e(old('party_id')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_color_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_color" value="<?php echo e(old('party_id')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_address1_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_addres1" value="<?php echo e(old('party_id')); ?>">
                                   	    </div>
                                	</div>
                    			</div>
                    			<div class="col-md-4">

                    				<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_fontsize_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_fontsize" value="<?php echo e(old('party_id')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_logo_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_logo" value="<?php echo e(old('he_logo')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_address2_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="header_address2" value="<?php echo e(old('header_address2')); ?>">
                                   	    </div>
                                	</div>
                    			</div>
                    			<div class="col-md-4">

                    				<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_font_style_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_font_style" value="<?php echo e(old('he_font_style')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_logo_aligment_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_logo_aligment" value="<?php echo e(old('he_logo_aligment')); ?>">
                                   	    </div>
                                	</div>

                                	<div class="form-group">
	                                    <label class="control-label"><?php echo e(trans('others.header_address3_label')); ?></label>
	                                    <div class="">
	                                        <input type="text" class="form-control" name="he_address3" value="<?php echo e(old('he_address3')); ?>">
                                   	    </div>
                                	</div>
                    			</div>

                    			<div class="form-group">
                                    <div class="col-md-3 pull-right" style="padding-right:40px;padding-top:20px;">
                                        <button type="submit" class="btn btn-primary form-control" style="margin-right: 15px;">
                                            <?php echo e(trans('others.save_button')); ?>

                                        </button>
                                    </div>
                               </div>
                    		</div>
                           </form>                    		
                    	</div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>