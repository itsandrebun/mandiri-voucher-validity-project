<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <h2><?php echo $heading_title;?></h2>
            <form method="POST" action="<?php echo $action_url; ?>">
                <?php if(isset($id)) {?>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                <?php }?>
                <div class="row">
                    <div class="col-sm-12">
                        <label for=""><small>Card Type</small></label>
                        <select name="card_type" class="form-control" id="">
                            <option value="">Please Select</option>
                            <?php for($b = 0; $b < count($card_types); $b++) {?>
                                <option value="<?php echo $card_types[$b]['master_card_id'];?>" <?php echo (isset($cashback_detail['master_card_id']) && $card_types[$b]['master_card_id'] == $cashback_detail['master_card_id'] ? "selected" : "")?>><?php echo $card_types[$b]['master_card_name'];?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for=""><small>Min Transaction</small></label>
                        <input type="text" value="<?php echo (isset($cashback_detail['min_transaction']) && !empty($cashback_detail['min_transaction']) ? $cashback_detail['min_transaction'] : "" )?>" name="minimum_transaction_value" class="form-control format-currency" placeholder="Minimum Transaction Value">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Full Payment Cashback</small></label>
                        <input type="text" value="<?php echo (isset($cashback_detail['cashback_full_payment']) && !empty($cashback_detail['cashback_full_payment']) ? $cashback_detail['cashback_full_payment'] : "" )?>" name="full_payment_cashback_value" class="form-control format-currency" placeholder="Full Payment Cashback">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Installment Cashback</small></label>
                        <input type="text" value="<?php echo (isset($cashback_detail['cashback_installment']) && !empty($cashback_detail['cashback_installment']) ? $cashback_detail['cashback_installment'] : "" )?>" name="installment_cashback_value" class="form-control format-currency" placeholder="Installment Cashback Value">
                    </div>
                   
                    <div class="col-sm-12">
                        <label for=""><small>Total Quota</small></label>
                        <input type="number" <?php echo (isset($id) && $id != null && $id != "" ? "readonly" : "")?> value="<?php echo (isset($cashback_detail['total_quota']) && !empty($cashback_detail['total_quota']) ? $cashback_detail['total_quota'] : "" )?>" name="total_quota" class="form-control" placeholder="Total Quota">
                    </div>
                    <?php if(isset($id)) {?>
                    <div class="col-md-6 col-sm-12">
                        <div class="col-md-6 col-sm-12">
                            <label for=""><small>Activity</small></label>
                            <select name="activity" class="form-control" id="activity">
                                <option value="">Please Select</option>
                                <option value="increase" <?php echo (isset($cashback_detail['activity']) && $cashback_detail['activity'] == "increase" ? "selected" : "");?>>Increase</option>
                                <option value="decrease" <?php echo (isset($cashback_detail['activity']) && $cashback_detail['activity'] == "decrease" ? "selected" : "");?>>Decrease</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for=""><small>Extra Quota</small></label>
                            <input type="number" value="<?php echo (isset($cashback_detail['extra_quota']) && !empty($cashback_detail['extra_quota']) ? $cashback_detail['extra_quota'] : "" )?>" name="extra_quota" class="form-control" placeholder="Extra Quota">
                        </div>
                    <?php }?>
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Close Flag</small></label>
                        <select class="form-control" name="close_flag">
                            <option value="1" <?php echo (isset($cashback_detail['is_closed']) && $cashback_detail['is_closed'] == 1 ? "selected" : "" )?>>Yes</option>
                            <option value="0" <?php echo ((isset($cashback_detail['is_closed']) && $cashback_detail['is_closed'] == 0) || !isset($cashback_detail['is_closed']) ? "selected" : "" )?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="float-right mt-2">
                    <button type="button" class="btn btn-light" onclick="window.location.href= '<?php echo base_url().'cashback'?>'"><i class="fa fa-arrow-left"></i> Back</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>

        </div>
    </div>

    <?php $this->load->view('templates/error_validation_popup');?>

    <?php $this->load->view('templates/js_list');?>
    <script>
        <?php if($this->session->flashdata('errors')) {?>
            $('#errorAlertPopup').modal('show');
        <?php }?>
    </script>
    <?php $this->load->view('templates/footer');?>