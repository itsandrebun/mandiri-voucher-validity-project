<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <h2><?php echo $heading_title;?></h2>
            <form method="POST" action="<?php echo base_url() . 'transaction/submit_transaction' ?>">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Card Name</small></label>
                        <input type="text" name="card_name" class="form-control" placeholder="Card Name">
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