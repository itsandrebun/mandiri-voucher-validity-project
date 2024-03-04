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
                    <a role="button" href="<?php echo base_url () . 'card/add';?>" class="btn btn-primary float-right text-white"><i class="fa fa-plus"></i> Add</a>
                </div>
            </div>            
            

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="vertical-align:middle;" rowspan="2">Card Type</th>
                        <th class="text-center" style="vertical-align:middle;"></th>
                    </tr>
                </thead>
                    <?php if(isset($card_types) && !empty($card_types)){?>
                        <?php for($b = 0; $b < count($card_types); $b++) {?>
                            <tr>
                                <td class="text-center" style="vertical-align:middle;"><?php echo $card_types[$b]['master_card_name']?></td>
                                <td class="text-center" style="vertical-align:middle">
                                    <a href="<?php echo base_url() . 'card/edit?id=' . $card_types[$b]['master_card_id']?>">Edit</a>
                                </td>
                            </tr>
                        <?php }?>                    
                    <?php } else {?>
                        <tr>
                            <td class="text-center" style="vertical-align: middle;" colspan="2">No data found</td>
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