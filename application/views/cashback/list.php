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
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Max Budget</th>
                        <th class="text-center" style="vertical-align:middle;"></th>
                    </tr>
                    <tr>
                        <th class="text-center" style="vertical-align:middle;">Full Payment</th>
                        <th class="text-center" style="vertical-align:middle;">Installment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" style="vertical-align:middle;">Prioritas</td>
                        <td class="text-right" style="vertical-align:middle;"><?php echo number_format(23000000,0,",",".");?></td>
                        <td class="text-right" style="vertical-align:middle;"><?php echo number_format(9000000,0,",",".");?></td>
                        <td class="text-right" style="vertical-align:middle;"><?php echo number_format(2000000,0,",",".");?></td>
                        <td class="text-center" style="vertical-align:middle;">Total Quota</td>
                        <td class="text-center" style="vertical-align:middle;">Max Budget</td>
                        <td class="text-center" style="vertical-align:middle">
                            <a href="">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                </div>                    
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/js_list');?>
    <script>
        $('#correctAlertPopup').modal('show');
    </script>
    <?php $this->load->view('templates/footer');?>