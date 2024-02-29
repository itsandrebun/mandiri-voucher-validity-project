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
