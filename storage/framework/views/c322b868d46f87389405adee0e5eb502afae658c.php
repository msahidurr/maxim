<?php $__env->startSection('section'); ?>
<style type="text/css">
    .table{
            margin-bottom: 5px;

    }
    .purchase_table_input input, .purchase_table_input select{
        /*width: 100% !important;*/
    }
    .input_required{
        /*width: 90% !important;*/
    }
    .req_star{
        position: absolute;
        right: 15px;
        top: 25px;
    }
    label{
        width: 100%;
    }
    .col-md-12, .col-md-4, .col-md-3, .col-md-5{
        padding-left: 0px;
        padding-right: 0px;
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


            <div class="purchase_table_input lc_purchase_table">
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

                        <div class="col-md-12">
                            <label>Date: </label>
                            <input class="form-control input_required" type="date" name="date" id="date">
                        </div>

                        <div class="col-md-12">
                            <label>Invoice No: </label>
                            <input class="form-control" type="text" name="invoice" id="invoice">
                        </div>

                        <div class="col-md-12">
                            <label>Product Group: </label>
                            <select class="form-control input_required" name="product_group" id="product_group">
                                <option value="">Select Group</option>
                                <?php $__currentLoopData = $productGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Product: </label>
                            <select class="form-control input_required" name="product" id="product" disabled></select>
                        </div>

                        <div class="col-md-6">
                            <label>LC No/ID: </label>
                            <input class="form-control input_required" type="text" name="lc_no" id="lc_no">
                        </div>
                        <div class="col-md-6">
                            <label>LC Type: </label>
                            <select class="form-control input_required" name="lc_type">
                                <option value="">Select Type</option>
                                <option value="payment_at_sight">Payment at sight</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>LC Bank Name: </label>
                            <input class="form-control" type="text" name="bank_name" id="bank_name">
                        </div>
                </div>

                <div class="purchase_table_left col-sm-7">


                    <div class="col-sm-12 input_table_specific">
                        <div class="table_box_title">
                            <label>LC Bank Charges</label>
                        </div>

                        <div class="col-md-12">
                            <label>Swift Charges: </label>
                            <input class="form-control input_required" type="text" name="swift_charges" id="swift_charges">
                        </div>
                        <div class="col-md-3">
                            <label>Vat(%): </label>
                            <input class="form-control input_required" type="text" name="vat" id="vat">
                        </div>
                        <div class="col-md-5">
                            <label>LC Bank Commission: </label>
                            <input class="form-control input_required" type="text" name="bank_commission" id="bank_commission">
                        </div>
                        <div class="col-md-4">
                            <label>Total Vat: </label>
                            <input class="form-control input_required" type="text" name="total_vat" id="total_vat" readonly>
                        </div>

                        <div class="col-md-12">
                            <label>LC Application From Charges: </label>
                            <input class="form-control input_required" type="text" name="application_form_charges" id="application_form_charges">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>LC Amount(USD): </label>
                        <input class="form-control input_required" type="text" name="lc_amount" id="lc_amount">
                    </div>
                    <div class="col-md-3">
                        <label>Doller Rate: </label>
                        <input class="form-control input_required" type="text" name="doller_rate" id="doller_rate">
                    </div>
                    <div class="col-md-3">
                        <label>In Taka: </label>
                        <input class="form-control input_required" type="text" name="in_taka" id="in_taka" readonly>
                    </div>

                    <div class="col-md-6">
                        <label>Margin(%): </label>
                        <input class="form-control " type="text" name="margin" id="margin">
                    </div>
                    <div class="col-md-6">
                        <label>Total Margin: </label>
                        <input class="form-control input_required" type="text" name="total_margin" id="total_margin" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Due Payment: </label>
                        <input class="form-control input_required" type="text" name="due_payment" id="due_payment">
                    </div>
                    <div class="col-md-4">
                        <label>Other Cost: </label>
                        <input class="form-control" type="text" name="other_cost" id="other_cost">
                    </div>
                    <div class="col-md-4">
                        <label>Country of Origin: </label>
                        <input class="form-control input_required" type="text" name="country_of_origin" id="country_of_origin">
                    </div>


                    <div class="form-group pull-right">
                        <a class="btn btn-primary btn-outline" id="new_lc_purchase_table_row">
                            Add Row
                        </a>
                    </div>

                </div>


            </div>


            <div class="purchase_table col-md-12">
                <form action="<?php echo e(Route('product_purchase_add')); ?>" method="post" role="form" id="form" >
                    <table class="table table-bordered purchase_table" id="tblSearch">
                        <thead>
                            <tr>

                                    <th> Client </th>
                                    <th> Date </th>
                                    <th> Invoice No </th>
                                    <th> Product Group </th>
                                    <th> Product </th>
                                    <th> LC No/ID </th>
                                    <th> LC Type </th>
                                    <th> LC Bank Name </th>
                                    <th> Swift Charges </th>
                                    <th> Vat </th>
                                    <th> LC Bank Commission </th>
                                    <th> Total Vat </th>
                                    <th> LC Application From Charges </th>
                                    <th> LC Amount </th>
                                    <th> Margin </th>
                                    <th> Total Margin </th>
                                    <th> Due Payment </th>
                                    <th> Other Cost </th>
                                    <th> Country of Origin </th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="purchase_table_input_row">
                                <tr id="purchase_table_row">
                                        <th class="client_th" >
                                        </th>
                                        <th class="client_id_th" >
                                        </th>
                                        <th class="date_th" >
                                        </th>
                                        <th class="invoice_th" >
                                        </th>
                                        <th class="product_group_th" >
                                        </th>
                                        <th class="product_group_id_th" >
                                        </th>
                                        <th class="product_th" >
                                        </th>
                                        <th class="product_id_th" >
                                        </th>
                                        <th class="product_code_th" >
                                        </th>
                                        <th class="lc_no_th" >
                                        </th>
                                        <th class="lc_type_th" >
                                        </th>
                                        <th class="bank_name_th" >
                                        </th>
                                        <th class="swift_charges_th" >
                                        </th>
                                        <th class="vat_th" >
                                        </th>
                                        <th class="bank_commission_th" >
                                        </th>
                                        <th class="total_vat_th" >
                                        </th>
                                        <th class="application_form_charges_th" >
                                        </th>
                                        <th class="lc_amount_th" >
                                        </th>
                                        <th class="margin_th" >
                                        </th>
                                        <th class="total_margin_th" >
                                        </th>
                                        <th class="due_payment_th" >
                                        </th>
                                        <th class="other_cost_th" >
                                        </th>
                                        <th class="country_of_origin_th" >
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



                    <input name+="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
                    <input name+="company_id" type="hidden" value="<?php echo e($request->session()->get('company_id')); ?>">
                    <input name+="com_group_id" type="hidden" value="<?php echo e($request->session()->get('group_id')); ?>">
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