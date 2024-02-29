<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Mandiri Voucher Validity</h3>
            </div>

            <?php $this->load->view('templates/sidebar');?>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>

            <h2>Cashback Voucher Validity</h2>
            <form method="POST" action="<?php echo base_url() . 'transaction/submit_transaction' ?>">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="">ID Number</label>
                        <input type="text" name="id_number" class="form-control" placeholder="ID Card">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Card Number</label>
                        <input type="text" name="card_number" class="form-control" placeholder="Card Number">
                    </div>
                    <div class="col-sm-12">
                        <label for="">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Customer Email</label>
                        <input type="email" name="customer_email" class="form-control" placeholder="Customer Email">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Customer Phone Number</label>
                        <input type="text" name="customer_phone" class="form-control" placeholder="Customer Phone Number">
                    </div>
					<div class="col-sm-12">
                        <label for="">Transaction Nominal</label>
                        <input type="text" name="transaction_nominal" class="form-control" placeholder="Transaction Nominal">
                    </div>
					<div class="col-md-4 col-sm-12">
					<label for="">Card Type</label>
					<select name="card_type" class="form-control" id="card_type">
						<option value="">Please Select</option>
						<option value="1">All Card</option>
						<option value="2">World Elite</option>
						<option value="3">Prioritas</option>
						<option value="4">Signature</option>
					</select>
				</div>
                    <div class="col-md-4 col-sm-12">
                        <label for="">Payment Type</label>
                        <select class="form-control" name="payment_type" id="payment_type">
                            <option value="">Please Select</option>
							<option value="full">FULL</option>
                            <option value="cicilan">CICILAN</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="">Cashback</label>
                        <select class="form-control" name="cashback" id="cashback">
                            <option value="">Please Select</option>
                        </select>
                    </div>
					<input type="hidden" name="cashback_value" id="cashback_value">
                </div>
                <div class="float-right mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>
	
			
			<script src="<?php echo base_url('assets/js/error_pop_up.js'); ?>"></script>

			<?php if($this->session->flashdata('errors')) {?>
            <!-- Error Popup -->
            <div class="modal fade" id="errorAlertPopup" tabindex="-1" role="dialog" aria-labelledby="errorAlertPopupCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" style="color:red" id="errorAlertPopupLongTitle"><i class="fa fa-exclamation-triangle"></i> Error</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
							<div id="error_messages"><?php echo $this->session->flashdata('errors'); ?></div>
                        </div>                    
                    </div>
                </div>
            </div>
			<?php }?>

			
			<?php if($this->session->flashdata('success')) {?>

            <!-- Correct Popup -->
            <div class="modal fade" id="correctAlertPopup" tabindex="-1" role="dialog" aria-labelledby="correctAlertPopupCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" style="color:green" id="correctAlertPopupLongTitle"><i class="fa fa-check"></i> Good News</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span>Data has been successfully inserted!</span>
                            <span></span>
                        </div>                    
                    </div>
                </div>
            </div>

			<?php }?>

        </div>
    </div>

    <?php $this->load->view('templates/js_list');?>
	<script type="text/javascript">
    	var getCashbackOptionsUrl = "<?php echo site_url('transaction/getCashbackOptions'); ?>";
		<?php if($this->session->flashdata('errors')) {?>
			$('#errorAlertPopup').modal('show');
		<?php }?>

		<?php if($this->session->flashdata('success')) {?>
			$('#correctAlertPopup').modal('show');
		<?php }?>
	</script>
	<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>


    <?php $this->load->view('templates/footer');?>
