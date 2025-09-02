<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panel_dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('antrian/Antrian_model');
        $this->load->model('master_data/Poli_model');
    }

    public function index()
    {
        $data['title'] = 'Antrian';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('antrian/panel_dokter', $data);
        $this->load->view('templates/footer');
    }

    public function get_urutan()
    {
        $id_poli = $this->input->post('id_poli');
        $status = $this->input->post('status');
        $data_antrian = $this->Antrian_model->get_antrian_list($id_poli, $status);
        header('Content-Type: application/json');
        echo json_encode($data_antrian);
    }

    public function panggil($id_antrian)
    {
        $panggil = $this->Antrian_model->panggil_pasien($id_antrian);
        header('Content-Type: application/json');
        echo json_encode(['status' => $panggil]);
    }

    public function konfirmasi($id_antrian)
    {
        $konfirmasi = $this->Antrian_model->konfirmasi_pasien($id_antrian);
        header('Content-Type: application/json');
        echo json_encode(['status' => $konfirmasi]);
    }
}