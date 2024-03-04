<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends Mandiri_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Customer_details_model','Cashback_offer_model','Master_card_type_model'));
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->sidebar_id = 3;
    }

    public function add(){
    	if($this->input->method() == "post"){
    		$this->submit_transaction();
    	}

        $data['heading_title'] = 'Cashback Voucher Validity';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['params_error'] = $this->input->post();
        
        // Mengambil data card type untuk dropdown
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        // Mengambil data lainnya jika diperlukan, misalnya payment_type, dll.

        $this->load->view('transaction/form', $data);
    }

    public function index()
    {
        $data['heading_title'] = 'Cashback Voucher Transaction';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['params_get'] = $this->input->get();
        $data['transaction_list'] = $this->Customer_details_model->get_transaction($data['params_get']);
        
        // Mengambil data card type untuk dropdown
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        // Mengambil data lainnya jika diperlukan, misalnya payment_type, dll.

        $this->load->view('transaction/list', $data);
    }

    public function export(){

    }

    private function submit_transaction()
    {
        // Validasi input form
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('customer_phone', 'Customer Phone Number', 'required');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'required');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required');
		$this->form_validation->set_rules('id_number', 'ID Number', 'required|callback_validate_id_number');
		$this->form_validation->set_rules('transaction_nominal', 'Transaction Amount', 'required');
		$this->form_validation->set_rules('card_type', 'Card Type', 'required');
		$this->form_validation->set_rules('payment_type', 'Payment Type', 'required');
		$this->form_validation->set_rules('cashback', 'Cashback', 'required|callback_validate_cashback');

        // Tambahkan rules validasi Untuk yang lain

		if ($this->form_validation->run() === FALSE) {
			$errors = $this->form_validation->error_string(); 
			$this->session->set_flashdata('errors', $errors);
		} else {
            $transactionData = [
                'name_customer' => $this->input->post('customer_name'),
                'id_number' => $this->input->post('id_number'),
				'card_number' => $this->input->post('card_number'),
                'email' => $this->input->post('customer_email'),
                'phone_number' => $this->input->post('customer_phone'),
                'transaction_amount' => str_replace('.','',$this->input->post('transaction_nominal')),
				'master_card_id' => $this->input->post('card_type'),
                'payment_type' => $this->input->post('payment_type'),
                'cashback_id' => explode('|',$this->input->post('cashback'))[1],
				'customer_cashback' => explode('|',$this->input->post('cashback_value'))[0]
            ];

			$this->Customer_details_model->add_customer_details($transactionData);

			$cashback_detail = $this->Cashback_offer_model->get_cashback_offer_by_id($transactionData['cashback_id']);

			$total_quota = $cashback_detail['total_quota'];
			$sold_quota = count($this->Customer_details_model->get_transaction(array('cashback' => $transactionData['cashback_id'])));

			$this->Cashback_offer_model->update_cashback_offer($transactionData['cashback_id'], array('available_quota' => ($total_quota - $sold_quota)));

			$this->session->set_flashdata('success', 'Data has been successfully inserted!');

			// Redirect ke halaman form
			redirect('transaction');  
        }
    }


	public function getCashbackOptions() {
		$cardType = $this->input->post('card_type');
		$paymentType = $this->input->post('payment_type');
		$transactionAmount = $this->input->post('transaction_nominal');
	
		$cashbackOptions = $this->Cashback_offer_model->getCashbackOptions($cardType, $paymentType, $transactionAmount, "0");
	
		$optionsHtml = '<option value="">Please Select</option>';
		foreach ($cashbackOptions as $option) {
			$optionsHtml .= "<option value='".$option['cashback_amount'].'|'.$option['id_cashback_offer']."'>".$option['description']."</option>";
		}
	
		echo $optionsHtml;
	}

	public function validate_id_number($id_number) {
		if($id_number != NULL && $id_number != ""){
			$transaction_data = $this->Customer_details_model->get_transaction_by_id_number($id_number);
		
			if(count($transaction_data) == 1){
				$last_transaction_date = date('Y-m-d',($transaction_data[0]['created_at']));
				$transaction_date = date('Y-m-d');
				if($transaction_date == $last_transaction_date){
					$this->form_validation->set_message('validate_id_number', 'You can only submit once a day for the same ID Number.');
					return FALSE;
				}
			}elseif (count($transaction_data) > 1) {
				$this->form_validation->set_message('validate_id_number', 'You can only submit twice in an exhibition period for the same ID Number.');
				return FALSE;
			}
		}
		
		
	
		return TRUE;
	}

	public function validate_cashback($cashback){
		if($cashback != ""){
			$cashback = explode('|', $cashback)[1];
			$cashback_detail = $this->Cashback_offer_model->get_cashback_offer_by_id($cashback);

			$total_quota = $cashback_detail['total_quota'];
			$available_quota = $cashback_detail['available_quota'];

			if($available_quota == 0){
				$this->form_validation->set_message('validate_cashback', 'There is no quota for this cashback');

				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	

}
