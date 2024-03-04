<?php $this->load->view('templates/header');?>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <?php $this->load->view('templates/sidebar');?>

        <!-- Page Content  -->
        <div id="content">
            <h2><?php echo $heading_title;?></h2>
            <form method="POST" action="<?php echo $action_url ?>">
                <?php if(isset($id) && $id != null && $id != "") {?>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                <?php }?>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for=""><small>Card Name</small></label>
                        <input type="text" name="card_name" class="form-control" value="<?php echo (isset($card_type_by_id) && !empty($card_type_by_id) ? $card_type_by_id['master_card_name'] : "")?>" placeholder="Card Name">
                    </div>
                </div>
                <div class="float-right mt-2">
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