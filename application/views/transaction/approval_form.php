<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <h2>Cashback Voucher Validity</h2>
            <form method="POST" action="<?php echo base_url() . 'transaction/approve?id='.$id ?>">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Invoice Number</small></label>
                        <input type="text" name="invoice_number" class="form-control" placeholder="Invoice Number" value="<?php echo (isset($params_error['invoice_number']) && !empty($params_error['invoice_number']) ? $params_error['invoice_number'] : "")?>">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Approval Code</small></label>
                        <input type="text" name="approval_code" class="form-control" value="<?php echo (isset($params_error['approval_code']) && !empty($params_error['approval_code']) ? $params_error['approval_code'] : "")?>" placeholder="Approval Code">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Installment Period</small></label>
                        <!-- <input type="number" name="installment_period" class="form-control" placeholder="Installment Period" value="<?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) ? $params_error['installment_period'] : "")?>"> -->

                        <select name="installment_period" class="form-control">
                            <option value="">Please Select</option>
                            <option value="1" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 1 ? "selected" : "")?>>1 bulan</option>
                            <option value="3" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 3 ? "selected" : "")?>>3 bulan</option>
                            <option value="6" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 6 ? "selected" : "")?>>6 bulan</option>
                            <option value="9" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 9 ? "selected" : "")?>>9 bulan</option>
                            <option value="12" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 12 ? "selected" : "")?>>12 bulan</option>
                            <option value="15" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 15 ? "selected" : "")?>>15 bulan</option>
                            <option value="18" <?php echo (isset($params_error['installment_period']) && !empty($params_error['installment_period']) && $params_error['installment_period'] == 18 ? "selected" : "")?>>18 bulan</option>
                        </select>
                    </div>
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

	<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

    <script>
        <?php if($this->session->flashdata('errors')) {?>
            $('#errorAlertPopup').modal('show');
        <?php }?>
    </script>

    <?php $this->load->view('templates/footer');?>
