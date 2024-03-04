<?php if($this->session->flashdata('errors')) {?>
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
				<div id="error_messages"><?php echo str_replace(array('<p>','</p>'),array('<span class="d-block">','</span>'),$this->session->flashdata('errors')); ?></div>
            </div>                    
        </div>
    </div>
</div>
<?php }?>