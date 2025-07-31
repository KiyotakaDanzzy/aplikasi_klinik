<?php

 class Pasien extends CI_Controller
 {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('master_data/Pasien_model');
            $this->load->helper('url');
        }

        public function index()
        {
            $data['title'] = 'Pasien';
            $this->load->view('templates/header', $data);
            $this->load->view('master_data/Pasien', $data);
            $this->load->view('templates/footer');
        }

        public function tambah()
        {

        }

        public function tambah_view()
        {
            $data['title'] = 'Pasien';
            $this->load->view('templates/header', $data);
            $this->load->view('master_data/pasien/Tambah', $data);
            $this->load->view('templates/footer');
        }

        public function edit()
        {

        }

        public function edit_view($id)
        {
            $data['title'] = 'Pasien';
            $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id);
            if (!$data['pasien']) {
                show_404();
            }
            $this->load->view('templates/header', $data);
            $this->load->view('master_data/pasien/Edit', $data);
            $this->load->view('templates/footer');
        }
 }

?>