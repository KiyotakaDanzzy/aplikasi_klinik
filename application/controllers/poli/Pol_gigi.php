<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pol_gigi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('poli/Pol_gigi_model', 'pol_gigi');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = "Data Poli Gigi";
        $this->load->view('templates/header', $data);
        $this->load->view('poli/v_pol_gigi', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_pol_gigi = $this->pol_gigi->get_data($cari);

        $response = ($data_pol_gigi) ?
            ['result' => true, 'data' => $data_pol_gigi] :
            ['result' => false, 'data' => null];

        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = "Data Poli Gigi";
        $this->load->view('templates/header', $data);
        $this->load->view('poli/v_pol_gigi_tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = $this->input->post();
        $insert = $this->pol_gigi->insert_data($data);

        $response = ($insert) ?
            ['status' => true, 'message' => 'Data berhasil ditambahkan!'] :
            ['status' => false, 'message' => 'Gagal menambahkan data!'];

        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = "Data Poli Gigi";
        $data['row'] = $this->pol_gigi->get_data_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('poli/v_pol_gigi_edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = $this->input->post();
        $update = $this->pol_gigi->update_data($id, $data);

        $response = ($update) ?
            ['status' => true, 'message' => 'Data berhasil diperbarui!'] :
            ['status' => false, 'message' => 'Gagal memperbarui data!'];

        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->pol_gigi->delete_data($id);

        $response = ($delete) ?
            ['status' => true, 'message' => 'Data berhasil dihapus!'] :
            ['status' => false, 'message' => 'Gagal menghapus data!'];

        echo json_encode($response);
    }
}
