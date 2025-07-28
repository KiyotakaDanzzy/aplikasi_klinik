<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/dokter/Dokter_model');
        $this->load->model('master_data/poli/Poli_model');
    }

    public function index()
    {
        $data['title'] = 'Kepegawaian Dokter';
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

    public function view_tambah()
    {
        $data['title'] = 'Tambah Dokter';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'id_pegawai' => $this->input->post('id_pegawai'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : ''
        ];

        $simpan = $this->Dokter_model->insert_dokter($data);

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
        $data['title'] = 'Edit Dokter';
        $data['row'] = $this->Dokter_model->get_dokter_by_id($id);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $id_poli = $this->input->post('id_poli');
        $poli = $this->Poli_model->get_poli_by_id($id_poli);

        $data = [
            'id_pegawai' => $this->input->post('id_pegawai'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'id_poli' => $id_poli,
            'nama_poli' => $poli ? $poli['nama'] : ''
        ];

        $update = $this->Dokter_model->update_dokter($id, $data);

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
        $delete = $this->Dokter_model->delete_dokter($id);

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