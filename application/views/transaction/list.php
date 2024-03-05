<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>
        
        <!-- Page Content  -->
        <div id="content">
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo $heading_title;?></h2>
                </div>
                <div class="col-md-6">
                    <a role="button" href="<?php echo base_url () . 'transaction/add';?>" class="btn btn-primary float-right text-white ml-2"><i class="fa fa-plus"></i> Add</a>
                    <a role="button" href="<?php echo base_url () . 'transaction/export';?>" class="btn btn-primary float-right text-white"><i class="fa fa-download"></i> Export</a>
                </div>
            </div>

            <form id="transaction_filter_form" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-label"><small>Transaction Start Date</small></label>
                            <input type="date" name="transaction_start_date" class="form-control" value="<?php echo (isset($params_get['transaction_start_date']) && !empty($params_get['transaction_start_date']) ? $params_get['transaction_start_date'] : '');?>" id="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-label"><small>Transaction End Date</small></label>
                            <input type="date" name="transaction_end_date" class="form-control" id="" value="<?php echo (isset($params_get['transaction_end_date']) && !empty($params_get['transaction_end_date']) ? $params_get['transaction_end_date'] : '');?>">
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-primary" onclick="$('input').val('');"><i class="fa fa-search"></i> Clear</button>
                    <button type="button" class="btn btn-primary" onclick="$('#transaction_filter_form').submit();"><i class="fa fa-search"></i> Filter</button>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table table-condensed table-bordered mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Transaction Date</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">ID Number</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Number</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Name</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Phone Number</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Email</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Type</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Payment Type</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Transaction Amount</th>
                            <th class="text-center" style="vertical-align:middle;" rowspan="2">Cashback Amount</th>
                            <th class="text-center" style="vertical-align:middle"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($transaction_list) && !empty($transaction_list)){?>
                            <?php for($b = 0; $b < count($transaction_list); $b++){?>
                                <tr>
                                    <td class="text-center" style="vertical-align:middle"><?php echo date('d M Y H:i:s',strtotime($transaction_list[$b]['created_at']))?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['id_number'];?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['card_number'];?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['name_customer'];?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['phone_number'];?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['email'];?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $transaction_list[$b]['master_card_name'];?></td>
                                    <td class="text-center" style="vertical-align:middle;">Full Payment</td>
                                    <td class="text-right" style="vertical-align:middle;"><?php echo number_format($transaction_list[$b]['transaction_amount'],0,",",".");?></td>
                                    <td class="text-right" style="vertical-align:middle;"><?php echo number_format($transaction_list[$b]['customer_cashback'],0,",",".");?></td>
                                    <td class="text-center" style="vertical-align:middle;">
                                        <a href="<?php echo base_url().'transaction/add_approval_detail?id='.$transaction_list[$b]['id_customer_details']?>">Add Approval Detail</a> | 
                                        <a class="reject_transaction_button" style="color:red" data-url="<?php echo base_url().'transaction/reject?id='.$transaction_list[$b]['id_customer_details'];?>">Reject</a>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } else {?>
                            <tr>
                                <td class="text-center" colspan="10">No data found!</td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Reject Popup -->
    <div class="modal fade" id="rejectAlertPopup" tabindex="-1" role="dialog" aria-labelledby="rejectAlertPopupCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" style="color:red" id="rejectAlertPopupLongTitle"><i class="fa fa-exclamation-triangle"></i> Warning</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Are you sure want to reject this data?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="reject_transaction_yes_button">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/success_popup');?>

    <?php $this->load->view('templates/js_list');?>
    <script>
        <?php if($this->session->flashdata('success')) {?>
			$('#correctAlertPopup').modal('show');
		<?php }?>

        var reject_url = "";

        $('.reject_transaction_button').click(function(){
            $('#rejectAlertPopup').modal('show');

            reject_url = $(this).attr('data-url');
        });

        $('#rejectAlertPopup').on('hidden.bs.modal', function (e) {
            reject_url = "";
        });

        $('#reject_transaction_yes_button').click(function(){
            window.location.href = reject_url;
        })

    </script>
    <?php $this->load->view('templates/footer');?>