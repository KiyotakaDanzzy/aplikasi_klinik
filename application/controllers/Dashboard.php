<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        if (!$this->session->userdata('logged_in')) {
            redirect('login/login');
        }

        $level = $this->session->userdata('nama_level');

        if ($level == 'Administrator') {
            redirect('master_data/poli');
        } elseif ($level == 'Dokter') {
            redirect('antrian/panel_dokter');
        } elseif ($level == 'Resepsionis') {
            redirect('resepsionis/registrasi');
        } else {
            $this->load->view('welcome_message');
        }
	}
}