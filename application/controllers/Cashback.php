<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashback extends Mandiri_Controller {
    public function __construct(){
        parent::__construct();

        $this->sidebar_id = 2;
        $this->load->model(array('Master_card_type_model','Cashback_offer_model','Customer_details_model'));
        $this->load->library(array('form_validation'));
    }

    public function add()
	{
		if($this->input->method() == "post"){
			$this->submit_master_cashback();
		}
        $source = 'Add';
        $this->get_cashback_form($source);
	}

    public function edit()
    {
    	if($this->input->method() == "post"){
    		$this->submit_master_cashback();
    	}
        $id = $this->input->get('id');
        if($id == ""){
            redirect('cashback');
        }
        $source = 'Edit';
        $this->get_cashback_form($source, $id);
    }

    private function get_cashback_form($source, $id = null){
    	if($id != NULL){
    		$data['id'] = $id;
			$data['cashback_detail'] = $this->Cashback_offer_model->get_cashback_offer_by_id($id);
    	}

		if($this->input->post()){
			$data['cashback_detail'] = array(
				'master_card_id' => $this->input->post('card_type'),
				'min_transaction' => $this->input->post('minimum_transaction_value'),
				'cashback_full_payment' => $this->input->post('full_payment_cashback_value'),
				'cashback_installment' => $this->input->post('installment_cashback_value'),
				'total_quota' => $this->input->post('total_quota'),
				'extra_quota' => $this->input->post('extra_quota'),
				'activity' => $this->input->post('activity'),
				'is_closed' => $this->input->post('close_flag')
			);
		}
        
        $data['heading_title'] = $source.' Cashback Voucher';
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();        
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['action_url'] = base_url() . 'cashback/'. strtolower($source) . ($id != null && $id != "" ? "?id=".$id : "");
        
		$this->load->view('cashback/form', $data);
    }

    private function submit_master_cashback(){
    	$this->form_validation->set_rules('minimum_transaction_value', 'Minimum Transaction Value', 'required');
        $this->form_validation->set_rules('full_payment_cashback_value', 'Full Payment Cashback Value', 'required');
        $this->form_validation->set_rules('installment_cashback_value', 'Customer Email', 'required');
        $this->form_validation->set_rules('card_type', 'Card Type', 'required');
		$this->form_validation->set_rules('total_quota', 'Total Quota', 'required');
		$this->form_validation->set_rules('extra_quota', 'Extra Quota', 'callback_validate_extra_quota');

    	if($this->form_validation->run() === FALSE){
    		$errors = $this->form_validation->error_string(); 
			$this->session->set_flashdata('errors', $errors);
    	}else{
			$total_quota = $this->input->post('total_quota');

			if($this->input->post('activity') != "" && $this->input->post('activity') != null && $this->input->post('extra_quota') != "" && $this->input->post('extra_quota') != null){
				if($this->input->post('activity') == "increase"){
					$total_quota += $this->input->post('extra_quota');
				}else{
					$total_quota -= $this->input->post('extra_quota');
				}
			}

    		$cashback_master = array(
	    		'min_transaction' => str_replace('.','',$this->input->post('minimum_transaction_value')),
	    		'cashback_full_payment' => str_replace('.','',$this->input->post('full_payment_cashback_value')),
	    		'cashback_installment' => str_replace('.','',$this->input->post('installment_cashback_value')),
	    		'master_card_id' => $this->input->post('card_type'),
	    		'total_quota' => $total_quota,
	    		'is_closed' => $this->input->post('close_flag')
	    	);

	    	if($this->input->post('id') != null && $this->input->post('id') != ""){
				$sold_quota = count($this->Customer_details_model->get_transaction(array('cashback' => $this->input->post('id'))));

				$cashback_master['available_quota'] = $total_quota - $sold_quota;

	    		$this->Cashback_offer_model->update_cashback_offer($this->input->post('id'),$cashback_master);

	    		$this->session->set_flashdata('success', 'Data has been successfully updated!');
	    	}else{
	    		$this->Cashback_offer_model->add_cashback_offer($cashback_master);

	    		$this->session->set_flashdata('success', 'Data has been successfully inserted!');
	    	}

	    	redirect('cashback');
    	}
    	
    }

	public function validate_extra_quota($extra_quota){
		if($extra_quota != null && $extra_quota != ""){
			$activity = $this->input->post('activity');
			$total_quota = $this->input->post('total_quota');

			if($activity != null && $activity != ""){
				if($activity == "decrease"){
					$total_quota -= $extra_quota;
					if($extra_quota < 0){
						$this->form_validation->set_message('validate_extra_quota','Quota cannot be less than 0 after decreasement');

						return FALSE;
					}else{
						$sold_quota = count($this->Customer_details_model->get_transaction(array('cashback' => $this->input->post('id'))));

						if($sold_quota > $total_quota){
							$this->form_validation->set_message('validate_extra_quota','Quota cannot be less than the sold quota after decreasement');

							return FALSE;
						}
					}
				}
			}

			return TRUE;
		}
	}

	public function index()
	{
        $data['heading_title'] = 'Cashback Voucher';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['master_cashback_list'] = $this->Cashback_offer_model->get_all_cashback_offers();
        
		$this->load->view('cashback/list', $data);
	}

}
