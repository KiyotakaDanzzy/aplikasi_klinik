<?php

class Antrian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('antrian/Antrian_model');
        $this->load->model('kepegawaian/Dokter_model');
        $this->load->model('master_data/Poli_model');
        $this->load->model('master_data/Pasien_model');
        $this->load->model('antrian/Antrian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Antrian';
        $this->load->view('templates/header', $data);
        $this->load->view('antrian/panel_antrian', $data);
        $this->load->view('templates/footer');
    }

    public function index_dokter()
    {
        $data['title'] = 'Antrian';
        $this->load->view('templates/header', $data);
        $this->load->view('antrian/panel_dokter', $data);
        $this->load->view('templates/footer');
    }


}

?>