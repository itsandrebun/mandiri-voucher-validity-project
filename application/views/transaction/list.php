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
                    <a role="button" href="<?php echo base_url () . 'transaction/add';?>" class="btn btn-primary float-right text-white ml-2"><i class="fa fa-plus"></i> Add</a>
                    <a role="button" href="<?php echo base_url () . 'transaction/export';?>" class="btn btn-primary float-right text-white"><i class="fa fa-download"></i> Export</a>
                </div>
            </div>

            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-label"><small>Transaction Start Date</small></label>
                            <input type="date" name="transaction_start_date" class="form-control" id="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-label"><small>Transaction End Date</small></label>
                            <input type="date" name="transaction_end_date" class="form-control" id="">
                        </div>
                    </div>
                </div>
            </form>
            

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">ID Number</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Number</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Name</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Phone Number</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Customer Email</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Type</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Payment Type</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Transaction Amount</th>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Cashback Amount</th>
                        <th class="text-center" style="vertical-align:middle"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" style="vertical-align:middle;">8379379327329872398</td>
                        <td class="text-center" style="vertical-align:middle;">4349384098430984309</td>
                        <td class="text-center" style="vertical-align:middle;">Andre Bun</td>
                        <td class="text-center" style="vertical-align:middle;">6282737388282</td>
                        <td class="text-center" style="vertical-align:middle;">marsin.bun@antavaya.com</td>
                        <td class="text-center" style="vertical-align:middle;">Prioritas</td>
                        <td class="text-center" style="vertical-align:middle;">Full Payment</td>
                        <td class="text-center" style="vertical-align:middle;"><?php echo number_format(20000000,0,",",".");?></td>
                        <td class="text-right" style="vertical-align:middle;"><?php echo number_format(2000000,0,",",".");?></td>
                        <td class="text-center" style="vertical-align:middle">
                            <a href="">Print</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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

    <?php $this->load->view('templates/js_list');?>
    <script>
        <?php if($this->session->flashdata('success')) {?>
			$('#correctAlertPopup').modal('show');
		<?php }?>
    </script>
    <?php $this->load->view('templates/footer');?>