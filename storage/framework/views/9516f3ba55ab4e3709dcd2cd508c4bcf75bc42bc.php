<?php $__env->startSection('page_heading',trans('others.mxp_menu_update_stocks_action')); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
		<div>
			<div>
				<div class="">
					<a href="<?php echo e(Route('stock_view')); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'info', 'value'=>trans('others.heading_add_stock_label')), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
				</div>
			</div>
			<br>
			<table class="table table-bordered">
	            <thead>
	                <tr>
                        <th><?php echo e(trans('others.serial_no_label')); ?></th>
						<th><?php echo e(trans('others.product_name_label')); ?></th>
						<th><?php echo e(trans('others.product_group_label')); ?></th>
						<th><?php echo e(trans('others.quantity_label')); ?></th>
                        <th><?php echo e(trans('others.company_name_label')); ?></th>
						<th><?php echo e(trans('others.mxp_menu_store')); ?></th>
						<th><?php echo e(trans('others.action_label')); ?></th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php ($i = 1); ?> 
		            <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($stock->product_name.' ('.$stock->packet_name.'('.$stock->packet_quantity.')	'.$stock->unit_name.'('.$stock->unit_quantity.'))'); ?></td>
							<td><?php echo e($stock->product_group); ?></td>
							<td><?php echo e($stock->quantity); ?></td>
							<td><?php echo e($stock->client_name.'('.$stock->address.')'); ?></td>

							<form role="form" action="<?php echo e(Route('update_stock_action')); ?>" method="post">

                				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                				<input type="hidden" name="id" value="<?php echo e($stock->id); ?>">

			                    <td>
									<select class="form-control input_required" name="location" required >
	                                    <option value=""><?php echo e(trans('others.option_select_location_label')); ?></option>
	                                    
	                                    <?php $__currentLoopData = $stock_states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock_state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                        <option value="<?php echo e($stock_state->id); ?>" <?php echo e(($stock->store_id == $stock_state->id)? "selected":""); ?>><?php echo e($stock_state->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
	                            </td>
	                            <td>
	                            	<input style="float: left; width: 100% !important" class="form-control btn btn-info" type="submit" value="<?php echo e(trans('others.update_button')); ?>" >
	                            </td>
			            	</form>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	        </table>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>