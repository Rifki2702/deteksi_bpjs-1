<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->helper('url');      // Memuat helper URL
		$this->load->library('session');          // Memuat library sesi
		$this->load->model('auth_model');         // Memuat model auth_model
		        // Memeriksa apakah pengguna saat ini terautentikasi
		if(!$this->auth_model->current_user()){   // Jika tidak terautentikasi, alihkan ke halaman login
			redirect('auth/login');
		}
		// Load library PHPExcel (PhpSpreadsheet)
		// $this->load->library('PhpSpreadsheet');
    }
    
    // Metode ini menampilkan tampilan 'upload_excel'
    public function index() {
        $this->load->view('upload_excel');
    }
 

 
    // Metode ini mengembalikan aturan validasi untuk unggahan file
	public function rules()
	{
		return [
			[
				'field' => 'file',
				'label' => 'File',
				'rules' => 'required'
			],
		];
	}
    public function upload() {     // Metode ini mengembalikan aturan validasi untuk unggahan file
		$this->load->library('form_validation');

		if (empty($_FILES['file']['name']))
		{
			$this->form_validation->set_rules('file', 'Document', 'required');
			return $this->load->view('upload_excel');
		}
		$upload_file = $_FILES['file']['name'];
		$extension = pathinfo($upload_file,PATHINFO_EXTENSION);
		if ($extension == 'csv') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} elseif ($extension == 'xls') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} elseif ($extension = 'xlsx') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		} else {
			$data['error'] = 'File format is not supported. Please upload a CSV, XLS, or XLSX file.';
			$this->load->view('upload_excel', $data);
			return;
		}
		$excel = $reader->load($_FILES['file']['tmp_name']);
		$sheetData = $excel->getActiveSheet()->toArray(null, true, true, true);
		$duplicates = $this->groupDuplicates($sheetData);
		$data['duplicates'] = $duplicates;
		$this->load->view('display_duplicates', $data);
    }

	private function groupDuplicates($sheetData) {
		$duplicates = $this->findDuplicates($sheetData);
		$groupedData = array();

		$colors = array('#90e0ef', '#C2DFFF'); // Putih dan Biru

		$colorIndex = 0;
		foreach ($duplicates as $group) {
			$color = $colors[$colorIndex % count($colors)];
			foreach ($group as $row) {
				$groupedData[] = array(
					'data' => $row,
					'color' => $color
				);
			}
			$colorIndex++; // Pindah ke warna berikutnya
		}
		return $groupedData;
	}
	private function findDuplicates($sheetData) {
		$duplicates = array();
		$processedRows = array(); // Array to keep track of processed rows
	
		foreach ($sheetData as $key => $row) {
			if ($key > 3) {
				if (in_array($key, $processedRows)) {
					continue; // Skip already processed rows
				}
				// Revisi Tanggal Masuk dan no RM
				$currentNoRM = $row['D']; // Nomor RM
				$currentTglMasuk = $row['B']; // Tanggal Pulang
				// $currentNamaPeserta = $row['F']; // Nama Peserta
		
				$foundDuplicates = array();
				foreach ($sheetData as $innerKey => $innerRow) {
					if ($key != $innerKey && $currentNoRM == $innerRow['D'] && $currentTglMasuk == $innerRow['B']) {
						$foundDuplicates[] = $innerRow;
						$processedRows[] = $innerKey; // Mark row as processed
					}
				}
		
				if (!empty($foundDuplicates)) {
					$duplicates[] = array_merge(array($row), $foundDuplicates);
					$processedRows[] = $key; // Mark main row as processed
				}
			}
		}
	
		return $duplicates;
	
    }

	public function download()
	{
		$duplicates = $this->input->post('data');
		$data['duplicates'] = json_decode($duplicates,true);
		$this->load->view('download', $data);
	}


}
