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
        $data['heading_title'] = 'Cashback Voucher Validity';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        
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
        
        // Mengambil data card type untuk dropdown
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        // Mengambil data lainnya jika diperlukan, misalnya payment_type, dll.

        $this->load->view('transaction/list', $data);
    }

    public function export(){

    }

    public function submit_transaction()
    {
        // Validasi input form
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('id_number', 'ID Number', 'required');
		$this->form_validation->set_rules('id_number', 'ID Number', 'required|callback_validate_id_number');

        // Tambahkan rules validasi Untuk yang lainnnnnnnnnnnnnnnnnnnnn



		if ($this->form_validation->run() === FALSE) {
			$errors = $this->form_validation->error_string(); 
			$this->session->set_flashdata('errors', $errors); 
			
            redirect('transaction/add'); 
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
				'customer_cashback' => $this->input->post('cashback_value')
            ];

			$this->Customer_details_model->add_customer_details($transactionData);

			$this->session->set_flashdata('success', 'Data has been successfully inserted!');

			// Redirect ke halaman form
			redirect('transaction');  
        }
    }


	public function getCashbackOptions() {
		$cardType = $this->input->post('card_type');
		$paymentType = $this->input->post('payment_type');
		$transactionAmount = $this->input->post('transaction_nominal');
	
		$cashbackOptions = $this->Cashback_offer_model->getCashbackOptions($cardType, $paymentType, $transactionAmount);
	
		$optionsHtml = '<option value="">Please Select</option>';
		foreach ($cashbackOptions as $option) {
			$optionsHtml .= "<option value='{$option['cashback_amount']}'>{$option['description']}</option>";
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
			}else{
				$this->form_validation->set_message('1', 'You can only submit twice in an exhibition period for the same ID Number.');
				return FALSE;
			}
		}
		
		
	
		return TRUE;
	}
	
	

}
