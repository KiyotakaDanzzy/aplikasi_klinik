<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login/login');
        }
        $this->load->model('admin/Level_model');
    }

    public function index()
    {
        $data['title'] = 'Level';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/level', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data = $this->Level_model->get_data_level($cari);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data), 'data' => $data]);
    }

    public function view_tambah()
    {
        $data['title'] = 'Level';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/level/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $data = ['nama_level' => $this->input->post('nama_level')];
        $simpan = $this->Level_model->insert_level($data);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => $simpan, 
            'message' => $simpan ? 'Data berhasil disimpan.' : 'Gagal simpan / Nama Level sudah ada.'
        ]);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Level';
        $data['row'] = $this->Level_model->get_level_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('admin/level/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $data = ['nama_level' => $this->input->post('nama_level')];
        $update = $this->Level_model->update_level($id, $data);

        header('Content-Type: application/json');
        echo json_encode(['status' => $update, 'message' => $update ? 'Data diperbarui.' : 'Gagal diperbarui.']);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Level_model->delete_level($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => $delete, 'message' => $delete ? 'Data dihapus.' : 'Gagal hapus.']);
    }
}