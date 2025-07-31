<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/Jabatan_model');
    }

    public function index()
    {
        $data['title'] = 'Jabatan';
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/Jabatan', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_jabatan = $this->Jabatan_model->get_data_jabatan($cari);

        $response = [];
        if ($data_jabatan) {
            $response['result'] = true;
            $response['data'] = $data_jabatan;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Jabatan';
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/jabatan/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $data = ['nama' => $this->input->post('nama')];
        $simpan = $this->Jabatan_model->insert_jabatan($data);

        $response = [];
        if ($simpan) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menyimpan data';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Jabatan';
        $data['row'] = $this->Jabatan_model->get_jabatan_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/jabatan/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $data = ['nama' => $this->input->post('nama')];
        $update = $this->Jabatan_model->update_jabatan($id, $data);

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
        $delete = $this->Jabatan_model->delete_jabatan($id);

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