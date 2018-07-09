
<?php $__env->startSection('page_heading',
trans('others.update_party_label')); ?>
<?php $__env->startSection('section'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><span><?php echo e($error); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo e(trans('others.update_party_label')); ?></div>
                    <div class="panel-body">

                        <?php $__currentLoopData = $party_edits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $party_edit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form class="form-horizontal" action="<?php echo e(Route('party_edit_action')); ?>/<?php echo e($party_edit->id); ?>" role="form" method="POST" >
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                            <div class="row">
                            <!-- <div class="col-md-6"> -->
                                <div class="form-group">
                                    <label class="col-md-5 control-label"><?php echo e(trans('others.party_id_label')); ?></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="party_id" value="<?php echo e($party_edit->party_id); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label"><?php echo e(trans('others.name_label')); ?></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control  input_required" name="name" value="<?php echo e($party_edit->name); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label"><?php echo e(trans('others.sort_name_label')); ?></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control  input_required" name="sort_name" value="<?php echo e($party_edit->sort_name); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label"><?php echo e(trans('others.name_buyer_label')); ?></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control  input_required" name="name_buyer" value="<?php echo e($party_edit->name_buyer); ?>">
                                    </div>
                                </div>
                            <!-- </div> -->
                        </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <?php echo e(trans('others.invoice_label')); ?>

                                            </div>

                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.address_part_1_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="address_part_1_invoice" value="<?php echo e($party_edit->address_part1_invoice); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.address_part_2_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="address_part_2_invoice" value="<?php echo e($party_edit->address_part2_invoice); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.attention_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="attention_invoice" value="<?php echo e($party_edit->attention_invoice); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.mobile_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="mobile_invoice" value="<?php echo e($party_edit->mobile_invoice); ?>">
                                                    </div>
                                                </div>

                                                 <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.telephone_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="telephone_invoice" value="<?php echo e($party_edit->telephone_invoice); ?>">
                                                    </div>
                                                </div>

                                                 <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.fax_invoice_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="fax_invoice" value="<?php echo e($party_edit->fax_invoice); ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <?php echo e(trans('others.delivery_label')); ?>

                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.address_part1_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="address_part_1_delivery" value="<?php echo e($party_edit->address_part1_delivery); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.address_part2_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="address_part_2_delivery" value="<?php echo e($party_edit->address_part2_delivery); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.attention_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="attention_delivery" value="<?php echo e($party_edit->attention_delivery); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.mobile_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control  input_required" name="mobile_delivery" value="<?php echo e($party_edit->mobile_delivery); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.telephone_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control " name="telephone_delivery" value="<?php echo e($party_edit->telephone_delivery); ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-5 control-label"><?php echo e(trans('others.fax_delivery_label')); ?></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="fax_delivery" value="<?php echo e($party_edit->fax_delivery); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-8">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        <?php echo e(trans('others.update_button')); ?>

                                    </button>
                                </div>
                            </div>
                            
                        </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".selections").select2();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>