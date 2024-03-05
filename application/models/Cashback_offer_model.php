<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashback_offer_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Menambahkan penawaran cashback baru
    public function add_cashback_offer($data)
    {
        $this->db->insert('cashback_offer', $data);
        return $this->db->insert_id();
    }

    // Mendapatkan semua penawaran cashback
    public function get_all_cashback_offers()
    {
    	$this->db->select('cashback_offer.*, master_card_type.master_card_name');
    	$this->db->from('cashback_offer');
    	$this->db->join('master_card_type','master_card_type.master_card_id = cashback_offer.master_card_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Mendapatkan penawaran cashback berdasarkan ID
    public function get_cashback_offer_by_id($id)
    {
        $query = $this->db->get_where('cashback_offer', array('id_cashback_offer' => $id));
        return $query->row_array();
    }

    // Update penawaran cashback
    public function update_cashback_offer($id, $data)
    {
        $this->db->where('id_cashback_offer', $id);
        return $this->db->update('cashback_offer', $data);
    }

	public function getCashbackOptions($cardType = null, $paymentType = null, $transactionAmount = null, $isClosedFlag = null) {
		$this->db->select('*');
		$this->db->from('cashback_offer');
		
		if($cardType != null){
			$this->db->where('master_card_id', $cardType);
		}		
		
		if($transactionAmount != null){
			$this->db->where('min_transaction <=', $transactionAmount);
		}

		if($isClosedFlag == "0" || $isClosedFlag == "1"){
			$this->db->where('is_closed', $isClosedFlag);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
		
		// Filter hasil berdasarkan paymentType
		$filteredResults = [];
		foreach ($result as $row) {
			if ($paymentType == 'full' && $row['cashback_full_payment'] != 0) {
				$filteredResults[] = [
					'id_cashback_offer' => $row['id_cashback_offer'],
					'cashback_amount' => $row['cashback_full_payment'],
					'description' => "Full Payment Cashback: " . number_format($row['cashback_full_payment'])
				];
			} elseif ($paymentType == 'cicilan' && $row['cashback_installment'] != 0) {
				$filteredResults[] = [
					'id_cashback_offer' => $row['id_cashback_offer'],
					'cashback_amount' => $row['cashback_installment'],
					'description' => "Installment Cashback: " . number_format($row['cashback_installment'])
				];
			}
		}
		
		return $filteredResults;
	}
	

    // Mengurangi kuota penawaran cashback
    public function decrement_quota($id, $amount = 1)
    {
        $this->db->set('total_quota', 'total_quota - '.$amount, FALSE);
        $this->db->where('id_cashback_offer', $id);
        $this->db->where('total_quota >', 0); 
        return $this->db->update('cashback_offer');
    }
}
