<?php $__env->startSection('section'); ?>
<style type="text/css">
    .table{
            margin-bottom: 5px;

    }
    .purchase_table_input input, .purchase_table_input select{
        width: 90% !important;]
    }
    .input_required{
        /*width: 90% !important;*/
    }
    .req_star{
        position: absolute;
        right: 10px;
        top: 25px;
    }
</style>
<div class="col-sm-12" id="demo">
    <div class="row">
        <div class="col-sm-12">
            <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger" role="alert">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <span>
                        <?php echo e($error); ?>

                    </span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <?php if(Session::has('product_purchase')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('product_purchase') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('product_purchase_warrning')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('product_purchase_warrning') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>


            <div class="purchase_table_input">
                <div class="purchase_table_left col-sm-5">
                        <div class="col-md-12" id="select_client">
                            <label>Client: </label>
                            <div id="divForSelectingClient"></div>
                            
                            <select class="form-control input_required" name="client" id="client" class="client">
                                <option value="">Select Client</option>
                                <option value="-1" data-toggle="modal" data-target="#myModal">Create new Client</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->user_id); ?>"> <?php echo e($client->first_name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Invoice No: </label>
                            <input class="form-control input_required" type="text" name="invoice" id="invoice">
                        </div>

                        <div class="col-md-6">
                            <label>Date: </label>
                            <input class="form-control input_required" type="date" name="date" id="date">
                        </div>

                        <div class="col-md-6">
                            <label>Product Group: </label>
                            <select class="form-control input_required" name="product_group" id="product_group">
                                <option value="">Select Group</option>
                                <?php $__currentLoopData = $productGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Product: </label>
                            <select class="form-control input_required" name="product" id="product" disabled></select>
                        </div>

                        <div class="col-md-6">
                            <label>LC No/ID: </label>
                            <input class="form-control input_required" type="text" name="lcID" id="lcID">
                        </div>
                        <div class="col-md-6">
                            <label>LC Type: </label>
                            <input class="form-control input_required" type="text" name="lcID" id="lcID">
                        </div>
                        <div class="col-md-12">
                            <label>LC Bank Name: </label>
                            <input class="form-control input_required" type="text" name="lcID" id="lcID">
                        </div>
                </div>

                <div class="purchase_table_left col-sm-7">


                        <div class="col-md-4">
                            <label>Bank Commission: </label>
                            <input class="form-control input_required" type="text" name="lcID" id="lcID">
                        </div>

                        <div class="col-md-4">
                            <label>LC Value: </label>
                            <input class="form-control input_required" type="text" name="lcID" id="lcID">
                        </div>

                </div>
            </div>


            <div class="purchase_table col-md-12">
                <form action="<?php echo e(Route('product_purchase_add')); ?>" method="post" role="form" id="form" >
                    <table class="table table-bordered purchase_table" id="tblSearch">
                        <thead>
                            <tr>
                                    <th class="hidden_th">
                                        Product Group
                                    </th>
                                    <th class="hidden_th">
                                        Client
                                    </th>

                                    <th class="">
                                        Product Code
                                    </th>

                                    <th class="">
                                        Product Name
                                    </th>
                                    <th class="hidden_th">
                                        Invoice No
                                    </th>

                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Price
                                    </th>

                                    <th>
                                        Total Price
                                    </th>
                                    <th class="hidden_th">
                                        Bonus
                                    </th>



                                    <th class="hidden_th">
                                        Date
                                    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="purchase_table_input_row">
                                <tr id="purchase_table_row">
                                        <th class="product_group_th hidden_th">

                                        </th>
                                        <th class="client_th hidden_th">

                                        </th>
                                        <th class="product_code_th">

                                        </th>
                                         <th class="product_th">

                                        </th>
                                        <th class="invoice_th hidden_th">

                                        </th>

                                        <th class="quantity_th">

                                        </th>
                                        <th class="price_th">

                                        </th>

                                         <th class="total_price_th">

                                        </th>
                                        <th class="bonus_th hidden_th">

                                        </th>



                                        <th class="date_th hidden_th">

                                        </th>
                                </tr>
                            </div>
                        </tbody>
                    </table>


                    <div class="amount_calculatioin">
                        <div class="cal_row">
                            <label>Amount : </label>
                            <p id="cal_amount"></p>
                        </div>



                        <hr>

                        <div class="cal_row">
                            <label>Final Amount : </label>
                            <p id="cal_final"></p>
                        </div>

                    </div>



                    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
                    <input name="company_id" type="hidden" value="<?php echo e($request->session()->get('company_id')); ?>">
                    <input name="com_group_id" type="hidden" value="<?php echo e($request->session()->get('group_id')); ?>">
                    <div class="col-md-12" style="padding-right: 0px; margin-top: 10px;">
                        <div class="form-group col-sm-2 pull-right" style="padding-right: 0px;">
                            <input class="form-control input_required btn btn-primary save_btn" style="float: right;" type="submit" value="SAVE" disabled>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pop_up_modal.client_create_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>