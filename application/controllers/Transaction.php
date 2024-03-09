<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./application/libraries/excel/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment; 
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;  
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Transaction extends Mandiri_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Customer_details_model','Cashback_offer_model','Master_card_type_model'));
        $this->load->helper(array('url','email'));
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

	public function approve(){
		if($this->input->method() == "post"){
    		$this->submit_approval_detail();
    	}

        $data['heading_title'] = 'Approve';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
		$data['id'] = $this->input->get('id');
        $data['params_error'] = $this->input->post();
        
        // Mengambil data card type untuk dropdown
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        // Mengambil data lainnya jika diperlukan, misalnya payment_type, dll.

        $this->load->view('transaction/approval_form', $data);
	}

    public function index()
    {
		$query_string = array();
		
        $data['heading_title'] = 'Cashback Voucher Transaction';
        $data['sidebars'] = $this->get_sidebar();
        $data['sidebar_id'] = $this->sidebar_id;
        $data['params_get'] = $this->input->get();
		if(isset($data['params_get']['transaction_start_date']) && $data['params_get']['transaction_start_date'] != ""){
			$query_string[] = "transaction_start_date=".$data['params_get']['transaction_start_date'];
		}

		if(isset($data['params_get']['transaction_end_date']) && $data['params_get']['transaction_end_date'] != ""){
			$query_string[] = "transaction_end_date=".$data['params_get']['transaction_end_date'];
		}

		$query_string = count($query_string) > 0 ? implode("&",$query_string) : "";

        $data['transaction_list'] = $this->Customer_details_model->get_transaction($data['params_get']);
		$data['export_url'] = base_url() . 'transaction/export?'.($query_string);
        
        // Mengambil data card type untuk dropdown
        $data['card_types'] = $this->Master_card_type_model->get_all_card_types();
        // Mengambil data lainnya jika diperlukan, misalnya payment_type, dll.

        $this->load->view('transaction/list', $data);
    }

    public function export(){
    	date_default_timezone_set('UTC');

		date_default_timezone_set('Asia/Jakarta');

		$spreadsheet = new Spreadsheet();

		$cellStyle = array(
			'borders' => array(
				'outline' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => array('argb' => '000000'),
				),
			)
		);

        $titleRow = [
            'font' => [
                'color' =>[
                    'rgb' =>'FFFFFF'
                ],
                'bold' =>true,
                'size' =>15
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '808080'
                ]
                ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];

        $summaryRow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFE70A'
                ]
                ],
            'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ],
		];
		
		$bold = [
            'font' => [
                'color'=>[
                    'rgb'=>'000000'
                ],
                'bold'=>true,
                'size'=>11
            ]
        ];

        $tableHead = [
            'font' => [
                'color'=>[
                    'rgb'=>'000000'
                ],
                'bold'=>true,
                'size'=>11
            ],
            'fill'=>[
                'fillType' => FILL::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'd8d8d8'
                ]   
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];

		$row_counter = 5;

        $spreadsheet->getActiveSheet()
					->setCellValue('A2', "REKAP PROGRAM DISKON MANDIRI TRAVEL DEALS @GANDARIA CITY PERIOD 06-10MAR'24")
					->setCellValue('A'.$row_counter, 'No')
					->setCellValue('B'.$row_counter, 'Tanggal Transaksi')
					->setCellValue('C'.$row_counter, 'Nama Pemegang Kartu')
					->setCellValue('D'.$row_counter, 'No Kartu Kredit')
					->setCellValue('E'.$row_counter, 'Tenor Transaksi Cicilan')
					->setCellValue('F'.$row_counter, 'Approval Code')
					->setCellValue('G'.$row_counter, 'Nilai Transaksi')
					->setCellValue('H'.$row_counter, 'Nominal Diskon')
					->setCellValue('I'.$row_counter, 'Nilai Transaksi Setelah Diskon')
					->setCellValue('J'.$row_counter, 'No Invoice/TTU');

		$spreadsheet->getActiveSheet()->mergeCells("A2:J2");

		$spreadsheet->getActiveSheet()->getStyle("A2")->applyFromArray($bold);

		$spreadsheet->getActiveSheet()
					->getRowDimension(2)
					->setRowHeight(40.25);

		$spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center')->setVertical('center');

		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("J".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("J".$row_counter)->applyFromArray($cellStyle);

		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter.":J".$row_counter)->getAlignment()->setHorizontal('center')->setVertical('center');

		$spreadsheet->getActiveSheet()
					->getRowDimension($row_counter)
					->setRowHeight(30.25);

		$row_counter++;

		$first_row = 0;

		$last_row = 0;
		$transaction_list = $this->Customer_details_model->get_transaction($this->input->get());

		for ($b=0; $b < count($transaction_list); $b++) {
			if($b == 0){
				$first_row = $row_counter;
			}

			if($b == count($transaction_list) - 1){
				$last_row = $row_counter;
			}

			$spreadsheet->getActiveSheet()
						->setCellValue('A'.$row_counter, ($b+1))
						->setCellValue('B'.$row_counter, (($transaction_list[$b]['transaction_date'] != "" && $transaction_list[$b]['transaction_date'] != NULL) ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime('+7 hours', strtotime($transaction_list[$b]['transaction_date']))) : ""))
						->setCellValue('C'.$row_counter, $transaction_list[$b]['name_customer'])
						->setCellValue('D'.$row_counter, $transaction_list[$b]['card_number'])
						->setCellValue('E'.$row_counter, $transaction_list[$b]['installment_period'])
						->setCellValue('F'.$row_counter, $transaction_list[$b]['approval_code'])
						->setCellValue('G'.$row_counter, $transaction_list[$b]['transaction_amount'])
						->setCellValue('H'.$row_counter, $transaction_list[$b]['customer_cashback'])
						->setCellValue('I'.$row_counter, "=(G".$row_counter." - H".$row_counter.")")
						->setCellValue('J'.$row_counter, $transaction_list[$b]['invoice_number']);
			
			if($transaction_list[$b]['transaction_date'] != "" && $transaction_list[$b]['transaction_date'] != null){
				$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->getNumberFormat()->setFormatCode('dd MMM yyyy Hh:mm:ss');
			}

			$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("J".$row_counter)->applyFromArray($cellStyle);

			$spreadsheet->getActiveSheet()
						->getStyle("G".$row_counter.":I".$row_counter)
						->getNumberFormat()
						->setFormatCode('#,##0');

			$spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center')->setVertical('center');

			$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($cellStyle);
			$spreadsheet->getActiveSheet()->getStyle("J".$row_counter)->applyFromArray($cellStyle);

			$spreadsheet->getActiveSheet()->getStyle("A".$row_counter.":J".$row_counter)->getAlignment()->setHorizontal('center')->setVertical('center');

			$spreadsheet->getActiveSheet()->getStyle("G".$row_counter.":I".$row_counter)->getAlignment()->setHorizontal('right')->setVertical('center');

			$spreadsheet->getActiveSheet()
						->getRowDimension($row_counter)
						->setRowHeight(30.25);

			$row_counter++;

		}

		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->getAlignment()->setHorizontal('center')->setVertical('center');
		$spreadsheet->getActiveSheet()->getStyle("G".$row_counter.":I".$row_counter)->getAlignment()->setVertical('center');
		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($cellStyle);
		$spreadsheet->getActiveSheet()->getStyle("A".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("B".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("C".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("D".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("E".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("F".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("G".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("H".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("I".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->getStyle("J".$row_counter)->applyFromArray($bold);
		$spreadsheet->getActiveSheet()
					->getRowDimension($row_counter)
					->setRowHeight(20.25);

		$spreadsheet->getActiveSheet()
					->setCellValue('A'.$row_counter, 'TOTAL TRANSAKSI')
					->setCellValue('G'.$row_counter, (count($transaction_list) == 0 ? '' : '=SUM(G'.$first_row.':G'.$last_row.')'))
					->setCellValue('H'.$row_counter, (count($transaction_list) == 0 ? '' : '=SUM(H'.$first_row.':H'.$last_row.')'))
					->setCellValue('I'.$row_counter, (count($transaction_list) == 0 ? '' : '=SUM(I'.$first_row.':I'.$last_row.')'))
					->mergeCells("A".$row_counter.":F".$row_counter);
		
		$spreadsheet->getActiveSheet()
					->getStyle("G".$row_counter.":I".$row_counter)
					->getNumberFormat()
					->setFormatCode('#,##0');
		
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);		

		$spreadsheet->getActiveSheet()->setTitle('06-10MAR\'24');
		$spreadsheet->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Rekap Diskon Mandiri '.date('dmYHi').'.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output'); 
		exit;
    }

    public function validate_email($email){
    	if($email != "" && $email != NULL){
    		if (!valid_email($email))
			{
				$this->form_validation->set_message('validate_email','Invalid email format');
				return FALSE;
			}
    	}

    	return TRUE;
    }

	private function submit_approval_detail(){
		$this->form_validation->set_rules('approval_code', 'Approval Code', 'required');
        $this->form_validation->set_rules('invoice_number', 'Invoice Number', 'required');

		if ($this->form_validation->run() === FALSE) {
			$errors = $this->form_validation->error_string(); 
			$this->session->set_flashdata('errors', $errors);
		}else{
			$transactionData = [
                'approval_code' => $this->input->post('approval_code'),
                'invoice_number' => $this->input->post('invoice_number'),
				'installment_period' => ($this->input->post('installment_period') != "" && $this->input->post('installment_period') != null ? $this->input->post('installment_period') : null),
				'approval_status' => 1
            ];

			$this->Customer_details_model->update_customer_details($this->input->post('id'), $transactionData);

			$this->session->set_flashdata('success', 'Approval data has been successfully updated!');

			redirect('transaction');
		}
	}

    private function submit_transaction()
    {
        // Validasi input form
        $id_card_validation = 'required';

        $skip_cashback_validation_flag = $this->input->post('skip_cashback_validation_flag');
        
        if($skip_cashback_validation_flag == "no"){
        	$id_card_validation .= '|callback_validate_id_number';
        }

        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('customer_phone', 'Customer Phone Number', 'required');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'callback_validate_email');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required');
		$this->form_validation->set_rules('id_number', 'ID Number', $id_card_validation);
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
				'customer_cashback' => explode('|',$this->input->post('cashback_value'))[0],
				'transaction_date' => date('Y-m-d H:i:s', time()),
				'created_at' => date('Y-m-d H:i:s', time())
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

	public function reject(){
		$id = $this->input->get('id');

		if($id != null){
			$reject_flag = $this->Customer_details_model->update_customer_details($id, array('approval_status' => 0));

			$customer_detail = $this->Customer_details_model->get_transaction_by_id($id);

			if(!empty($customer_detail)){
				$cashback_id = $customer_detail['cashback_id'];

				$cashback_detail = $this->Cashback_offer_model->get_cashback_offer_by_id($cashback_id);

				$total_quota = $cashback_detail['total_quota'];

				$sold_quota = count($this->Customer_details_model->get_transaction(array('cashback' => $cashback_id)));

				$total_quota -= $sold_quota;

				$this->Cashback_offer_model->update_cashback_offer($cashback_id, array('available_quota' => ($total_quota - $sold_quota)));

				$this->session->set_flashdata('success', 'Data has been successfully rejected!');
			}
		}

		redirect('transaction');
	}

	public function validate_id_number($id_number) {
		if($id_number != NULL && $id_number != ""){
			$transaction_data = $this->Customer_details_model->get_transaction_by_id_number($id_number);
		
			if(count($transaction_data) == 1){
				$last_transaction_date = date('Y-m-d',strtotime($transaction_data[0]['transaction_date']));
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

			$is_closed = $cashback_detail['is_closed'];
			$available_quota = $cashback_detail['available_quota'];

			if($available_quota == 0 || $is_closed == 1){
				$this->form_validation->set_message('validate_cashback', 'There is no quota for this cashback');

				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	

}
