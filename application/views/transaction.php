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
                        <input type="text" name="card_number" class="form-control" placeholder="Customer Phone Number">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="">Card Type</label>
                        <select name="card_type" class="form-control" id="">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="">Payment Type</label>
                        <select class="form-control" name="payment_type">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="">Cashback</label>
                        <select class="form-control" name="cashback">
                            <option value="">Please Select</option>
                        </select>
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
        </div>
    </div>

    <?php $this->load->view('templates/js_list');?>
    <script>
        $('#correctAlertPopup').modal('show');
    </script>
    <?php $this->load->view('templates/footer');?>