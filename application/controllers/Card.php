<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends Mandiri_Controller {

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

        $this->sidebar_id = 1;
    }

    public function add()
	{
        $source = 'Add';
        $this->get_card_form($source);
	}

    public function edit()
    {
        $id = $this->input->get('id');
        if($id == ""){
            redirect('card');
        }
        $source = 'Edit';
        $this->get_card_form($source, $id);
    }

    private function get_card_form($source, $id = null){
        $data['id'] = $id;
        $data['heading_title'] = $source.' Card Master';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['action_url'] = base_url() . 'card/'. strtolower($source) . ($id != null && $id != "" ? "?id=".$id : "");
        
		$this->load->view('card/form', $data);
    }

	public function index()
	{
        $data['heading_title'] = 'Card Master';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        
		$this->load->view('card/list', $data);
	}

}
