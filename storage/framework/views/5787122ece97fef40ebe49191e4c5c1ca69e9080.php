<div id="myModal" class="modal fade" style="display:none;" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add new Client</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" method="post" id="create_urgent_client_post">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    <!--
                        <?php if(Session::has('validation_error_in_add_client')): ?>
                            <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('validation_error_in_add_client') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?> -->

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php echo (Session::forget('validation_error_in_add_client')); ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Client Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control  input_required" name="name" value="<?php echo e(old('clent_name')); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Client Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control  input_required" name="email" value="<?php echo e(old('client_mail')); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Client Phone Number</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control  input_required" name="phone" value="<?php echo e(old('client_mobile_num')); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Client Address</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control  input_required" name="address" value="<?php echo e(old('client_address')); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Select Company</label>
                            <div class="col-md-6">
                                <select class="form-control input_required" name="company_id" >
                                    <option value="" disabled="">Select Company</option>
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <div class="select">
                                    <select class="form-control" type="select" name="is_active" >
                                        <option  value="1" name="is_active" >Active</option>
                                        <option value="0" name="is_active" >InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="group_id" value="<?php echo e($request->session()->get('group_id')); ?>">


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" name="save" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>