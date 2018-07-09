<?php $__env->startSection('page_heading','Update Chart of Account'); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">

						<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('chart_of_acc_update_action')); ?>">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<input type="hidden" name="id" value="<?php echo e($chart_of_acc_name->chart_o_acc_head_id); ?>">

							<?php if($errors->any()): ?>
							    <div class="alert alert-danger">
							        <ul>
							            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							                <li><?php echo e($error); ?></li>
							            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							        </ul>
							    </div>
							<?php endif; ?>

							<div class="form-group">
								<label class="col-md-4 control-label">Account head name</label>
								<div class="col-md-6">
									<select class="form-control input_required" name="account_head_sub_class_name" required >
										<option value="" disabled="true">select</option>

                                        <?php if(Session::has('account_head_sub_class_name')): ?>
	                                        <?php $__currentLoopData = $acc_sub_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc_sub_clas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($acc_sub_clas->mxp_acc_head_sub_classes_id); ?>" <?php echo e(((Session::get('account_head_sub_class_name')) == $acc_sub_clas->mxp_acc_head_sub_classes_id)? 'selected' : ''); ?>><?php echo e($acc_sub_clas->head_sub_class_name); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
	                                        <?php $__currentLoopData = $acc_sub_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc_sub_clas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($acc_sub_clas->mxp_acc_head_sub_classes_id); ?>" <?php echo e(($chart_of_acc_name->mxp_acc_head_sub_classes_id == $acc_sub_clas->mxp_acc_head_sub_classes_id)? 'selected' : ''); ?>><?php echo e($acc_sub_clas->head_sub_class_name); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Account head name</label>
								<div class="col-md-6">
									<select class="form-control input_required" name="account_head_class_name" required >
										<option value="" disabled="true">select</option>

                                        <?php if(Session::has('account_head_class_name')): ?>
	                                        <?php $__currentLoopData = $acc_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc_clas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($acc_clas->mxp_acc_classes_id); ?>" <?php echo e(((Session::get('account_head_class_name')) == $acc_clas->mxp_acc_classes_id)? 'selected' : ''); ?>><?php echo e($acc_clas->head_class_name); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        	<?php $__currentLoopData = $acc_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc_clas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($acc_clas->mxp_acc_classes_id); ?>" <?php echo e(($chart_of_acc_name->mxp_acc_classes_id == $acc_clas->mxp_acc_classes_id)? 'selected' : ''); ?>><?php echo e($acc_clas->head_class_name); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Account head name</label>
								<div class="col-md-6">
									<select class="form-control input_required" name="account_head_name" required >
										<option value="" disabled="true">select</option>

                                        <?php if(Session::has('account_head_name')): ?>
                                        	<?php $__currentLoopData = $accounts_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accounts_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($accounts_head->accounts_heads_id); ?>" <?php echo e(((Session::get('account_head_name')) == $accounts_head->accounts_heads_id)? 'selected' : ''); ?>><?php echo e($accounts_head->head_name_type.'('.$accounts_head->account_code.')'); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        	<?php $__currentLoopData = $accounts_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accounts_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                            <option value="<?php echo e($accounts_head->accounts_heads_id); ?>" <?php echo e(($chart_of_acc_name->accounts_heads_id == $accounts_head->accounts_heads_id)? 'selected' : ''); ?>><?php echo e($accounts_head->head_name_type.'('.$accounts_head->account_code.')'); ?></option>
	                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-4 control-label">Account sub head name</label>
								<div class="col-md-6">
									<select class="form-control input_required" name="account_sub_head_name" required >
										<option value="" disabled="true">select</option>

                                        <?php if(Session::has('account_sub_head_name')): ?>
                                        	<?php $__currentLoopData = $accounts_sub_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accounts_sub_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            	<option value="<?php echo e($accounts_sub_head->accounts_sub_heads_id); ?>" <?php echo e(((Session::get('account_sub_head_name')) == $accounts_sub_head->accounts_sub_heads_id)? "selected":""); ?>><?php echo e($accounts_sub_head->sub_head); ?></option>
                                        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        	<?php $__currentLoopData = $accounts_sub_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accounts_sub_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            	<option value="<?php echo e($accounts_sub_head->accounts_sub_heads_id); ?>" <?php echo e(($chart_of_acc_name->accounts_sub_heads_id == $accounts_sub_head->accounts_sub_heads_id)? "selected":""); ?>><?php echo e($accounts_sub_head->sub_head); ?></option>
                                        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
                                    </select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Account class name</label>
								<div class="col-md-6">
									<input type="text" class="form-control input_required" name="chart_of_acc_name" autocomplete="off" value="<?php echo e($chart_of_acc_name->acc_final_name); ?>">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3 col-md-offset-4">
									<div class="select">
										<select class="form-control" type="select" name="isActive" >
											<option  value="1" name="isActive" <?php echo e(($chart_of_acc_name->is_active == 1)? 'selected' : ''); ?>><?php echo e(trans('others.action_active_label')); ?></option>
											<option value="0" name="isActive" <?php echo e(($chart_of_acc_name->is_active == 0) ? 'selected' : ''); ?>><?php echo e(trans('others.action_inactive_label')); ?></option>
						   				</select>
									</div>
								</div>
							</div>
							
				            <?php echo e(Session::forget('account_head_sub_class_name')); ?>

				            <?php echo e(Session::forget('account_head_class_name')); ?>

				            <?php echo e(Session::forget('account_head_name')); ?>

				            <?php echo e(Session::forget('account_sub_head_name')); ?>

				            <?php echo e(Session::forget('chart_of_acc_name')); ?>


							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										<?php echo e(trans('others.update_button')); ?>

									</button>
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