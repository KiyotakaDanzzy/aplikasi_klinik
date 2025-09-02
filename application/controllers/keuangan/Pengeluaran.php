<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengeluaran extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan/Pengeluaran_model');
        $this->load->model('keuangan/Jenis_biaya_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Pengeluaran';
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pengeluaran', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        header('Content-Type: application/json');
        $cari = $this->input->post('cari');
        $data_pengeluaran = $this->Pengeluaran_model->get_data_pengeluaran($cari);

        $response = [];
        if ($data_pengeluaran) {
            $response['result'] = true;
            $response['data'] = $data_pengeluaran;
        } else {
            $response['result'] = false;
        }

        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Pengeluaran';
        $data['data_jenis'] = $this->Jenis_biaya_model->get_data_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pengeluaran/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        header('Content-Type: application/json');
        $nominal = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));
        $jenis_biaya = $this->Jenis_biaya_model->get_jenis_by_id($this->input->post('id_jenis_biaya'));

        $data = [
            'id_jenis_biaya' => $this->input->post('id_jenis_biaya'),
            'nama_jenis_biaya' => $jenis_biaya ? $jenis_biaya['nama'] : '',
            'keterangan' => $this->input->post('keterangan'),
            'nominal' => $nominal,
            'tanggal' => date('d-m-Y'), 
            'waktu' => date('H:i:s')
        ];

        $simpan = $this->Pengeluaran_model->insert_pengeluaran($data);

        $response = [];
        if ($simpan) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil disimpan.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menyimpan data.';
        }

        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Pengeluaran';
        $data['row'] = $this->Pengeluaran_model->get_pengeluaran_by_id($id);
        $data['data_jenis'] = $this->Jenis_biaya_model->get_data_jenis();

        if (!$data['row']) {
            redirect('keuangan/pengeluaran');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pengeluaran/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $nominal = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));
        $jenis_biaya = $this->Jenis_biaya_model->get_jenis_by_id($this->input->post('id_jenis_biaya'));

        $data = [
            'id_jenis_biaya' => $this->input->post('id_jenis_biaya'),
            'nama_jenis_biaya' => $jenis_biaya ? $jenis_biaya['nama'] : '',
            'keterangan' => $this->input->post('keterangan'),
            'nominal' => $nominal,
        ];

        $update = $this->Pengeluaran_model->update_pengeluaran($id, $data);

        $response = [];
        if ($update) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil diperbarui.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal memperbarui data.';
        }

        echo json_encode($response);
    }

    public function hapus()
    {
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $delete = $this->Pengeluaran_model->delete_pengeluaran($id);

        $response = [];
        if ($delete) {
            $response['status'] = true;
            $response['message'] = 'Data berhasil dihapus.';
        } else {
            $response['status'] = false;
            $response['message'] = 'Gagal menghapus data.';
        }

        echo json_encode($response);
    }
}
