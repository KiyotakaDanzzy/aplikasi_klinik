<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan/Pemasukan_model');
        $this->load->model('keuangan/Jenis_biaya_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Pemasukan';
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pemasukan', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        header('Content-Type: application/json');
        $cari = $this->input->post('cari');
        $data_pemasukan = $this->Pemasukan_model->get_data_pemasukan($cari);

        $response = [];
        if ($data_pemasukan) {
            $response['result'] = true;
            $response['data'] = $data_pemasukan;
        } else {
            $response['result'] = false;
        }

        echo json_encode($response);
    }

    public function view_tambah()
    {
        $data['title'] = 'Pemasukan';
        $data['data_jenis'] = $this->Jenis_biaya_model->get_data_jenis();
        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pemasukan/tambah', $data);
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

        $simpan = $this->Pemasukan_model->insert_pemasukan($data);

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
        $data['title'] = 'Pemasukan';
        $data['row'] = $this->Pemasukan_model->get_pemasukan_by_id($id);
        $data['data_jenis'] = $this->Jenis_biaya_model->get_data_jenis();

        if (!$data['row']) {
            redirect('keuangan/pemasukan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('keuangan/pemasukan/edit', $data);
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

        $update = $this->Pemasukan_model->update_pemasukan($id, $data);

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
        $delete = $this->Pemasukan_model->delete_pemasukan($id);

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
