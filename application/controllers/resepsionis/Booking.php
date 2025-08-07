<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('resepsionis/Booking_model');
        $this->load->model('master_data/Pasien_model');
        $this->load->model('master_data/Poli_model');
        $this->load->model('kepegawaian/Dokter_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Booking';
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/booking', $data);
        $this->load->view('templates/footer');
    }

    public function result_data()
    {
        $cari = $this->input->post('cari');
        $status = $this->input->post('status_booking'); 
        $data_booking = $this->Booking_model->get_data_booking($cari, $status);
        header('Content-Type: application/json');
        echo json_encode(['result' => !empty($data_booking), 'data' => $data_booking]);
    }
    
    public function get_detail_booking()
    {
        $id = $this->input->post('id');
        $booking_data = $this->Booking_model->get_booking_by_id($id);
        header('Content-Type: application/json');
        echo json_encode(['status' => !empty($booking_data), 'data' => $booking_data]);
    }

    public function get_pasien_list()
    {
        $cari = $this->input->post('cari');
        $data_pasien = $this->Pasien_model->get_data_pasien($cari);
        header('Content-Type: application/json');
        echo json_encode($data_pasien);
    }

    public function get_available_doctors()
    {
        $id_poli = $this->input->post('id_poli');
        $tanggal_from_form = $this->input->post('tanggal');
        $waktu = $this->input->post('waktu');

        $tanggal_db = '';
        $hari = '';

        if ($tanggal_from_form) {
            $date_obj = DateTime::createFromFormat('d-m-Y', $tanggal_from_form);
            if ($date_obj) {
                $tanggal_db = $date_obj->format('Y-m-d');
                $day_map = [
                    'Sunday'    => 'Minggu',
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday'  => 'Sabtu'
                ];
                $day_name_english = $date_obj->format('l');
                $hari = $day_map[$day_name_english];
            }
        }

        $data_dokter = $this->Dokter_model->get_available_doctors($id_poli, $tanggal_db, $waktu, $hari);
        header('Content-Type: application/json');
        echo json_encode($data_dokter);
    }


    public function view_tambah()
    {
        $data['title'] = 'Booking';
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/booking/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required');
        $this->form_validation->set_rules('id_poli', 'Poli', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal Kunjungan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = ['status' => false, 'message' => validation_errors()];
        } else {
            $pasien = $this->Pasien_model->get_pasien_by_id($this->input->post('id_pasien'));
            $poli = $this->Poli_model->get_poli_by_id($this->input->post('id_poli'));
            $dokter = $this->Dokter_model->get_dokter_by_id($this->input->post('id_dokter'));

            $data = [
                'id_pasien' => $pasien['id'],
                'nik' => $pasien['nik'],
                'nama_pasien' => $pasien['nama_pasien'],
                'id_poli' => $poli['id'],
                'nama_poli' => $poli['nama'],
                'id_dokter' => $dokter['id'],
                'nama_dokter' => $dokter['nama_pegawai'],
                'tanggal_booking' => date('d-m-Y H:i:s'),
                'tanggal' => $this->input->post('tanggal'),
                'waktu' => $this->input->post('waktu')
            ];

            $simpan = $this->Booking_model->insert_booking($data);
            $response = ['status' => $simpan, 'message' => $simpan ? 'Booking berhasil dibuat.' : 'Gagal membuat booking.'];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function view_edit($id)
    {
        $data['title'] = 'Booking';
        $data['booking'] = $this->Booking_model->get_booking_by_id($id);
        $data['data_poli'] = $this->Poli_model->get_data_poli();
        $this->load->view('templates/header', $data);
        $this->load->view('resepsionis/booking/edit', $data);
        $this->load->view('templates/footer');
    }

    public function edit_aksi()
    {
        $id = $this->input->post('id');
        $pasien = $this->Pasien_model->get_pasien_by_id($this->input->post('id_pasien'));
        $poli = $this->Poli_model->get_poli_by_id($this->input->post('id_poli'));
        $dokter = $this->Dokter_model->get_dokter_by_id($this->input->post('id_dokter'));

        $data = [
            'id_pasien' => $pasien['id'],
            'nik' => $pasien['nik'],
            'nama_pasien' => $pasien['nama_pasien'],
            'id_poli' => $poli['id'],
            'nama_poli' => $poli['nama'],
            'id_dokter' => $dokter['id'],
            'nama_dokter' => $dokter['nama_pegawai'],
            'tanggal' => $this->input->post('tanggal'),
            'waktu' => $this->input->post('waktu')
        ];

        $update = $this->Booking_model->update_booking($id, $data);
        $response = ['status' => $update, 'message' => $update ? 'Booking berhasil diperbarui.' : 'Gagal memperbarui booking.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function konfirmasi_booking()
    {
        $this->load->model('resepsionis/Registrasi_model');
        $this->load->model('antrian/Antrian_model');

        $id_booking = $this->input->post('id');
        $booking = $this->Booking_model->get_booking_by_id($id_booking);

        if (!$booking || $booking['status_booking'] != 'Pending') {
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'message' => 'Booking ini tidak valid atau sudah diproses.']);
            return;
        }

        $this->db->trans_begin();

        $data_registrasi = [
            'id_booking' => $booking['id'],
            'kode_booking' => $booking['kode_booking'],
            'id_pasien' => $booking['id_pasien'],
            'nik' => $booking['nik'],
            'nama_pasien' => $booking['nama_pasien'],
            'id_poli' => $booking['id_poli'],
            'nama_poli' => $booking['nama_poli'],
            'id_dokter' => $booking['id_dokter'],
            'nama_dokter' => $booking['nama_dokter'],
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s')
        ];
        $id_registrasi_baru = $this->Registrasi_model->insert_registrasi($data_registrasi);

        if ($id_registrasi_baru) {
            $data_antrian = [
                'id_registrasi' => $id_registrasi_baru['id'],
                'kode_invoice' => $id_registrasi_baru['kode_invoice'],
                'id_poli' => $booking['id_poli'],
                'id_dokter' => $booking['id_dokter'],
                'id_pasien' => $booking['id_pasien'],
                'tanggal' => date('d-m-Y')
            ];
            $this->Antrian_model->insert_antrian($data_antrian);
            $this->Booking_model->update_booking($id_booking, ['status_booking' => 'Disetujui']);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = ['status' => false, 'message' => 'Gagal mengkonfirmasi booking.'];
        } else {
            $this->db->trans_commit();
            $response = ['status' => true, 'message' => 'Booking berhasil dikonfirmasi dan pasien masuk antrian.'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $delete = $this->Booking_model->delete_booking($id);
        $response = ['status' => $delete, 'message' => $delete ? 'Data berhasil dihapus.' : 'Gagal menghapus data.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
