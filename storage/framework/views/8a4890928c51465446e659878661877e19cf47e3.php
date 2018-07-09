<?php $__env->startSection('page_heading','Footer Title'); ?>
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
<div class="col-sm-1"></div>
 <div class="col-sm-2 top-btn-pro">
    <a href="<?php echo e(Route('add_footer_title_view')); ?>" class="btn btn-success form-control">Add Product </a>
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
            <div class="row">
            	<div class="col-md-1"></div>
            	<div class="col-md-10">
            		<table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                    	<th>Serial no</th>
                        <th class="">Footer Title</th>
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
                    <tr>
                    	<td width="10%"></td>
                    	<td width="60%">ghghgh</td>
                    	<td width="30%">
                    		<center>
                    		<table>
                                  <tr>
                                      <td class="">
                                          <a href="<?php echo e(Route('update_product_view')); ?>" class="btn btn-success">edit</a>
                                      </td>
                                      <td class="td-pad">
                                          <a href="<?php echo e(Route('delete_product_action')); ?>" class="btn btn-danger">delete</a>
                                      </td>
                                  </tr>
                              </table>
                              </center>
                    	</td>
                    </tr>
                    
                          
                </tbody>
            </table>
            	</div>
            	<div class="col-md-1"></div>
            </div>
                
           
       
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>