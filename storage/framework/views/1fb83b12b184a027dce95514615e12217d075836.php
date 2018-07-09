<?php $__env->startSection('page_heading','LC Purchased List'); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .table{
            margin-bottom: 5px;
    }
</style>

<div class="col-sm-12" id="demo">
    <div class="row">
        <div class="col-sm-12">
            <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            <?php endif; ?>

            <?php if(Session::has('purchase_table')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('purchase_table') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <form role="form" action="<?php echo e(Route('lc_product_purchase_search_list')); ?>" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" required>

                <div class="form-group input_table_specific">

                    <style type="text/css">
                        input{
                            width: 100% !important;
                        }
                    </style>

                    <div class="row">
                        <div class="col-md-4 row">
                            <div class="col-md-4" style="font-size: 15px;">Form date: </div>
                            <div class="col-md-8">
                                <input type="date" class="form-control" placeholder="Search date...." name="dateSearchFldFrom" id="dateSearchFldFrom" value="<?php echo e(Session::get('dateSearchFldFrom')); ?>">
                            <p id="search"></p>
                            </div>
                        </div>

                        <div class="col-md-4 row">
                            <div class="col-md-4" style="font-size: 15px">To date: </div>
                            <div class="col-md-8">
                                <input type="date" class="form-control" placeholder="Search date...." name="dateSearchFldTo" id="dateSearchFldTo" value="<?php echo e(Session::get('dateSearchFldTo')); ?>">
                            <p id="search"></p>
                           </div>
                        </div>

                        <div class="col-md-2">
                            <input class="form-control btn btn-primary" type="submit" value="View result" >
                        </div>

                       
                    </div>

                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4" style="padding-bottom: 10px;">
                            <input class="form-control btn btn-info" type="submit" value="Search more" id="lc_search_with_others_field">
                        </div>

                        <div class="col-md-2">
                            <input class="form-control btn btn-danger" type="submit" value="cancel" id="lc_search_with_others_field_close" style="display: none">
                        </div>
                    </div>

                    <div class="row" style="display: none;" id="lc_others_seach_field_box">
                        
                        <div class="col-md-2">
                            <select name="client" class="myselect form-control">
                                <option value="">Client name</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clients): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($clients->user_id); ?>" <?php echo e(((Session::get('client')) == $clients->user_id)? "selected":""); ?>><?php echo e($clients->first_name .'('. $clients->address .')'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="product_name" class="myselect form-control">
                                <option value="">Product name</option>
                                <?php $__currentLoopData = $select_products_in_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select_product_in_search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($select_product_in_search->id); ?>" <?php echo e(((Session::get('product_name')) == $select_product_in_search->id)? "selected":""); ?>><?php echo e($select_product_in_search->name.'('.$select_product_in_search->packet_name.')'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="product_code" class="myselect form-control">
                                <option value="">Product code</option>
                                <?php $__currentLoopData = $select_products_in_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select_product_in_search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($select_product_in_search->id); ?>" <?php echo e(((Session::get('product_code')) == $select_product_in_search->id)? "selected":""); ?>><?php echo e($select_product_in_search->product_code); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="lc_no" class="myselect form-control">
                                <option value="">L/C no./id</option>
                                <?php $__currentLoopData = $lc_products_in_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lc_product_in_search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lc_product_in_search->lc_no); ?>" <?php echo e(((Session::get('lc_no')) == $lc_product_in_search->lc_no)? "selected":""); ?>><?php echo e($lc_product_in_search->lc_no); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="bank_name" class="myselect form-control">
                                <option value="">Bank name</option>
                                <?php $__currentLoopData = $lc_products_in_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lc_product_in_search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lc_product_in_search->bank_name); ?>" <?php echo e(((Session::get('bank_name')) == $lc_product_in_search->bank_name)? "selected":""); ?>><?php echo e($lc_product_in_search->bank_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="country_orign" class="myselect form-control">
                                <option value="">Contry of origin</option>
                                <?php $__currentLoopData = $lc_products_in_search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lc_product_in_search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lc_product_in_search->country_orign); ?>" <?php echo e(((Session::get('country_orign')) == $lc_product_in_search->country_orign)? "selected":""); ?>><?php echo e($lc_product_in_search->country_orign); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php if(Session::get('dateSearchFldFrom')>0 && Session::get('dateSearchFldTo')>0){ ?>
                    <div id="print_page" class="right-aligned-texts pull-right" style="display: block;">
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bars"></i> Export Table Data</button>
                            <ul class="dropdown-menu " role="menu">
                                <li><a href="<?php echo e(route('lc_p_export_action',['dateSearchFldFrom'=>Session::get('dateSearchFldFrom'),'dateSearchFldTo'=>Session::get('dateSearchFldTo'),'type'=>'xls'])); ?>"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
                                <li></i><a href="<?php echo e(route('lc_p_export_action',['dateSearchFldFrom'=>Session::get('dateSearchFldFrom'),'dateSearchFldTo'=>Session::get('dateSearchFldTo'),'type'=>'csv'])); ?>"><i class="fa fa-file-text-o">&nbsp;</i>csv</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <?php echo e(Session::forget('dateSearchFldFrom')); ?>

                <?php echo e(Session::forget('dateSearchFldTo')); ?>

                <?php echo e(Session::forget('lcAmountUsd')); ?>

                <?php echo e(Session::forget('client')); ?>

                <?php echo e(Session::forget('product_name')); ?>

                <?php echo e(Session::forget('product_code')); ?>

                <?php echo e(Session::forget('bank_name')); ?>

                <?php echo e(Session::forget('country_orign')); ?>

                <?php echo e(Session::forget('lc_no')); ?>

            </form>

            <form role="form" action="<?php echo e(Route('product_purchase_add')); ?>" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <table class="table table-bordered purchase_table" id="tblSearch">
                    <thead>
                        <tr style="background-color:#f9f9f9;">
                            <th class="">Serial</th>
                            <th class="">LC No</th>
                            <th class="">LC opening date</th>
                            <th class="">LC Value(taka)</th>
                            <th class="">Others Cost</th>
                            <th class="">Total Cost(include others cost)</th>
                            <th class="">Total Cost(exclude others cost)</th>
                            <th class="">Status</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php ($i = 1); ?> 
                            <?php $__currentLoopData = $products_table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e($product_table->lc_no); ?></td>
                                    <td><?php echo e($product_table->purchase_date); ?></td>
                                    <td><?php echo e($product_table->lc_amount_taka); ?></td>
                                    <td><?php echo e($product_table->others_cost); ?></td>
                                    <td><?php echo e($product_table->total_amount_with_other_cost); ?></td>
                                    <td><?php echo e($product_table->total_amount_without_other_cost); ?></td>
                                    
                                    <td>
                                        <?php if($product_table->lc_status == 1): ?>
                                           <!--  <a href="#"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'approved'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a> -->
                                           <span class="text-success">approved</span>
                                        <?php else: ?>
                                            <span class="text-danger">pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width:160px;">
                                        <a name="lc_purchase_summary_btn" data-index="<?php echo e($product_table->lc_purchase_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'info btn', 'value'=>'details'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                        <a name="lc_purchase_table_update_btn" data-index="<?php echo e($product_table->lc_purchase_id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'info btn', 'value'=>'update'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                    </td>

                                    <div class="lc_purchase_product_view_modal">
                                    </div>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".myselect").select2();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>