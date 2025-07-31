<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kepegawaian/Jadwal_dokter_model');
        $this->load->model('kepegawaian/Dokter_model');
        $this->load->model('master_data/Poli_model');
    }

    private function process_schedule_data($raw_schedule)
    {
        $processed = [];
        $days_of_week = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($raw_schedule as $item) {
            $poli = $item->nama_poli;
            $dokter_id = $item->id_pegawai;

            if (!isset($processed[$poli][$dokter_id])) {
                $processed[$poli][$dokter_id]['nama_dokter'] = $item->nama_pegawai;
                $processed[$poli][$dokter_id]['id_kpg_dokter'] = $item->id_kpg_dokter;
                foreach ($days_of_week as $day) {
                    $processed[$poli][$dokter_id]['jadwal'][$day] = '-';
                }
            }
            $processed[$poli][$dokter_id]['jadwal'][$item->hari] = $item->jam_mulai . ' - ' . $item->jam_selesai;
        }
        return $processed;
    }

    public function index()
    {
        $data['title'] = 'Dokter';
        $jadwal_raw = $this->Jadwal_dokter_model->get_all_schedules_join();
        $data['schedule_data'] = $this->process_schedule_data($jadwal_raw);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/Dokter', $data);
        $this->load->view('templates/footer');
    }

    public function index_jadwal()
    {
        $data['title'] = 'Jadwal Dokter';
        $jadwal_raw = $this->Jadwal_dokter_model->get_all_schedules_join();
        $data['schedule_data'] = $this->process_schedule_data($jadwal_raw);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/Jadwal_dokter', $data);
        $this->load->view('templates/footer');
    }

    public function filter_jadwal()
    {
        $id_poli = $this->input->post('id_poli');
        $jam = $this->input->post('jam');
        $jadwal_raw = $this->Jadwal_dokter_model->get_all_schedules_join($id_poli);
        if ($jam && !empty($jadwal_raw)) {
            $jadwal_cocok = [];
            $dokter_yang_cocok = [];
            foreach ($jadwal_raw as $jadwal) {
                $jam_mulai = $jadwal->jam_mulai;
                $jam_selesai = $jadwal->jam_selesai;
                $is_match = false;
                if ($jam_mulai <= $jam_selesai) {
                    if ($jam >= $jam_mulai && $jam <= $jam_selesai) {
                        $is_match = true;
                    }
                } else {
                    if ($jam >= $jam_mulai || $jam <= $jam_selesai) {
                        $is_match = true;
                    }
                }
                if ($is_match) {
                    $dokter_yang_cocok[$jadwal->id_pegawai] = true;
                }
            }
            if (!empty($dokter_yang_cocok)) {
                foreach ($jadwal_raw as $jadwal) {
                    if (isset($dokter_yang_cocok[$jadwal->id_pegawai])) {
                        $jadwal_cocok[] = $jadwal;
                    }
                }
            }

            $jadwal_raw = $jadwal_cocok;
        }
        $data['schedule_data'] = $this->process_schedule_data($jadwal_raw);
        $this->load->view('kepegawaian/dokter/Partial_jadwal', $data);
    }

    public function detail($id_dokter)
    {
        $data['title'] = 'Jadwal Dokter';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        $data['jadwal'] = $this->Jadwal_dokter_model->get_jadwal_by_dokter_id($id_dokter);

        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Detail_jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function view_tambah()
    {
        $data['title'] = 'Jadwal Dokter';
        $data['data_dokter'] = $this->Dokter_model->get_data_dokter();

        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Tambah_jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $id_dokter = $this->input->post('id_dokter');
        $hari = $this->input->post('hari');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');

        $simpan = $this->Jadwal_dokter_model->update_jadwal_batch($id_dokter, $hari, $jam_mulai, $jam_selesai);

        header('Content-Type: application/json');
        echo json_encode(['status' => $simpan, 'message' => $simpan ? 'Jadwal berhasil disimpan' : 'Gagal menyimpan jadwal']);
    }

    public function view_edit($id_dokter)
    {
        $data['title'] = 'Jadwal Dokter';
        $data['dokter'] = $this->Dokter_model->get_dokter_by_id($id_dokter);
        $jadwal_sekarang = $this->Jadwal_dokter_model->get_jadwal_by_dokter_id($id_dokter);

        $semua_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $hari_terjadwal = array_column($jadwal_sekarang, 'hari');
        $hari_tersedia = array_diff($semua_hari, $hari_terjadwal);
        $data['hari_tersedia'] = $hari_tersedia;

        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Edit_jadwal', $data);
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
        echo json_encode(['status' => $update, 'message' => $update ? 'Jadwal berhasil diperbarui' : 'Gagal memperbarui jadwal']);
    }

    public function hapus_by_dokter($id_dokter)
    {
        $delete = $this->Jadwal_dokter_model->delete_by_dokter_id($id_dokter);

        header('Content-Type: application/json');
        echo json_encode(['status' => $delete, 'message' => $delete ? 'Seluruh jadwal dokter berhasil dihapus' : 'Gagal menghapus jadwal']);
    }

    public function view_edit_entry($id_jadwal)
    {
        $data['title'] = 'Jadwal Dokter';
        $data['jadwal_entry'] = $this->Jadwal_dokter_model->get_jadwal_entry_by_id($id_jadwal);
        $data['dokter'] = $this->Dokter_model->get_dokter_by_pegawai_id($data['jadwal_entry']['id_pegawai']);
        $this->load->view('templates/header', $data);
        $this->load->view('kepegawaian/dokter/Entry_edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_entry_aksi()
    {
        $id_jadwal = $this->input->post('id_jadwal');
        $data = [
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai')
        ];
        $update = $this->Jadwal_dokter_model->update_jadwal_entry($id_jadwal, $data);
        $response = [
            'status' => $update,
            'message' => $update ? 'Jadwal harian berhasil diperbarui.' : 'Gagal memperbarui jadwal harian.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus_entry($id_jadwal)
    {
        $delete = $this->Jadwal_dokter_model->delete_jadwal_entry($id_jadwal);
        $response = [
            'status' => $delete,
            'message' => $delete ? 'Jadwal harian berhasil dihapus.' : 'Gagal menghapus jadwal harian.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function tambah_entry_aksi()
    {
        $id_dokter = $this->input->post('id_dokter');
        $dokter = $this->Dokter_model->get_dokter_by_id($id_dokter);

        $data = [
            'id_pegawai' => $dokter['id_pegawai'],
            'nama_pegawai' => $dokter['nama_pegawai'],
            'hari' => $this->input->post('hari'),
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai')
        ];

        $simpan = $this->Jadwal_dokter_model->insert_single_jadwal($data);
        $response = [
            'status' => $simpan,
            'message' => $simpan ? 'Jadwal berhasil ditambahkan' : 'Gagal menambahkan jadwal'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
