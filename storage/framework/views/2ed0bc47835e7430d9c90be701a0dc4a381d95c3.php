<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Sale memo</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" method="post" id="create_urgent_client_post">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                         <div class="col-md-6">
                            <p><strong>Client name :</strong>   </p>
                            <p><strong>Client email   :</strong>   </p>
                            <p><strong>Add Others   :</strong>   </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Client Address  :</strong>  </p>
                            <p><strong>Client Phone number  :</strong>  </p>
                            <p><strong>Memo Date  :</strong> </p>
                        </div>

                       <table class="table table-bordered purchase_table" id="tblSearch">
                        <thead>
                            <tr>
                                    <th class=""> order_no </th>
                                    <th class=""> transport_no </th>
                                    <th class=""> product_group </th>
                                    <th class=""> sales_date </th>
                                    <th class=""> product </th>
                                    <th class=""> transport_name </th>
                                    <th class=""> transport_date </th>
                                    <th class=""> invoice </th>
                                    <th class=""> quantity </th>
                                    <th class=""> sales_price </th>
                                    <th class=""> bonus </th>

                            </tr>
                        </thead>
                        <tbody>
                            <div class="purchase_table_input_row">
                                <tr id="purchase_table_row">
                                </tr>
                            </div>
                        </tbody>
                    </table>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-6">
                                <input type="submit" name="print" value="Print" class="btn btn-primary">
                            </div>
                            <div class="col-md-3">
                                <input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
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