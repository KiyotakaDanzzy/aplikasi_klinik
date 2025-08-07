<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_data/Pasien_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Pasien';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/pasien', $data);
        $this->load->view('templates/footer');
    }

    public function get_detail_pasien()
    {
        $id = $this->input->post('id');
        $pasien_data = $this->Pasien_model->get_pasien_by_id($id);

        if ($pasien_data) {
            unset($pasien_data['id']);
            // unset($pasien_data['password']);
            $response = ['status' => true, 'data' => $pasien_data];
        } else {
            $response = ['status' => false, 'message' => 'Data pasien tidak ditemukan.'];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_pasien = $this->Pasien_model->get_data_pasien($cari);
        $response = [];
        if ($data_pasien) {
            $response['result'] = true;
            $response['data'] = $data_pasien;
        } else {
            $response['result'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Pasien';
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/pasien/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
        // $this->form_validation->set_rules('username', 'Username', 'required|is_unique[mst_pasien.username]');
        // $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $response = ['status' => false, 'message' => validation_errors()];
        } else {
            $data = $this->input->post();
            $simpan = $this->Pasien_model->insert_pasien($data);
            if ($simpan) {
                $response = ['status' => true, 'message' => 'Data pasien berhasil ditambahkan.'];
            } else {
                $response = ['status' => false, 'message' => 'Gagal menambahkan data pasien.'];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Pasien';
        $data['pasien'] = $this->Pasien_model->get_pasien_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('master_data/pasien/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
        
        if ($this->form_validation->run() == FALSE) {
            $response = ['status' => false, 'message' => validation_errors()];
        } else {
            $data = $this->input->post();
            unset($data['id']); 
            $update = $this->Pasien_model->update_pasien($id, $data);
            if ($update) {
                $response = ['status' => true, 'message' => 'Data pasien berhasil diperbarui'];
            } else {
                $response = ['status' => false, 'message' => 'Gagal memperbarui data'];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Pasien_model->delete_pasien($id);
        if ($delete) {
            $response = ['status' => true, 'message' => 'Data berhasil dihapus'];
        } else {
            $response = ['status' => false, 'message' => 'Gagal menghapus data'];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}