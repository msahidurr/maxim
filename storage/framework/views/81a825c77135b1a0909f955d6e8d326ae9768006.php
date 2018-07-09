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

            


            <?php echo e(Form::open(array('url' => Route('journal_posting_form_view'), 'method' => 'post', 'id'=> 'journal_post_form_id' ))); ?>

                    <div id="journal_post_top" class="col-md-12">
                            <div class="col-md-4">
                                    <label>Company</label>
                                    <?php echo e(Form::select('company_id', $company, null,['class'=>'form-control'])); ?>


                                    <label>User (Role)</label>
                                    <?php echo e(Form::select('user_role', [], null, ['class'=>'form-control', 'disabled'=> true])); ?>


                                    <label>Debit</label>
                                    <?php echo e(Form::text('debit', '', ['class'=>'form-control', 'id'=>'debit_top'])); ?>


                                    <label>Description</label>
                                    <?php echo e(Form::text('description', '', ['class'=>'form-control'])); ?>



                            </div>
                            <div class="col-md-4">
                                    <label>Date</label>
                                    <?php echo e(Form::date('journal_date',null,['class'=>'form-control'])); ?>



                                    <label>Chart Of Acc</label>
                                    <?php echo e(Form::select('char_of_acc', $char_of_acc, null, ['class'=>'form-control'])); ?>


                                    <label>Credit</label>
                                    <?php echo e(Form::text('credit', '', ['class'=>'form-control', 'id'=>'credit_top'])); ?>

                            </div>
                            <div class="col-md-4">
                                    <label>Voucher Number</label>
                                    <?php echo e(Form::text('voucher_num', '', ['class'=>'form-control', 'readonly'=>'true'])); ?>



                                    <label>Particulars</label>
                                    <?php echo e(Form::text('particulars', '', ['class'=>'form-control'])); ?>


                                    <label>CF Code</label>
                                    <?php echo e(Form::text('cf_code', '', ['class'=>'form-control'])); ?>


                            </div>
                    </div>

                    <div id="journal_post_bottom" class="col-md-12">
                            <div class="col-md-4">
                                    <label>Date</label>
                                    <?php echo e(Form::date('journal_date',null,['class'=>'form-control'])); ?>


                                    <label>User Role</label>
                                    <?php echo e(Form::text('user_role', $user_role_id, ['class'=>'form-control', 'placeholder'=>$user_role, 'readonly'=>'true'])); ?>


                                    <label>Debit</label>
                                    <?php echo e(Form::text('debit', '', ['class'=>'form-control', 'id'=>'debit_bottom'])); ?>


                                    <label>Description</label>
                                    <?php echo e(Form::text('description', '', ['class'=>'form-control'])); ?>



                            </div>
                            <div class="col-md-4">
                                    <label>Voucher Number</label>
                                    <?php echo e(Form::text('voucher_num', '', ['class'=>'form-control', 'readonly'=>'true'])); ?>


                                    <label>Chart Of Acc</label>
                                    <?php echo e(Form::select('char_of_acc', $char_of_acc, null, ['class'=>'form-control'])); ?>


                                    <label>Credit</label>
                                    <?php echo e(Form::text('credit', '', ['class'=>'form-control', 'id'=>'credit_bottom'])); ?>

                            </div>
                            <div class="col-md-4">
                                    <label>Company</label>
                                    <?php echo e(Form::select('company_id', $company, null,['class'=>'form-control', 'readonly'=>'true'])); ?>


                                    <label>Particulars</label>
                                    <?php echo e(Form::text('particulars', '', ['class'=>'form-control'])); ?>


                                    <label>CF Code</label>
                                    <?php echo e(Form::text('cf_code', '', ['class'=>'form-control'])); ?>


                            </div>
                    </div>


                    <div class="col-md-12">
                        <div class="col-md-4">
                            <?php echo e(Form::submit('Add Row', ['class'=>'form-control'])); ?>

                        </div>
                    </div>

            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>