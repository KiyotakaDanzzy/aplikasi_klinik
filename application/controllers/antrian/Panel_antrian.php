<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panel_antrian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('antrian/Antrian_model');
    }

    public function index()
    {
        $data['title'] = 'Antrian';
        $data['stats'] = $this->Antrian_model->get_ringkasan();
        $data['dipanggil'] = $this->Antrian_model->get_antrian_dipanggil();
        $data['selanjutnya'] = $this->Antrian_model->get_lanjut();
        $this->load->view('antrian/panel_antrian', $data);
    }

    public function get_update()
    {
        $data['stats'] = $this->Antrian_model->get_ringkasan();
        $data['dipanggil'] = $this->Antrian_model->get_antrian_dipanggil();
        $data['selanjutnya'] = $this->Antrian_model->get_lanjut();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}