<?php $__env->startSection('page_heading','Product List'); ?>
<!-- trans('others.mxp_menu_add_new_role')) -->
<?php $__env->startSection('section'); ?>
<style type="text/css">
	.top-btn-pro{
		padding-bottom: 15px;
	}
    .td-pad{
        padding-left: 15px;
    }
</style>

 <div class="col-sm-3 top-btn-pro">
    <a href="<?php echo e(Route('add_product_view')); ?>" class="btn btn-success form-control">Add Product </a>
   </div>

<div class="col-sm-12">
    <!-- <div class="row"> -->

                <?php if(Session::has('new_product_create')): ?>
                    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_product_create') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?> 
                <?php if(Session::has('new_product_delete')): ?>
                    <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('new_product_delete') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
                <?php if(Session::has('update_product_create')): ?>
                    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('update_product_create') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>            
            <!-- <div class="input-group add-on">
              <input class="form-control" placeholder="Search<?php echo e(trans('others.search_placeholder')); ?>" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br> -->

            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class="">Item Code</th>
                        <th class="">Item Name</th>
                        <th class="">Description</th>
                        <th class="">Brand</th>
                        <th class="">ERP Code</th>
                        <th class="">Unit Price</th>
                        <th class="">Weight Qty</th>
                        <th class="">Weight Amt</th>
                        <th class="">Description -1</th>
                        <th class="">Action</th>
                        <!-- <th class="">Description -2</th>
                        <th class="">Description -3</th>
                        <th class="">Description -4</th> -->
                        <!-- <th class=""><?php echo e(trans('others.company_name_label')); ?></th>
                        <th class=""><?php echo e(trans('others.company_phone_number_label')); ?></th>
                        <th class=""><?php echo e(trans('others.company_description_label')); ?></th>
                        <th class=""><?php echo e(trans('others.company_address_label')); ?></th>
                        <th class=""><?php echo e(trans('others.status_label')); ?></th>
                        <th class=""><?php echo e(trans('others.action_label')); ?></th> -->
                    </tr>
                </thead>
                <tbody>
                    
                     <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($product->product_code); ?></td>
                          <td> <?php echo e($product->product_name); ?> </td>
                          <td><?php echo e($product->product_description); ?></td>
                          <td><?php echo e($product->brand); ?></td>
                          <td><?php echo e($product->erp_code); ?></td>
                          <td><?php echo e($product->unit_price); ?></td>
                          <td><?php echo e($product->weight_qty); ?></td>
                          <td><?php echo e($product->weight_amt); ?></td>
                          <td><?php echo e($product->description_1); ?></td>
                          <td>
                              <table>
                                  <tr>
                                      <td class="">
                                          <a href="<?php echo e(Route('update_product_view')); ?>/<?php echo e($product->product_id); ?>" class="btn btn-success">edit</a>
                                      </td>
                                      <td class="td-pad">
                                          <a href="<?php echo e(Route('delete_product_action')); ?>/<?php echo e($product->product_id); ?>" class="btn btn-danger">delete</a>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                          
                </tbody>
            </table>    
           
       
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>