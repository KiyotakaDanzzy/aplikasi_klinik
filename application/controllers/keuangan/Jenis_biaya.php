<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_biaya extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan/Jenis_biaya_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Jenis Biaya';
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/jenis_biaya', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_jenis = $this->Jenis_biaya_model->get_data_jenis($cari);
        
        $response = [];
        if ($data_jenis) {
            $response['result'] = true;
            $response['data'] = $data_jenis;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Jenis Biaya';
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/jenis_biaya/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $data = [
            'nama' => $this->input->post('nama')
        ];
        $simpan = $this->Jenis_biaya_model->insert_jenis($data);
        
        $response = [];
        if ($simpan) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menyimpan dat.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Jenis Biaya';
        $data['row'] = $this->Jenis_biaya_model->get_jenis_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/jenis_biaya/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $data = [
            'nama' => $this->input->post('nama')
        ];
        $update = $this->Jenis_biaya_model->update_jenis($id, $data);

        $response = [];
        if ($update) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil diperbarui';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal memperbarui data';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Jenis_biaya_model->delete_jenis($id);

        $response = [];
        if ($delete) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menghapus data';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}