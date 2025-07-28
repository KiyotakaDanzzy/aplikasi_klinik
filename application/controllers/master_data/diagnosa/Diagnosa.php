<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnosa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_data/diagnosa/Diagnosa_model');
        $this->load->model('master_data/poli/Poli_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Master Diagnosa';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/Diagnosa', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_diagnosa = $this->Diagnosa_model->get_data_diagnosa($cari);
        
        $response = [];
        if ($data_diagnosa) {
            $response['result'] = true;
            $response['data'] = $data_diagnosa;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Master Diagnosa';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/diagnosa/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'nama_diagnosa' => $this->input->post('nama_diagnosa'),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : null
        ];
        
        $simpan = $this->Diagnosa_model->insert_diagnosa($data);
        
        $response = [];
        if ($simpan) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menyimpan data.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Master Diagnosa';
        $data['row'] = $this->Diagnosa_model->get_diagnosa_by_id($id);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/diagnosa/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'nama_diagnosa' => $this->input->post('nama_diagnosa'),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : null
        ];

        $update = $this->Diagnosa_model->update_diagnosa($id, $data);

        $response = [];
        if ($update) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil diperbarui.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal memperbarui data.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Diagnosa_model->delete_diagnosa($id);

        $response = [];
        if ($delete) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menghapus data.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}