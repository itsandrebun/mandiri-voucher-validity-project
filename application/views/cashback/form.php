<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>

            <h2><?php echo $heading_title;?></h2>
            <form method="POST" action="<?php echo $action_url; ?>">
                <input type="hidden" name="<?php echo $id;?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="">Card Type</label>
                        <select name="card_type" class="form-control" id="">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="">Min Transaction</label>
                        <input type="text" name="minimum_transaction_value" class="form-control" placeholder="Minimum Transaction Value">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Full Payment Cashback</label>
                        <input type="text" name="full_payment_cashback_value" class="form-control format-currency" placeholder="Full Payment Cashback">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Installment Cashback</label>
                        <input type="text" name="installment_cashback_value" class="form-control format-currency" placeholder="Installment Cashback Value">
                    </div>
                   
                    <div class="col-md-6 col-sm-12">
                        <label for="">Total Quota</label>
                        <input type="number" name="total_quota" class="form-control" placeholder="Total Quota">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="">Max Budget</label>
                        <input type="text" name="max_budget" class="form-control" placeholder="Max Budget">
                    </div>
                </div>
                <div class="float-right mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>

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
                            <span class="d-block">ID Number is required</span>
                            <span class="d-block">Duplicate ID Number</span>
                        </div>                    
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php $this->load->view('templates/js_list');?>
    <script>
        $('#errorAlertPopup').modal('show');
    </script>
    <?php $this->load->view('templates/footer');?>