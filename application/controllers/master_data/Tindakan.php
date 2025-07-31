<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tindakan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_data/Tindakan_model');
        $this->load->model('master_data/Poli_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Tindakan';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/Tindakan', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_tindakan = $this->Tindakan_model->get_data_tindakan($cari);

        $response = [];
        if ($data_tindakan) {
            $response['result'] = true;
            $response['data'] = $data_tindakan;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Tindakan';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/tindakan/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'nama' => $this->input->post('nama'),
            'harga' => preg_replace('/[^0-9]/', '', $this->input->post('harga')),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : ''
        ];

        $simpan = $this->Tindakan_model->insert_tindakan($data);

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
        $data['title'] = 'Tindakan';
        $data['row'] = $this->Tindakan_model->get_tindakan_by_id($id);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/tindakan/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'nama' => $this->input->post('nama'),
            'harga' => preg_replace('/[^0-9]/', '', $this->input->post('harga')),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : ''
        ];

        $update = $this->Tindakan_model->update_tindakan($id, $data);

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
        $delete = $this->Tindakan_model->delete_tindakan($id);

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