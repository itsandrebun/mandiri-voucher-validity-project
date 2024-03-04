<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends Mandiri_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array('Master_card_type_model'));
        $this->load->library(array('form_validation'));

        $this->sidebar_id = 1;
    }

    public function add()
	{
		if($this->input->method() == "post"){
			$this->submit_card();
		}
        $source = 'Add';
        $this->get_card_form($source);
	}

    public function edit()
    {
    	if($this->input->method() == "post"){
    		$this->submit_card();
    	}
        $id = $this->input->get('id');
        if($id == ""){
            redirect('card');
        }

        $source = 'Edit';
        $this->get_card_form($source, $id);
    }

    private function submit_card()
    {
        // Validasi input form
        $this->form_validation->set_rules('card_name', 'Card Name', 'required');

		if ($this->form_validation->run() === FALSE) {
			$errors = $this->form_validation->error_string(); 
			$this->session->set_flashdata('errors', $errors);
		} else {
            $cardData = [
                'master_card_name' => $this->input->post('card_name')
            ];

            $id = $this->input->post('id');

            if(isset($id) && $id != null){
            	$this->Master_card_type_model->update_card_type($id, $cardData);
            }else{
            	$this->Master_card_type_model->add_card_type($cardData);
            }

			$this->session->set_flashdata('success', 'Data has been successfully inserted!');

			// Redirect ke halaman form
			redirect('card');  
        }
    }

    private function get_card_form($source, $id = null){
    	if($id != null){
    		$data['id'] = $id;
    		$data['card_type_by_id'] = $this->Master_card_type_model->get_card_type_by_id($id);
    	}
        
        $data['heading_title'] = $source.' Card Master';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['action_url'] = base_url() . 'card/'. strtolower($source) . ($id != null && $id != "" ? "?id=".$id : "");
        
		$this->load->view('card/form', $data);
    }

	public function index()
	{
        $data['heading_title'] = 'Card Master';
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        
		$this->load->view('card/list', $data);
	}

}
