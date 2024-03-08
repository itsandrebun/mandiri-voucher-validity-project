<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <h2>Cashback Voucher Validity</h2>
            <form method="POST" action="<?php echo base_url() . 'transaction/add' ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label for=""><small>Skip ID Card Validation</small></label>
                        <div class="input-group">
                            <select class="form-control" name="skip_cashback_validation_flag">
                                <option value="yes" <?php echo (isset($params_error['skip_cashback_validation_flag']) && !empty($params_error['skip_cashback_validation_flag']) && $params_error['skip_cashback_validation_flag'] == "yes" ? "selected" : "")?>>Yes</option>
                                <option value="no" <?php echo (!isset($params_error['skip_cashback_validation_flag']) || (isset($params_error['skip_cashback_validation_flag']) && !empty($params_error['skip_cashback_validation_flag']) && $params_error['skip_cashback_validation_flag'] == "no") ? "selected" : "")?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>ID Number</small></label>
                        <div class="input-group">
                            <input type="text" style="-webkit-text-security: square;" name="id_number" class="form-control private-input-only" value="<?php echo (isset($params_error['id_number']) && !empty($params_error['id_number']) ? $params_error['id_number'] : "")?>" autocomplete="off" placeholder="ID Card">
                            <div class="input-group-append">
                                <span class="input-group-text seen_value_button" id="inputGroup-sizing-default"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Card Number</small></label>
                        <div class="input-group">
                            <input type="text" style="-webkit-text-security: square;" name="card_number" class="form-control private-input-only" placeholder="Card Number" value="<?php echo (isset($params_error['card_number']) && !empty($params_error['card_number']) ? $params_error['card_number'] : "")?>" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text seen_value_button" id="inputGroup-sizing-default"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for=""><small>Customer Name</small></label>
                        <input type="text" name="customer_name" class="form-control upper-case-input" placeholder="Customer Name" value="<?php echo (isset($params_error['customer_name']) && !empty($params_error['customer_name']) ? $params_error['customer_name'] : "")?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Customer Email</small></label>
                        <input type="email" name="customer_email" class="form-control" placeholder="Customer Email" value="<?php echo (isset($params_error['customer_email']) && !empty($params_error['customer_email']) ? $params_error['customer_email'] : "")?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Customer Phone Number</small></label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">+62</span>
                            </div>
                            <input type="text" name="customer_phone" class="form-control" placeholder="Customer Phone Number" value="<?php echo (isset($params_error['customer_phone']) && !empty($params_error['customer_phone']) ? $params_error['customer_phone'] : "")?>" autocomplete="off">
                        </div>
                        
                    </div>
					<div class="col-sm-12">
                        <label for=""><small>Transaction Amount</small></label>
                        <input type="text" id="transaction_nominal" name="transaction_nominal" class="form-control format-currency" placeholder="Transaction Nominal" value="<?php echo (isset($params_error['transaction_nominal']) && !empty($params_error['transaction_nominal']) ? number_format($params_error['transaction_nominal'],0,",",".") : "")?>">
                    </div>
					<div class="col-md-4 col-sm-12">
    					<label for=""><small>Card Type</small></label>
    					<select name="card_type" class="form-control" id="card_type">
    						<option value="">Please Select</option>
                            <?php for($b = 0; $b < count($card_types); $b++) {?>
                                <option value="<?php echo $card_types[$b]['master_card_id'];?>" <?php echo (isset($params_error['card_type']) && $card_types[$b]['master_card_id'] == $params_error['card_type'] ? "selected" : "")?>><?php echo $card_types[$b]['master_card_name'];?></option>
                            <?php }?>
    					</select>
    				</div>
                    <div class="col-md-4 col-sm-12">
                        <label for=""><small>Payment Type</small></label>
                        <select class="form-control" name="payment_type" id="payment_type">
                            <option value="">Please Select</option>
							<option value="full" <?php echo (isset($params_error['payment_type']) && $params_error['payment_type'] == "full") ? "selected" : ""?>>FULL</option>
                            <option value="cicilan" <?php echo (isset($params_error['payment_type']) && $params_error['payment_type'] == "cicilan") ? "selected" : ""?>>CICILAN</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for=""><small>Cashback</small></label>
                        <select class="form-control" name="cashback" id="cashback">
                            <option value="">Please Select</option>
                        </select>
                    </div>
					<input type="hidden" name="cashback_value" id="cashback_value" value="<?php echo (isset($params_error['cashback_value']) && !empty($params_error['cashback_value']) ? $params_error['cashback_value'] : "")?>">
                </div>
                <div class="float-right mt-2">
                    <button type="button" class="btn btn-light" onclick="window.location.href= '<?php echo base_url().'transaction'?>'"><i class="fa fa-arrow-left"></i> Back</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>

			<?php $this->load->view('templates/error_validation_popup');?>
        </div>
    </div>

    <?php $this->load->view('templates/js_list');?>
	<script type="text/javascript">
    	var getCashbackOptionsUrl = "<?php echo site_url('transaction/getCashbackOptions'); ?>";
		<?php if($this->session->flashdata('errors')) {?>
			$('#errorAlertPopup').modal('show');
            var cardType = $('#card_type').val();
            var paymentType = $('#payment_type').val();
            var transactionAmount = $('#transaction_nominal').val() != "0" ? parseInt($('#transaction_nominal').val().replace(/\./g,'')) : 0;
            if(cardType != '' && paymentType != '' && transactionAmount != '') {
                $.ajax({
                    url: getCashbackOptionsUrl, // pake variabel global
                    type: "POST",
                    data: {
                        card_type: cardType,
                        payment_type: paymentType,
                        transaction_nominal: transactionAmount
                    },
                    success: function(data) {
                        $('#cashback').html(data);

                        <?php if(isset($params_error['cashback']) && !empty($params_error['cashback'])) {
                            ?>
                            $('#cashback').val("<?php echo $params_error['cashback'];?>");
                        <?php }?>
                    }
                });
            }else if(transactionAmount == "0" || cardType == "" || paymentType == ""){
                $('#cashback').html('<option value="">Please Select</option>');
            }
		<?php }?>
	</script>
	<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>


    <?php $this->load->view('templates/footer');?>
