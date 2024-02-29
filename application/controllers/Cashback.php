<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashback extends Mandiri_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function __construct(){
        parent::__construct();

        $this->sidebar_id = 2;
    }

    public function add()
	{
        $source = 'Add';
        $this->get_cashback_form($source);
	}

    public function edit()
    {
        $id = $this->input->get('id');
        if($id == ""){
            redirect('cashback');
        }
        $source = 'Edit';
        $this->get_cashback_form($source, $id);
    }

    private function get_cashback_form($source, $id = null){
        $data['id'] = $id;
        $data['heading_title'] = $source.' Cashback Voucher';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['action_url'] = base_url() . 'cashback/'. strtolower($source) . ($id != null && $id != "" ? "?id=".$id : "");
        
		$this->load->view('cashback/form', $data);
    }

	public function index()
	{
        $data['heading_title'] = 'Cashback Voucher';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        
		$this->load->view('cashback/list', $data);
	}

}
