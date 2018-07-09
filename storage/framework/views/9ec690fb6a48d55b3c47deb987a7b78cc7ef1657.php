<?php $__env->startSection('page_heading', trans("others.mxp_menu_challan_boxing_list") ); ?>
<?php $__env->startSection('section'); ?>

<?php $__env->startSection('section'); ?>
    <div class="container-fluid">
    	<?php if(Session::has('erro_challan')): ?>
            <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('erro_challan') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.mxp_menu_challan_boxing_list')); ?></div>
					<div class="panel-body">			            
						<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('challan_boxing_action')); ?>">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

							<?php if(Session::has('vaildate_error_mess')): ?>
					            <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('vaildate_error_mess') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							<?php endif; ?>

							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo e(trans('others.bill_invo_no_label')); ?></label>
								<div class="col-md-6">
									<input type="text" class="form-control  input_required" name="challan_invo_no" value="<?php echo e(old('challan_invo_no')); ?>">
								</div>
							</div>
							
							<div class="form-group ">
								<div class="col-md-6 col-md-offset-7">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										<?php echo e(trans('others.search_button')); ?>

									</button>
								</div>
							</div>
							</form>

							<?php if(!empty($sentBillId)): ?>
							
							<!-- <div class="col-md-12"> -->
								<span style="font-size:15px;">Challan data for edit</span>
								<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('multiple_challan_action')); ?>">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

									<table class="table table-bordered" >
										<thead>
											<tr>
												<th>SerialNo</th>
												<th width="">Itemcode</th>
												<th width="">Size</th>
												<th width="">Quantity</th>
											</tr>
										</thead>
										<?php
										   $i=1;
										 ?>
										<?php $__currentLoopData = $sentBillId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php
							    				$itemsize = explode(',', $item->item_size);  				
							    				$qty = explode(',', $item->quantity);
							    				$itemQtyValue = array_combine($itemsize, $qty);
							    			?>
										<tbody>
											<tr>
												<td><?php echo e($i++); ?></td>
												<td><?php echo e($item->item_code); ?></td>
												<td colspan="2" class="colspan-td">
								    				<table width="100%" id="sampleTbl">
								    					<?php $__currentLoopData = $itemQtyValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $Qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								    					<?php if(empty($size)): ?>
								    					<tr>
								    						<td width="70%"></td>
											    			<td width="30%" class="aaa">
											    				<input type="hidden" name="allId[]" value="<?php echo e($item->id); ?>">
																<input type="text" class="form-control item_quantity" name="product_qty[]" value="<?php echo e($Qty); ?>">
											    			</td>
											    		</tr>
								    					<?php else: ?>
								    					<tr>
								    						<td width="70%">
								    							<input type="text" class="form-control" name="product_size" value="<?php echo e($size); ?>" disabled>
								    						</td>
											    			<td width="30%" class="aaa">
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

				<div class="panel panel-default">
					<div class="panel-heading"><?php echo e(trans('others.mxp_menu_multiple_challan_search')); ?>

					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="<?php echo e(Route('multiple_challan_search')); ?>">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

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
								<label class="col-md-4 control-label"><?php echo e(trans('others.bill_invo_no_label')); ?></label>
								<div class="col-md-6">
									<input type="text" class="form-control  input_required" name="challan_invo_nos" value="<?php echo e(old('challan_invo_no')); ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo e(trans('others.challan_no_label')); ?></label>
								<div class="col-md-6">
									<input type="text" class="form-control  input_required" name="challan_id" value="<?php echo e(old('challan_invo_no')); ?>">
								</div>
							</div>
							
							<div class="form-group ">
								<div class="col-md-6 col-md-offset-7">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
										<?php echo e(trans('others.search_button')); ?>

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