<?php $__env->startSection('page_heading',trans('others.heading_report_label')); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
    .search_box{
        width: 50% !important;
        float: left;
    }
    .search_box select{
        padding: 10px;
    }
</style>

<?php if(Session::has('vat_tax_message')): ?>
    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('vat_tax_message') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>


            <div class="col-md-4 ">
                <div class="search_box">
                    <select name="a_q_s" class="myselect" id="available_quantity_s">
                        <option value=""><?php echo e(trans('others.option_select_product_label')); ?></option>
                        <?php $__currentLoopData = $available_quantity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->product_name.'( '.$item->packet_name.'('.$item->packet_quantity.')  '.$item->unit_name.'('.$item->unit_quantity.') )'); ?>">
                            <?php echo e($item->product_name.'( '.$item->packet_name.'('.$item->packet_quantity.')  '.$item->unit_name.'('.$item->unit_quantity.') )'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="search_box">
                    <button class="search_available_q form-control btn btn-primary btn-outline"><?php echo e(trans('others.search_placeholder')); ?></button>
                </div>
            </div>

<div class="col-sm-12">




    <div class="row">

            <br>

            <?php $__env->startSection('cotable_panel_body'); ?>

            <?php if(Session::has('packet_delete_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'danger', 'message'=> Session::get('packet_delete_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(Session::has('packet_update_msg')): ?>
                <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('packet_update_msg') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>








            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class=""><?php echo e(trans('others.serial_no_label')); ?></th>
                        <th class=""><?php echo e(trans('others.product_name_label')); ?></th>
                        
                        <th class=""><?php echo e(trans('others.product_group_label')); ?></th>
                        <th class=""><?php echo e(trans('others.available_quantity_label')); ?></th>
                        <th class=""><?php echo e(trans('others.sale_quantity_label')); ?></th>
                        <th class=""><?php echo e(trans('others.total_quantity_label')); ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1;?>
                    <?php $__currentLoopData = $available_quantity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($item->product_name.'( '.$item->packet_name.'('.$item->packet_quantity.')  '.$item->unit_name.'('.$item->unit_quantity.') )'); ?></td>
                                <td><?php echo e($item->group_name); ?></td>
                                <td><?php echo e($item->available_quantity); ?></td>
                                <td><?php echo e($item->quantity-$item->available_quantity); ?></td>
                                <td><?php echo e($item->quantity); ?></td>

                            </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </tbody>
            </table>
            <?php $__env->stopSection(); ?>
            <?php echo $__env->make('widgets.panel', array('header'=>true, 'as'=>'cotable'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
    </div>
</div>
<script type="text/javascript">
    $(".myselect").select2();
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>