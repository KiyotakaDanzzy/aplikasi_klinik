<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('transaksi/Pembayaran_model');
    }

    public function index()
    {
        $data['title'] = 'Pembayaran';
        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/pembayaran', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_pasien = $this->Pembayaran_model->get_pasien_belum_bayar($cari);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data_pasien), 'data' => $data_pasien]);
    }

    public function get_detail_pembayaran()
    {
        $kode_invoice = $this->input->post('kode_invoice');
        $detail = $this->Pembayaran_model->get_full_detail_by_invoice($kode_invoice);
        header('Content-Type: application/json');
        echo json_encode(['status' => !empty($detail), 'data' => $detail]);
    }

    public function bayar_aksi()
    {
        $kode_invoice = $this->input->post('kode_invoice');
        $data = [
            'metode_pembayaran' => $this->input->post('metode_pembayaran'),
            'bank' => $this->input->post('bank'),
            'bayar' => preg_replace('/[^0-9]/', '', $this->input->post('bayar')),
            'kembali' => preg_replace('/[^0-9]/', '', $this->input->post('kembali')),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s')
        ];

        $simpan = $this->Pembayaran_model->update_pembayaran($kode_invoice, $data);
        $response = [
            'status' => $simpan,
            'message' => $simpan ? 'Pembayaran berhasil disimpan.' : 'Gagal menyimpan pembayaran.',
            'kode_invoice' => $kode_invoice
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function cetak_struk($kode_invoice)
    {
        $data['title'] = 'Struk Pembayaran';
        $data['data'] = $this->Pembayaran_model->get_full_detail_by_invoice($kode_invoice);
        $this->load->view('transaksi/cetak/struk', $data);
    }

    public function cetak_kwitansi($kode_invoice)
    {
        $data['title'] = 'Kwitansi Pembayaran';
        $data['data'] = $this->Pembayaran_model->get_full_detail_by_invoice($kode_invoice);
        $this->load->view('transaksi/cetak/kwitansi', $data);
    }
}