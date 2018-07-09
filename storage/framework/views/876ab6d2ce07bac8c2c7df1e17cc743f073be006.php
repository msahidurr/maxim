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

            <?php if(Session::has('product_sale')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('product_sale') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('product_sale_warrning')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('product_psale_warrning') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <div class="purchase_table_input sales_table_input">
                <div class="purchase_table_left col-sm-5">
                        

                        <div class="col-md-12">
                                <div class="col-md-6">
                                    <label>Order No: </label>
                                    <input required class="form-control" type="text" id="order_no" name="order_no" value="" required>
                                </div>

                                <div class="col-md-6">
                                    <label>Transport No: </label>
                                    <input required class="form-control" type="text" id="transport_no" name="transport_no" value="" required>
                                </div>
                        </div>

                        <div class="col-md-12">
                                <div class="col-md-6">
                                    <label>Product Group: </label>
                                    <select class="form-control input_required" name="product_group" id="product_group_sale">
                                        <option value="">Select Group</option>
                                        <?php $__currentLoopData = $productGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($group->id); ?>"> <?php echo e($group->name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Sales Date: </label>
                                    <input required class="form-control input_required" type="date" name="sales_date" id="sales_date">
                                </div>
                        </div>

                        

                        <div class="col-md-12">
                            <label>Product: </label>
                            <select class="form-control input_required" name="product" id="product" disabled>

                            </select>
                        </div>
                </div>

                <div class="purchase_table_left col-sm-7">

                        <div class="col-md-12">
                                <div class="col-md-6">
                                    <label>Transport Name: </label>
                                    <input required class="form-control input_required" type="text" name="transport_name" id="transport_name">
                                </div>

                                <div class="col-md-6">
                                    <label>Transport Date: </label>
                                    <input required class="form-control input_required" type="date" name="transport_date" id="transport_date">
                                </div>
                        </div>

                        <div class="col-md-12" id="select_client">
                            <label>Client Name: </label>
                            <div id="divForSelectingClient"></div>
                            <select class="form-control input_required" name="client" id="client">
                                <option value="">--Select--</option>
                                <option value="-1" data-toggle="modal" data-target="#myModal">Create new Client</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->user_id); ?>"> <?php echo e($client->first_name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label>Invoice No: </label>
                                <input required class="form-control input_required" type="text" name="invoice" id="invoice" readonly>
                            </div>
                            <div class="col-md-6">
                                <button class="btn-primary btn" id="generate_invoice_btn" style="margin-top: 25px; width: 90%;"> Generate Invoice</button>
                            </div>


                        </div>
                </div>

                <div class="col-md-12 vat_tax_row">
                        <div class="col-md-12">
                            <label>Vat Tax</label>
                        </div>

                        <?php $i = 1;?>
                        <?php $__currentLoopData = $vattaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <div class="col-md-<?php echo e(round(12/(count($vattaxes)))); ?>">
                                <input class="form-control" name="vattax_percentage[]" placeholder="<?php echo e($vattax->name); ?> (%)" type="text">
                                <input name="vattax_id" type="hidden" value="<?php echo e($vattax->id); ?>">
                            </div>
                        </td>
                        <?php $i++;?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="col-md-12   purchase_table_right_bottom">
                        <div class="col-md-2">
                            <label>Quantity</label>
                            <input required onkeyup="checkAvailability()" class="form-control input_required" type="text" name="quantity">
                        </div>

                        <div class="col-md-3">
                            <label>Sales Price</label>
                            <input required class="form-control input_required" type="text" name="sales_price">
                        </div>
                        <div class="col-md-2">
                            <label>Left</label>
                            <input required class="form-control" type="text" name="available" id="available_q" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Bonus</label>
                            <input required onkeyup="checkAvailability()" disabled class="form-control" type="text" name="bonus">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success sale_data_add" disabled>Add</button>
                        </div>
                </div>
            </div>


            <div class="purchase_table col-md-12">
                <form action="<?php echo e(Route('product_sale_add_action')); ?>" method="post" role="form" id="form" >
                    <table class="table table-bordered purchase_table" id="tblSearch">
                        <thead>
                            <tr>
                                    <th class=""> Order no </th>
                                    <th class="hidden_th"> Transport no </th>
                                    <th class="hidden_th"> Product group </th>
                                    <th class=""> Sales date </th>
                                    <th class=""> Product </th>
                                    <th class=""> Transport name </th>
                                    <th class=""> Transport date </th>
                                    <th class=""> Invoice </th>
                                    <th class=""> Client </th>
                                    <th class=""> Quantity </th>
                                    <th class=""> Sales price </th>
                                    <th class=""> Bonus </th>
                                     <?php $__currentLoopData = $vattaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="">
                                        <?php echo e($vattax->name); ?>

                                    </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                        </thead>
                        <tbody>
                            <div class="purchase_table_input_row">
                                <tr id="purchase_table_row">
                                    <th class="order_no_th">
                                    </th>
                                    <th class="transport_no_th hidden_th">
                                    </th>
                                    <th class="product_group_th hidden_th">
                                    </th>
                                    <th class="sales_date_th">
                                    </th>
                                    <th class="product_th">
                                    </th>
                                    <th class="transport_name_th">
                                    </th>
                                    <th class="transport_date_th">
                                    </th>
                                    <th class="invoice_th">
                                    </th>
                                    <th class="client_th">
                                    </th>
                                    <th class="quantity_th">
                                    </th>
                                    <th class="sales_price_th">
                                    </th>
                                    <th class="available_th hidden_th">
                                    </th>
                                    <th class="bonus_th">
                                    </th>
                                     <?php $i = 0;?>
                                    <?php $__currentLoopData = $vattaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="vat_tax_th_<?php echo e($i); ?>">

                                        <?php $i++;?>
                                    </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tr>
                            </div>
                        </tbody>
                    </table>



                    <div class="amount_calculatioin">
                        <div class="cal_row">
                            <label>Amount : </label>
                            <p id="cal_amount"></p>
                        </div>

                        <div class="cal_row">
                            <label>Bonus : </label>
                            <p id="bonus_amount"></p>
                        </div>

                        <?php $i = 0;?>
                        <?php $__currentLoopData = $vattaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cal_row">
                                <label><?php echo e($vattax->name); ?> : </label>
                                <p id="cal_vat_tax_<?php echo e($i); ?>"></p>
                            </div>
                        <?php $i++;?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <hr>

                        <div class="cal_row">
                            <label>Final Amount : </label>
                            <p id="cal_final"></p>
                        </div>

                    </div>

                    <?php $i = 0;?>
                    <?php $__currentLoopData = $vattaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vattax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input name="tax_vat_id[]" type="hidden" value="<?php echo e($vattax->id); ?>">
                    <?php $i++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    <input required name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
                    <input required name="company_id" type="hidden" value="<?php echo e($request->session()->get('company_id')); ?>">
                    <input required name="com_group_id" type="hidden" value="<?php echo e($request->session()->get('group_id')); ?>">
                    <div class="col-md-12" style="padding-right: 0px; margin-top: 10px;">
                        <div class="form-group col-sm-2 pull-right" style="padding-right: 0px;">
                            <input required class="form-control input_required btn btn-primary save_btn" style="float: right;" type="submit" value="Submit" >
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