<?php $__env->startSection('page_heading', trans("others.new_mrf_create_label")); ?>
<?php $__env->startSection('section'); ?>
<style type="text/css">
	.showMrfList{
		background-color: #f9f9f9;
		border-radius: 10px;
		box-sizing: border-box;
		box-shadow: 0 10px 20px rgba(0,0,0,0.10), 0 6px 6px rgba(0,0,0,0.15);
		z-index: 999;
	}
	.mrfControl{
		text-align: left;
		width:30%;
		display: inline-block;
	}
	.mrfControl .all{
		display: inline;
		float: left;
		width: 10%;
	}

	@media (max-width: 300px) {
		.mrfControl{
		text-align: left;
		width:40%;
		display: inline-block;
	}
	.mrfControl .all{
		display: inline;
		float: left;
		width: 25%;
	}
	}
</style>

    <div class="container-fluid">
    	<?php if(Session::has('erro_challan')): ?>
            <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('erro_challan') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12 col-md-offset-0">
				<?php if(!empty($MrfDetails)): ?>
					<div class="panel showMrfList">
						<div class="panel-heading">MRP list</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered">
								<thead>
									<th>#</th>
									<th>Booking Id</th>
									<th>MRF Id</th>
									<th>Action</th>
								</thead>
								<tbody>
									<td>1</td>
									<td>BK-011822-CL-001</td>
									<td>MRF-087655-001</td>
									<td>
										<button type="submit" name="mrf_view" class="btn btn-success">
											View
										</button>
									</td>
								</tbody>
							</table>
						</div>
					</div>
				<?php endif; ?>
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.new_mrf_create_label')); ?></div>
					<div class="panel-body aaa">
							<?php if(!empty($bookingDetails)): ?>	
								<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('mrf_action_task')); ?>">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="mrfControl">
											<div class="all">
												<input type="checkbox" name="selectAllMrf" id="selectAllMrf" class="">
											</div>
											<div class="all">
												<label for="selectAllMrf">All</label>
											</div>
											<div class="all">
												<input type="checkbox" name="editMrf" id="editMrf">
											</div>
											<div class="all">
												<label for="editMrf">Edit</label>
											</div>
										</div>
									</div>

									<table class="table table-bordered table-striped" >
										<thead>
											<tr>
												<th width="4%">#</th>
												<th width="">ERP Code</th>
												<th width="">Item Code</th>
												<th width="">Item Size</th>
												<th width="">Item Quantity</th>
												<th>MRF QTY</th>
											</tr>
										</thead>
										<?php
										   $i=1;
										 ?>
										<?php $__currentLoopData = $bookingDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
							    				$itemsize = explode(',', $item->item_size);  				
							    				$qty = explode(',', $item->item_quantity);
							    				$itemQtyValue = array_combine($itemsize, $qty);
							    			?>
										<tbody>
											<tr>
												<td>
													<input type="checkbox" name="selectAll" id="" class=" checkbox checkbox-primary">
												</td>
												<td><span><?php echo e($item->erp_code); ?></span></td>
												<td><span><?php echo e($item->item_code); ?></span></td>
												<td colspan="3" class="colspan-td">
								    				<table width="100%" id="sampleTbl">
								    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									    					<?php if(empty($size)): ?>
										    					<tr>
										    						<td width="50%"></td>
													    			<td width="50%" class="aaa">
													    				<input type="hidden" name="allId[]" value="<?php echo e($item->id); ?>">
																		<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>" >
													    			</td>
													    			<td></td>
													    		</tr>
									    					<?php else: ?>
										    					<tr>
										    						<td width="40%">
										    							<?php echo e($size); ?>

										    						</td>
													    			<td width="30%" class="aaa">
										    							<input type="hidden" name="allId[]" value="<?php echo e($item->id); ?>">
										    							<div class="question_div">
																			<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>">
													    				</div>

													    			</td>
													    			<td width="30%">
													    				<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>" disabled="true">
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
												<?php echo e(trans('others.create_button_lable')); ?>

											</button>
										</div>
									</div>
								</form>
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