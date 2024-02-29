<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_card_type_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Menambahkan jenis kartu baru
    public function add_card_type($data)
    {
        $this->db->insert('master_card_type', $data);
        return $this->db->insert_id();
    }

    // Mendapatkan semua jenis kartu
    public function get_all_card_types()
    {
        $query = $this->db->get('master_card_type');
        return $query->result_array();
    }

    // Mendapatkan jenis kartu berdasarkan ID
    public function get_card_type_by_id($id)
    {
        $query = $this->db->get_where('master_card_type', array('master_card_id' => $id));
        return $query->row_array();
    }

    // Update jenis kartu
    public function update_card_type($id, $data)
    {
        $this->db->where('master_card_id', $id);
        return $this->db->update('master_card_type', $data);
    }

    // Menghapus jenis kartu
    public function delete_card_type($id)
    {
        $this->db->where('master_card_id', $id);
        return $this->db->delete('master_card_type');
    }
}
