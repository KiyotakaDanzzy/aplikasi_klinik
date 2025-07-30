<?php

 class Pasien extends CI_Controller
 {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('master_data/pasien/Pasien_model');
            $this->load->helper('url');
        }

        public function index()
        {
            $data['title'] = 'Master Pasien';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/footer');
        }


 }

?>