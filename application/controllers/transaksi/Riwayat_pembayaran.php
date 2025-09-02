<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/Pembayaran_model');
    }

    public function index()
    {
        $data['title'] = 'Riwayat';
        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/riwayat_pembayaran', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_riwayat = $this->Pembayaran_model->get_riwayat_pembayaran($cari);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data_riwayat), 'data' => $data_riwayat]);
    }

    public function get_detail_riwayat()
    {
        $id = $this->input->post('id');
        $detail = $this->Pembayaran_model->get_full_detail_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => !empty($detail), 'data' => $detail]);
    }
}