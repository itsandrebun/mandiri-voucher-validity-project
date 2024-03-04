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
                    <a role="button" href="<?php echo base_url () . 'cashback/add';?>" class="btn btn-primary float-right text-white"><i class="fa fa-plus"></i> Add</a>
                </div>
            </div>            
            

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Type</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Minimum Transaction</th>
                        <th class="text-center" colspan="2">Cashback</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Total Quota</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Available Quota</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="text-center" style="vertical-align:middle;">Full Payment</th>
                        <th class="text-center" style="vertical-align:middle;">Installment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($master_cashback_list) && !empty($master_cashback_list)){?>
                        <?php for($b = 0; $b < count($master_cashback_list); $b++){?>
                            <tr>
                                <td class="text-center" style="vertical-align:middle;"><?php echo $master_cashback_list[$b]['master_card_name'];?></td>
                                <td class="text-right" style="vertical-align:middle;"><?php echo number_format($master_cashback_list[$b]['min_transaction'],0,",",".");?></td>
                                <td class="text-right" style="vertical-align:middle;"><?php echo number_format($master_cashback_list[$b]['cashback_full_payment'],0,",",".");?></td>
                                <td class="text-right" style="vertical-align:middle;"><?php echo number_format($master_cashback_list[$b]['cashback_installment'],0,",",".");?></td>
                                <td class="text-center" style="vertical-align:middle;"><?php echo number_format($master_cashback_list[$b]['total_quota'],0,",",".");?></td>
                                <td class="text-center" style="vertical-align:middle;"><?php echo number_format($master_cashback_list[$b]['available_quota'],0,",",".");?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url().'cashback/edit?id='.$master_cashback_list[$b]['id_cashback_offer']?>">Edit</a>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <tr>
                            <td class="text-center" colspan="6">No data found!</td>
                        </tr>
                    <?php }?>
                    
                </tbody>
            </table>
        </div>
    </div>

    <?php $this->load->view('templates/success_popup');?>

    <?php $this->load->view('templates/js_list');?>
    <script>
        <?php if($this->session->flashdata('success')) {?>
            $('#correctAlertPopup').modal('show');
        <?php }?>
    </script>
    <?php $this->load->view('templates/footer');?>