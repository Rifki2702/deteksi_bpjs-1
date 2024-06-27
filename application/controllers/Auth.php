<?php

class Auth extends CI_Controller // Metode ini digunakan untuk menangani permintaan ke URL /auth.
{
	public function index()
	{
		show_404(); // Menampilkan halaman kesalahan 404
	}

	public function login() // Metode ini digunakan untuk menangani proses login.
	{
		$this->load->model('auth_model'); // Memuat model 'auth_model' yang digunakan untuk operasi otentikasi
		$this->load->library('form_validation'); // Memuat perpustakaan 'form_validation' yang digunakan untuk validasi form

		$rules = $this->auth_model->rules(); // Mendapatkan aturan validasi dari model 'auth_model'
		$this->form_validation->set_rules($rules); // Memeriksa apakah form validasi berjalan sesuai aturan

		if($this->form_validation->run() == FALSE){
						// Jika validasi gagal, memuat ulang tampilan login
			return $this->load->view('auth/login');
		}

		$username = $this->input->post('username'); // Mendapatkan nilai username dan password dari input form
		$password = $this->input->post('password');

				// Memeriksa kredensial pengguna melalui model 'auth_model'
		if($this->auth_model->login($username, $password)){  
						// Jika login berhasil, mengarahkan ke dashboard admin
			redirect('admin/dashboard');
		} else { 			// Jika login gagal, menetapkan pesan kesalahan flash
			$this->session->set_flashdata('message_login_error', 'Login Gagal, pastikan username dan password benar!');
		}

		$this->load->view('auth/login'); 	// Memuat ulang tampilan login
	}

public function register() {
        $this->load->model('auth_model');
        $this->load->library('form_validation');

        $rules = $this->auth_model->register_rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('auth/register');
        }

        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        if ($password === $password_confirm) {
            if ($this->auth_model->register($username, $email, $password)) {
                $this->session->set_flashdata('message_register_success', 'Registrasi berhasil, silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('message_register_error', 'Registrasi gagal, coba lagi.');
            }
        } else {
            $this->session->set_flashdata('message_register_error', 'Password dan konfirmasi password tidak cocok.');
        }

        $this->load->view('auth/register');
    }

	public function logout() 	// Metode ini digunakan untuk menangani proses logout.
	{
		$this->load->model('auth_model');  // Memuat model 'auth_model' yang digunakan untuk operasi otentikasi
		$this->auth_model->logout(); 		// Memanggil metode logout dari model 'auth_model'
		redirect(site_url('auth/login')); 		// Mengarahkan ke halaman login
	}
}
