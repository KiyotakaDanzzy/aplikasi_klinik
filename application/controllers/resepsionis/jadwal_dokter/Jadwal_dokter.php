<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('resepsionis/jadwal_dokter/Jadwal_dokter_model');
        $this->load->model('kepegawaian/dokter/Dokter_model');
        $this->load->model('master_data/poli/Poli_model');
    }

    private function process_schedule_data($raw_schedule)
    {
        $processed = [];
        $days_of_week = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($raw_schedule as $item) {
            $poli = $item->nama_poli;
            $dokter_id = $item->id_pegawai;
            $dokter_nama = $item->nama_pegawai;
            $hari = $item->hari;
            $jam = $item->jam_mulai . ' - ' . $item->jam_selesai;

            if (!isset($processed[$poli])) {
                $processed[$poli] = [];
            }
            if (!isset($processed[$poli][$dokter_id])) {
                $processed[$poli][$dokter_id]['nama_dokter'] = $dokter_nama;
                foreach ($days_of_week as $day) {
                    $processed[$poli][$dokter_id]['jadwal'][$day] = '-';
                }
            }
            $processed[$poli][$dokter_id]['jadwal'][$hari] = $jam;
        }
        return $processed;
    }

    public function index()
    {
        $data['title'] = 'Jadwal Praktik Dokter';
        $jadwal_raw = $this->Jadwal_dokter_model->get_all_schedules_join();
        $data['schedule_data'] = $this->process_schedule_data($jadwal_raw);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/Jadwal_dokter', $data);
        $this->load->view('templates/footer');
    }

    public function filter_jadwal()
    {
        $id_poli = $this->input->post('id_poli');
        $jam = $this->input->post('jam');
        $jadwal_raw = $this->Jadwal_dokter_model->get_all_schedules_join($id_poli, $jam);
        $data['schedule_data'] = $this->process_schedule_data($jadwal_raw);
        $this->load->view('resepsionis/jadwal_dokter/Partial_jadwal', $data);
    }

    public function manage()
    {
        $data['title'] = 'Kelola Jadwal Dokter';
        $data['data_dokter'] = $this->Dokter_model->get_data_dokter();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/jadwal_dokter/Manage_jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id_dokter)
    {
        $data['title'] = 'Detail Jadwal Dokter';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        $data['jadwal'] = $this->Jadwal_dokter_model->get_jadwal_by_dokter_id($data['dokter']['id']);
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/jadwal_dokter/Detail_jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function view_tambah()
    {
        $data['title'] = 'Buat Jadwal Dokter';
        $data['data_dokter'] = $this->Dokter_model->get_data_dokter();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/jadwal_dokter/Tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_dokter = $this->input->post('id_dokter');
        $hari = $this->input->post('hari');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $simpan = $this->Jadwal_dokter_model->insert_jadwal_batch($id_dokter, $hari, $jam_mulai, $jam_selesai);
        header('Content-Type: application/json');
        echo json_encode(['status' => $simpan]);
    }

    public function view_edit($id_dokter)
    {
        $data['title'] = 'Edit Jadwal Dokter';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        $jadwal_existing_raw = $this->Jadwal_dokter_model->get_jadwal_by_dokter_id($id_dokter);
        $jadwal_existing = [];
        foreach($jadwal_existing_raw as $j) {
            $jadwal_existing[$j['hari']] = $j;
        }
        $data['jadwal'] = $jadwal_existing;
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/jadwal_dokter/Edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id_dokter = $this->input->post('id_dokter');
        $hari = $this->input->post('hari');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $update = $this->Jadwal_dokter_model->update_jadwal_batch($id_dokter, $hari, $jam_mulai, $jam_selesai);
        header('Content-Type: application/json');
        echo json_encode(['status' => $update]);
    }

    public function hapus_by_dokter($id_dokter)
    {
        $delete = $this->Jadwal_dokter_model->delete_by_dokter_id($id_dokter);
        header('Content-Type: application/json');
        echo json_encode(['status' => $delete]);
    }
}