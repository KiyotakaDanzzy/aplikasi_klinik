<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_data/Poli_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Poli';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/Poli', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_poli = $this->Poli_model->get_data_poli($cari);
        
        $response = [];
        if ($data_poli) {
            $response['result'] = true;
            $response['data'] = $data_poli;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Poli';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/poli/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $data = [
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama')
        ];
        $simpan = $this->Poli_model->insert_poli($data);
        
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
        $data['title'] = 'Poli';
        $data['row'] = $this->Poli_model->get_poli_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/poli/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $data = [
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama')
        ];
        $update = $this->Poli_model->update_poli($id, $data);

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
        $delete = $this->Poli_model->delete_poli($id);

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