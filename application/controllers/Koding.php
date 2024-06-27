<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koding extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('auth_model');
		$this->load->model('Kombinasi_model'); // Memuat model yang telah dibuat
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$this->load->view('koding');
	}

	public function manajemen()
	{
		$this->load->view('manajemen_koding');
	}

	public function tambahkoding()
	{
		// Memuat data koding
		$data['koding'] = $this->Kombinasi_model->get_all_koding();

		// Memeriksa apakah form telah disubmit
		if ($this->input->post()) {
			// Data yang ingin disisipkan ke dalam database
			$data_insert = array(
				'kode_satu' => $this->input->post('kode_satu'),
				'kode_dua' => $this->input->post('kode_dua'),
				'keterangan' => $this->input->post('keterangan'),
				'kode_bpjs' => $this->input->post('kode_bpjs')
			);

			// Memeriksa apakah data sudah ada dalam database
			$existing_data = $this->Kombinasi_model->cek_kombinasi($data_insert['kode_satu'], $data_insert['kode_dua']);
			if (!$existing_data) {
				// Jika data belum ada, tambahkan ke database
				if ($this->Kombinasi_model->insert_koding($data_insert)) {
					$this->session->set_flashdata('message', 'Data berhasil ditambahkan.');
					$this->session->set_flashdata('message_type', 'green'); // Set warna pesan menjadi hijau
				} else {
					$this->session->set_flashdata('message', 'Gagal menambahkan data.');
					$this->session->set_flashdata('message_type', 'red'); // Set warna pesan menjadi merah
				}
			} else {
				// Jika data sudah ada, tampilkan pesan error
				$this->session->set_flashdata('message', 'Data sudah ada dalam database.');
				$this->session->set_flashdata('message_type', 'red'); // Set warna pesan menjadi merah
			}

			// Setelah data disimpan, Anda dapat mengarahkan pengguna ke halaman lain jika diperlukan
			redirect('Koding/tambahkoding'); // Misalnya mengarahkan pengguna ke halaman koding setelah data disimpan
		}

		// Memuat view 'tambah_koding' dengan data koding
		$this->load->view('tambah_koding', $data);
	}


	public function checkKombinasi()
	{
		$kode1_input = $this->input->post('kode_satu');
		$kode2_input = $this->input->post('kode_dua');
		$database_penyakit = $this->Kombinasi_model->get_data_penyakit(); // Mengambil data dari model
		$hasil_cek = $this->cek_kombinasi($kode1_input, $kode2_input, $database_penyakit);
		$data['hasil_cek'] = $hasil_cek;
		$this->load->view('koding_result', $data);
	}

	private function cek_kombinasi($kode1, $kode2, $database_penyakit)
	{
		foreach ($database_penyakit as $idx => $penyakit) {
			if ($kode1 == $penyakit['kode_satu'] && $kode2 == $penyakit['kode_dua']) {
				$kode = $penyakit['kode_bpjs'] != null ? $penyakit['kode_bpjs'] : '-';
				$data = [
					'title' => 'Seharusnya di kode ' . $kode,
					'keterangan' => $penyakit['keterangan'],
				];
				return $data;
			}
		}
		$data = [
			'title' => null,
			'keterangan' => 'Tidak sesuai dengan BA kesepakatan',
		];
		return $data;
	}

	public function get_all_koding()
	{
		$query = $this->db->get('koding');
		return $query->result();
	}

	public function insert_koding($data)
	{
		return $this->db->insert('koding', $data);
	}

	public function get_koding_by_id($id)
	{
		$query = $this->db->get_where('koding', array('id' => $id));
		return $query->row();
	}

	public function update_koding($id, $data = null)
	{
		if ($data === null) {
			$data = $_POST;
		}
		$this->db->where('id', $id);
		$update_result = $this->db->update('koding', $data);
		if ($this->Kombinasi_model->update_koding($id, $data)) {
			$this->session->set_flashdata('message', 'Data berhasil diperbarui.');
			$this->session->set_flashdata('message_type', 'yellow'); // Set warna pesan menjadi kuning
		} else {
			$this->session->set_flashdata('message', 'Gagal memperbarui data.');
			$this->session->set_flashdata('message_type', 'red'); // Set warna pesan menjadi merah
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_koding($id)
	{
		$this->db->where('id', $id);
		if ($this->Kombinasi_model->delete_koding($id)) {
			$this->session->set_flashdata('message', 'Data berhasil dihapus.');
			$this->session->set_flashdata('message_type', 'red'); // Set warna pesan menjadi merah
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('message', 'Gagal menghapus data.');
			$this->session->set_flashdata('message_type', 'red'); // Set warna pesan menjadi merah
		}
	}
}
