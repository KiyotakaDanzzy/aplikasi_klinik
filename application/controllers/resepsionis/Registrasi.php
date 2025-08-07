<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('resepsionis/Registrasi_model');
        $this->load->model('antrian/Antrian_model');
        $this->load->model('master_data/Pasien_model');
        $this->load->model('master_data/Poli_model');
        $this->load->model('kepegawaian/Dokter_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Registrasi';
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/registrasi', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $data_registrasi = $this->Registrasi_model->get_data_registrasi($cari);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data_registrasi), 'data' => $data_registrasi]);
    }

    public function get_detail_registrasi()
    {
        $id = $this->input->post('id');
        $reg_data = $this->Registrasi_model->get_registrasi_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => !empty($reg_data), 'data' => $reg_data]);
    }

    public function view_tambah()
    {
        $data['title'] = 'Registrasi';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/registrasi/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $tipe_pasien = $this->input->post('tipe_pasien');
        $this->db->trans_begin();
        $id_pasien_final = null;
        $pasien_data = [];

        if ($tipe_pasien == 'baru') {
            $pasien_input = $this->input->post('pasien');
            $this->Pasien_model->insert_pasien($pasien_input);
            $id_pasien_final = $this->db->insert_id();
            $pasien_data = $this->Pasien_model->get_pasien_by_id($id_pasien_final);
        } else {
            $id_pasien_final = $this->input->post('id_pasien');
            $pasien_data = $this->Pasien_model->get_pasien_by_id($id_pasien_final);
        }

        if (empty($id_pasien_final) || empty($pasien_data)) {
            $this->db->trans_rollback();
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'message' => 'Data pasien tidak valid.']);
            return;
        }

        $poli = $this->Poli_model->get_poli_by_id($this->input->post('id_poli'));
        $dokter = $this->Dokter_model->get_dokter_by_id($this->input->post('id_dokter'));

        $data_registrasi = [
            'id_booking' => null,
            'kode_booking' => null,
            'id_pasien' => $id_pasien_final,
            'nik' => $pasien_data['nik'],
            'nama_pasien' => $pasien_data['nama_pasien'],
            'id_poli' => $poli['id'],
            'nama_poli' => $poli['nama'],
            'id_dokter' => $dokter['id'],
            'nama_dokter' => $dokter['nama_pegawai'],
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s')
        ];
        $registrasi_result = $this->Registrasi_model->insert_registrasi($data_registrasi);

        if ($registrasi_result && !empty($registrasi_result['id'])) {
            $data_antrian = [
                'id_registrasi' => $registrasi_result['id'],
                'kode_invoice' => $registrasi_result['kode_invoice'],
                'id_poli' => $poli['id'],
                'id_dokter' => $dokter['id'],
                'id_pasien' => $id_pasien_final,
                'tanggal' => date('Y-m-d'),
            ];
            $this->Antrian_model->insert_antrian($data_antrian);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = ['status' => false, 'message' => 'Gagal melakukan registrasi.'];
        } else {
            $this->db->trans_commit();
            $response = ['status' => true, 'message' => 'Registrasi berhasil dan pasien masuk antrian.'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Registrasi';
        $data['registrasi'] = $this->Registrasi_model->get_registrasi_by_id($id);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $data['data_dokter'] = $this->Dokter_model->get_dokter_by_poli($data['registrasi']['id_poli']);
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/registrasi/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $poli = $this->Poli_model->get_poli_by_id($this->input->post('id_poli'));
        $dokter = $this->Dokter_model->get_dokter_by_id($this->input->post('id_dokter'));

        $data = [
            'id_poli' => $poli['id'],
            'nama_poli' => $poli['nama'],
            'id_dokter' => $dokter['id'],
            'nama_dokter' => $dokter['nama_pegawai'],
        ];

        $update = $this->Registrasi_model->update_registrasi($id, $data);
        $response = ['status' => $update, 'message' => $update ? 'Data registrasi berhasil diperbarui.' : 'Gagal memperbarui data.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Registrasi_model->delete_registrasi($id);
        $response = ['status' => $delete, 'message' => $delete ? 'Data registrasi dan antrian terkait berhasil dihapus.' : 'Gagal menghapus data.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
