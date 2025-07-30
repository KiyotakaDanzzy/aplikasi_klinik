<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/Dokter/Dokter_model');
    }

    public function index()
    {
        $data['title'] = 'Laporan Data Dokter';
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/Dokter', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_dokter = $this->Dokter_model->get_data_dokter($cari);

        $response = [];
        if ($data_dokter) {
            $response['result'] = true;
            $response['data'] = $data_dokter;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}