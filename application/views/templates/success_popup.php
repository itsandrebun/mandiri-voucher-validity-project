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
                    <span><?php echo $this->session->flashdata('success');?></span>
                </div>                    
            </div>
        </div>
    </div>

<?php }?>