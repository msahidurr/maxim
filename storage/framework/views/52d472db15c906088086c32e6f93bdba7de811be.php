<?php $__env->startSection('page_heading','Packet List'); ?>
<?php $__env->startSection('section'); ?>

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

<?php if(Session::has('new_packet_added')): ?>
    <?php echo $__env->make('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_packet_added') ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>


<div class="create_form_btn" style="margin-bottom: 20px;">
    <a href="<?php echo e(Route('add_packet_view')); ?>">
        <button class="btn btn-success">Add Packet</button>
    </a>
</div>


<div class="col-sm-12">
    <div class="row">
        
            <div class="input-group add-on">
              <input class="form-control" placeholder="Search" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
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
                        <th class="">Serial</th>
                        <th class="">Packet Name</th>
                        <th class="">Quantity</th>
                        <th class="">Unit Quantity</th>
                        <th class="">Unit</th>
                        <th class="">Is Active</th>
                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    <?php $__currentLoopData = $packetList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $packet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td><?php echo e($packet->name); ?></td>
                                <td><?php echo e($packet->quantity); ?></td>
                                <td><?php echo e($packet->unit_quantity); ?></td>
                                <td>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($packet->unit_id == $unit->id): ?>
                                                <?php echo e($unit->name); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php if($packet->is_active == '1'): ?>
                                        Active
                                    <?php else: ?>
                                        Deactive
                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <a href="<?php echo e(Route('update_packet_view')); ?>/<?php echo e($packet->id); ?>"> <?php echo $__env->make('widgets.button', array('class'=>'success', 'value'=>'Update'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                    
                                    <a class="delete_id" href="<?php echo e(Route('delete_packet_action')); ?>/<?php echo e($packet->id); ?>" > <?php echo $__env->make('widgets.button', array('class'=>'danger', 'value'=>'Delete&nbsp;'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </a>
                                </td>
                            </tr>    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    
                    
                </tbody>
            </table>    
            <?php $__env->stopSection(); ?>
            <?php echo $__env->make('widgets.panel', array('header'=>true, 'as'=>'cotable'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
    </div>
</div>
            
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>