<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grup_Hak_Akses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login/login');
        }
        $this->load->model('admin/Grup_hak_akses_model');
    }

    public function index()
    {
        $data['title'] = 'Grup Hak Akses';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/grup_hak_akses', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_grup_hak_akses = $this->Grup_hak_akses_model->get_data_grup($cari);

        $response = [];
        if ($data_grup_hak_akses) {
            $response['result'] = true;
            $response['data'] = $data_grup_hak_akses;
        } else {
            $response['result'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Grup Hak Akses';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/grup_hak_akses/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $data = ['nama_grup_hak_akses' => $this->input->post('nama_grup')];
        $simpan = $this->Grup_hak_akses_model->insert_grup($data);

        $response = [];
        if ($simpan) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menyimpan data atau data sudah ada.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Grup Hak Akses';
        $data['row'] = $this->Grup_hak_akses_model->get_grup_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('admin/grup_hak_akses/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $data = ['nama_grup_hak_akses' => $this->input->post('nama_grup')];
        $update = $this->Grup_hak_akses_model->update_grup($id, $data);

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
        $delete = $this->Grup_hak_akses_model->delete_grup($id);

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
