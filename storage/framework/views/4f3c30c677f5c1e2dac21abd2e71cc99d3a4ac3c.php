<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><?php echo e($lc_pursache_product[0]->product_details); ?></h3>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-left: 10px;">
                    <div class="col-md-4">
                        <p><strong>L/C opening date   :</strong>   <?php echo e($lc_pursache_product[0]->purchase_date); ?></p>
                        <p><strong>L/C Type   :</strong>   <?php echo e($lc_pursache_product[0]->lc_type); ?></p> 
                        <p><strong>L/C no./id   :</strong>   <?php echo e($lc_pursache_product[0]->lc_no); ?></p>
                        <p><strong>Client   :</strong>   <?php echo e($lc_pursache_product[0]->client_details); ?></p>
                        <p><strong>Invoice Code   :</strong>   <?php echo e($lc_pursache_product[0]->invoice_code); ?></p>
                        <p><strong>Product   :</strong>   <?php echo e($lc_pursache_product[0]->product_details); ?></p>
                        <p><strong>Quantity   :</strong>   <?php echo e($lc_pursache_product[0]->quantity); ?></p>
                        <p><strong>Orign Country   :</strong>   <?php echo e($lc_pursache_product[0]->country_orign); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Price  :</strong>   <?php echo e($lc_pursache_product[0]->price); ?></p>
                        <p><strong>Bonus  :</strong>   <?php echo e($lc_pursache_product[0]->bonus); ?></p>
                        <p><strong>Bank swift charge  :</strong>   <?php echo e($lc_pursache_product[0]->bank_swift_charge); ?></p>
                        <p><strong>VAT   :</strong>   <?php echo e($lc_pursache_product[0]->vat); ?></p>
                        <p><strong>Bank Commission   :</strong>   <?php echo e($lc_pursache_product[0]->bank_commission); ?></p>
                        <p><strong>Application Form Charge  :</strong>   <?php echo e($lc_pursache_product[0]->apk_form_charge); ?></p>
                        <p><strong>L/C margin  :</strong>   <?php echo e($lc_pursache_product[0]->lc_margin); ?></p>
                        <p><strong>Others Cost  :</strong>   <?php echo e($lc_pursache_product[0]->others_cost); ?></p>
                        <p><strong>Due Payment   :</strong>   <?php echo e($lc_pursache_product[0]->due_payment); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Stock status  :</strong>   <?php echo e(($lc_pursache_product[0]->stock_status == 1)? "stocked":"not yet stocked"); ?></p>
                        <p><strong>L/C status  :</strong>   <?php echo e(($lc_pursache_product[0]->lc_status == 1)? "Approved":"Pending"); ?></p>
                        <p><strong>Bank Name  :</strong>   <?php echo e($lc_pursache_product[0]->bank_name); ?></p>
                        <p><strong>Dollar Rate   :</strong>   <?php echo e($lc_pursache_product[0]->dollar_rate); ?></p>
                        <p><strong>L/C amount(taka)   :</strong>   <?php echo e($lc_pursache_product[0]->lc_amount_taka); ?></p>
                        <p><strong>L/C amount(usd)  :</strong>   <?php echo e($lc_pursache_product[0]->lc_amount_usd); ?></p>
                        <p><strong>Total amount with other Cost  :</strong>   <?php echo e($lc_pursache_product[0]->total_amount_with_other_cost); ?></p>
                        <p><strong>Total amount without other Cost  :</strong>   <?php echo e($lc_pursache_product[0]->total_amount_without_other_cost); ?></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Convert to Excel</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Convert to pdf</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo e(trans('product.print_btn')); ?></button>
                </div>

            </div>
        </div>
    </div>
</div>