<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/Pegawai_model');
        $this->load->model('kepegawaian/Jabatan_model');
        $this->load->model('master_data/Poli_model');
    }

    public function index()
    {
        $data['title'] = 'Pegawai';
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/pegawai', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_pegawai = $this->Pegawai_model->get_data_pegawai($cari);
        $response = [];
        if ($data_pegawai) {
            $response['result'] = true;
            $response['data'] = $data_pegawai;
        } else {
            $response['result'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Pegawai';
        $data['data_jabatan'] = $this->Jabatan_model->get_data_jabatan();
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/pegawai/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $simpan = $this->Pegawai_model->insert_pegawai_dan_dokter();
        header('Content-Type: application/json');
        echo json_encode($simpan);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Pegawai';
        $data['row'] = $this->Pegawai_model->get_pegawai_by_id($id);
        $data['data_jabatan'] = $this->Jabatan_model->get_data_jabatan();
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $data['dokter_info'] = $this->Pegawai_model->get_dokter_info_by_pegawai_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/pegawai/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $update = $this->Pegawai_model->update_pegawai_dan_dokter();
        header('Content-Type: application/json');
        echo json_encode($update);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Pegawai_model->delete_pegawai($id);
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