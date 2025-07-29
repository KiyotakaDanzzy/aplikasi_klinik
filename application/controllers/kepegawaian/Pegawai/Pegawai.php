<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/pegawai/Pegawai_model');
        $this->load->model('kepegawaian/jabatan/Jabatan_model');
    }

    public function index()
    {
        $data['title'] = 'Master Pegawai';
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/Pegawai', $data);
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
        $data['title'] = 'Tambah Pegawai';
        $data['data_jabatan'] = $this->Jabatan_model->get_data_jabatan();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/pegawai/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_jabatan = $this->input->post('id_jabatan');
        $jabatan = $this->Jabatan_model->get_jabatan_by_id($id_jabatan);

        $data = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'id_jabatan' => $id_jabatan,
            'nama_jabatan' => $jabatan ? $jabatan['nama'] : ''
        ];

        $simpan = $this->Pegawai_model->insert_pegawai($data);

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
        $data['title'] = 'Edit Pegawai';
        $data['row'] = $this->Pegawai_model->get_pegawai_by_id($id);
        $data['data_jabatan'] = $this->Jabatan_model->get_data_jabatan();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/pegawai/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $id_jabatan = $this->input->post('id_jabatan');
        $jabatan = $this->Jabatan_model->get_jabatan_by_id($id_jabatan);

        $data = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'id_jabatan' => $id_jabatan,
            'nama_jabatan' => $jabatan ? $jabatan['nama'] : ''
        ];

        $update = $this->Pegawai_model->update_pegawai($id, $data);

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
        $delete = $this->Pegawai_model->delete_pegawai($id);

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