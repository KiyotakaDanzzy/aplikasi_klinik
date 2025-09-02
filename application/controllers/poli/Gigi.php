<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gigi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('poli/Gigi_model');
        $this->load->model('master_data/Diagnosa_model');
        $this->load->model('master_data/Tindakan_model');
    }

    public function index()
    {
        $data['title'] = "Poli Gigi";
        $this->load->view('templates/header', $data);
        $this->load->view('poli/gigi', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_pasien = $this->Gigi_model->get_pasien_poli_gigi($cari);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data_pasien), 'data' => $data_pasien]);
    }

    public function proses($kode_invoice)
    {
        $rekam_medis = $this->Gigi_model->get_or_create_rekam_medis($kode_invoice);
        if ($rekam_medis) {
            redirect('poli/gigi/view_proses/' . $rekam_medis['id']);
        } else {
            redirect('poli/gigi');
        }
    }

    public function view_proses($id_pol_gigi = null)
    {
        if ($id_pol_gigi == null) {
            redirect('poli/gigi');
        }
        $data['title'] = "Proses Poli Gigi";
        $data['data'] = $this->Gigi_model->get_rekam_medis_detail($id_pol_gigi);

        if (empty($data['data']['rekam_medis'])) {
            redirect('poli/gigi');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('poli/gigi/proses', $data);
        $this->load->view('templates/footer');
    }

    public function proses_aksi()
    {
        $data = $this->input->post();
        $simpan = $this->Gigi_model->save_rekam_medis($data);
        $response = ['status' => $simpan, 'message' => $simpan ? 'Rekam medis berhasil disimpan.' : 'Gagal menyimpan rekam medis.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function search_diagnosa()
    {
        $cari = $this->input->post('cari');
        $data = $this->Diagnosa_model->get_data_diagnosa($cari, 0);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function search_tindakan()
    {
        $cari = $this->input->post('cari');
        $data = $this->Tindakan_model->get_data_tindakan($cari, 0);
        foreach ($data as $item) {
            $item->harga_raw = (int) str_replace(',', '', $item->harga);
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function search_obat()
    {
        $cari = $this->input->post('cari');
        $data = $this->Gigi_model->get_data_barang($cari);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function tambah_diagnosa_ajax()
    {
        $nama_diagnosa = $this->input->post('nama_diagnosa');
        if (empty($nama_diagnosa)) {
            echo json_encode(['status' => false, 'message' => 'Nama diagnosa tidak boleh kosong']);
            return;
        }
        $data = [
            'nama_diagnosa' => $nama_diagnosa,
            'id_poli' => 4,
            'nama_poli' => 'Poli Gigi'
        ];
        $new_id = $this->Diagnosa_model->insert_master_data($data);
        $new_data = $this->Diagnosa_model->get_diagnosa_by_id($new_id);
        echo json_encode(['status' => true, 'data' => $new_data]);
    }

    public function tambah_tindakan_ajax()
    {
        $nama_tindakan = $this->input->post('nama_tindakan');
        $harga = preg_replace('/[^0-9]/', '', $this->input->post('harga'));
        if (empty($nama_tindakan)) {
            echo json_encode(['status' => false, 'message' => 'Nama tindakan tidak boleh kosong']);
            return;
        }
        $data = [
            'nama' => $nama_tindakan,
            'harga' => $harga,
            'id_poli' => 4,
            'nama_poli' => 'Poli Gigi'
        ];
        $new_id = $this->Tindakan_model->insert_master_data($data);
        $new_data = $this->Tindakan_model->get_tindakan_by_id($new_id);
        echo json_encode(['status' => true, 'data' => $new_data]);
    }
}
