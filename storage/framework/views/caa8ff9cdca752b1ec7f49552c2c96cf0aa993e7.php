<?php $__env->startSection('page_heading', trans("others.mxp_menu_challan_boxing_list") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
    <div class="container-fluid">
    	<?php if(Session::has('erro_challan')): ?>
            <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('erro_challan') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12 col-md-offset-0">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.mxp_menu_challan_boxing_list')); ?></div>
					<div class="panel-body">
							<?php if(!empty($bookingDetails)): ?>							
							<!-- <div class="col-md-12"> -->
								<!-- <span style="font-size:15px;padding-bottom: 15px;">Challan data for edit</span> -->
								<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('multiple_challan_action_task')); ?>">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

									<table class="table table-bordered table-striped" >
										<thead>
											<tr>
												<th>SerialNo</th>
												<th width="">ERP Code</th>
												<th width="">Item Code</th>
												<th width="">Item Size</th>
												<th width="">Item Quantity</th>
											</tr>
										</thead>
										<?php
										   $i=1;
										 ?>
										<?php $__currentLoopData = $bookingDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
							    				$itemsize = explode(',', $item->itemSize);  				
							    				$qty = explode(',', $item->quantity);
							    				$itemQtyValue = array_combine($itemsize, $qty);
							    			?>
										<tbody>
											<tr>
												<td><?php echo e($i++); ?></td>
												<td><?php echo e($item->erp_code); ?></td>
												<td><?php echo e($item->item_code); ?></td>
												<td colspan="2" class="colspan-td">
								    				<table width="100%" id="sampleTbl">
								    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								    					<?php if(empty($size)): ?>
								    					<tr>
								    						<td width="50%"></td>
											    			<td width="50%" class="aaa">
											    				<input type="hidden" name="allId[]" value="<?php echo e($item->id); ?>">
																<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>">
											    			</td>
											    		</tr>
								    					<?php else: ?>
								    					<tr>
								    						<td width="50%">
								    							<?php echo e($size); ?>

								    						</td>
											    			<td width="50%" class="aaa">
								    							<input type="hidden" name="allId[]" value="<?php echo e($item->id); ?>">
								    							<div class="question_div">
																<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>">
											    				</div>

											    			</td>
								    					</tr>
								    					<?php endif; ?>
								    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								    				</table>
								    			</td>
												
											</tr>
											
										</tbody>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</table>
								

									<div class="form-group ">
										<div class="col-md-6 col-md-offset-10">
											<button type="submit" class="btn btn-primary" id="rbutton">
												<?php echo e(trans('others.genarate_bill_button')); ?>

											</button>
										</div>
									</div>
								</form>
							<!-- </div> -->

							<?php if(!empty($multipleChallanList)): ?>
								<span style="font-size:15px;">Multiple Challan list</span>
								<table class="table table-bordered">
									<thead>
										<th>Serial No</th>
										<th>Invo no</th>
										<th>Challan no</th>
									</thead>
									<?php ($k = 1); ?>
									<?php $__currentLoopData = $multipleChallanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ChallanList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($k++); ?></td>
											<td><?php echo e($ChallanList->bill_id); ?></td>
											<td><?php echo e($ChallanList->challan_id); ?></td>	
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</table>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>