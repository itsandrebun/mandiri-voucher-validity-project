<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_details_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        //Load database
        $this->load->database();
    }

    // Menambahkan detail pelanggan
    public function add_customer_details($data)
    {
        $this->db->insert('customer_details', $data);
        return $this->db->insert_id();
    }

	public function get_transaction_by_id_number($id_number) {
		$this->db->where('id_number', $id_number);
		$this->db->from('customer_details');
		$this->db->order_by('created_at','DESC');
		return $this->db->get()->result_array();
	}

    public function get_transaction($params = array()){
        if(isset($params['transaction_start_date']) && $params['transaction_start_date'] != ""){
            $this->db->where('customer_details.created_at >= "'.$params['transaction_start_date'].'"');
        }

        if(isset($params['transaction_end_date']) && $params['transaction_end_date'] != ""){
            $this->db->where('customer_details.created_at <= "'.$params['transaction_end_date'].'"');
        }

        if(isset($params['cashback']) && $params['cashback'] != ""){
            $this->db->where('customer_details.cashback_id = "'.$params['cashback'].'"');
        }

        $this->db->join('master_card_type','master_card_type.master_card_id = customer_details.master_card_id','left');
        $this->db->from('customer_details');
        $this->db->select('customer_details.name_customer, customer_details.card_number, customer_details.id_number, customer_details.email, customer_details.email, customer_details.phone_number, customer_details.master_card_id, master_card_type.master_card_name, customer_details.cashback_id, customer_details.customer_cashback, customer_details.transaction_amount, customer_details.created_at');
        $this->db->order_by('customer_details.created_at','DESC');
        return $this->db->get()->result_array();
    }

    // Mendapatkan detail pelanggan berdasarkan ID
    public function get_customer_by_id($id)
    {
        $query = $this->db->get_where('customer_details', array('id_customer_details' => $id));
        return $query->row_array();
    }

    // Update detail pelanggan
    public function update_customer_details($id, $data)
    {
        $this->db->where('id_customer_details', $id);
        return $this->db->update('customer_details', $data);
    }
}
