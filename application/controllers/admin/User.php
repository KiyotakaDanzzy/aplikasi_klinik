<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login/login');
        }
        $this->load->model('admin/User_model');
    }

    public function index()
    {
        $data['title'] = 'User';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data = $this->User_model->get_data_user($cari);

        $response = [];
        if ($data) {
            $response['result'] = true;
            $response['data'] = $data;
        } else {
            $response['result'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'User';
        $data['level_list'] = $this->User_model->get_level_list();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/user/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_level = $this->input->post('id_level');

        $level_data = $this->db->get_where('adm_level', ['id' => $id_level])->row();
        $nama_level = $level_data ? $level_data->nama_level : '';

        $data = [
            'id_pegawai' => $this->input->post('id_pegawai'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'id_level' => $id_level,
            'nama_level' => $nama_level,
            'status' => 'Aktif'
        ];

        $simpan = $this->User_model->insert_user($data);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => $simpan,
            'message' => $simpan ? 'User berhasil ditambahkan.' : 'Gagal simpan / Username sudah ada.'
        ]);
    }

    public function view_edit($id)
    {
        $data['title'] = 'User';
        $data['row'] = $this->User_model->get_user_by_id($id);
        $data['level_list'] = $this->User_model->get_level_list();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/user/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $id_level = $this->input->post('id_level');

        $level_data = $this->db->get_where('adm_level', ['id' => $id_level])->row();
        $nama_level = $level_data ? $level_data->nama_level : '';

        $data = [
            'username' => $this->input->post('username'),
            'id_level' => $id_level,
            'nama_level' => $nama_level,
            'status' => $this->input->post('status')
        ];

        $password_baru = $this->input->post('password');
        if (!empty($password_baru)) {
            $data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $update = $this->User_model->update_user($id, $data);

        header('Content-Type: application/json');
        echo json_encode(['status' => $update, 'message' => $update ? 'Data diperbarui.' : 'Gagal update.']);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->User_model->delete_user($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => $delete, 'message' => $delete ? 'Data dihapus.' : 'Gagal hapus.']);
    }

    public function get_pegawai_list()
    {
        $cari = $this->input->post('cari');
        $data = $this->User_model->get_pegawai_list($cari);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_detail_user()
    {
        $id = $this->input->post('id');
        $data = $this->User_model->get_user_by_id($id);

        $jabatan = '-';
        if ($data && $data['id_pegawai']) {
            $peg = $this->db->get_where('kpg_pegawai', ['id' => $data['id_pegawai']])->row();
            $jabatan = $peg ? $peg->nama_jabatan : '-';
        }
        $data['jabatan_asli'] = $jabatan;

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
