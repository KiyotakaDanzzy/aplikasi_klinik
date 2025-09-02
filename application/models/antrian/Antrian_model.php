<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian_model extends CI_Model
{
    public function insert_antrian($data)
    {
        $this->load->model('master_data/Poli_model');
        $poli = $this->Poli_model->get_poli_by_id($data['id_poli']);
        $kode_poli = $poli ? $poli['kode'] : 'POL';
        $nama_poli = $poli ? $poli['nama'] : '';

        $tanggal_sekarang = date('d-m-Y');

        $this->db->where('id_poli', $data['id_poli']);
        $this->db->where('tanggal', $tanggal_sekarang);
        $this->db->from('rsp_antrian');
        $count_today = $this->db->count_all_results();
        $next_num = $count_today + 1;

        $data_antrian = [
            'id_registrasi' => $data['id_registrasi'],
            'kode_invoice' => $data['kode_invoice'],
            'id_pasien' => $data['id_pasien'],
            'id_poli' => $data['id_poli'],
            'id_dokter' => $data['id_dokter'],
            'no_antrian' => sprintf("%s-%03d", $kode_poli, $next_num),
            'nama_poli' => $nama_poli,
            'tanggal_antri' => $tanggal_sekarang,
            'waktu_antri' => date('H:i:s'),
            'status_antrian' => 'Menunggu',
            'tanggal' => $tanggal_sekarang,
            'waktu' => date('H:i:s'),
        ];

        $this->db->insert('rsp_antrian', $data_antrian);
        return $this->db->affected_rows() > 0;
    }

    public function get_antrian_list($id_poli, $status)
    {
        $today = date('d-m-Y');
        $this->db->select('a.id, a.id_registrasi, a.id_poli, a.no_antrian, a.status_antrian, p.nama_pasien, r.kode_invoice');
        $this->db->from('rsp_antrian a');
        $this->db->join('mst_pasien p', 'a.id_pasien = p.id', 'left');
        $this->db->join('rsp_registrasi r', 'a.id_registrasi = r.id', 'left');
        $this->db->where('a.id_poli', $id_poli);
        $this->db->where('a.tanggal', $today);
        
        if ($status == 'Menunggu') {
            $this->db->group_start();
            $this->db->where('a.status_antrian', 'Menunggu');
            $this->db->or_where('a.status_antrian', 'Dipanggil');
            $this->db->group_end();
        } else {
            $this->db->where('a.status_antrian', $status);
        }

        $this->db->order_by('a.id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_ringkasan()
    {
        $today = date('d-m-Y');
        $stats = [];        

        // $stats['total_pasien_hari_ini'] = $this->db->where('tanggal', $today)->count_all_results('rsp_registrasi');
        $stats['antrian_konfir'] = $this->db->where('tanggal', $today)->where('status_antrian', 'Dikonfirmasi')->count_all_results('rsp_antrian');
        $stats['antrian_menunggu'] = $this->db->where('tanggal', $today)->where('status_antrian', 'Menunggu')->count_all_results('rsp_antrian');
        $stats['total_antrian'] = $this->db->where('tanggal', $today)->count_all_results('rsp_antrian');
        
        return $stats;
    }

    public function get_antrian_dipanggil()
    {
        $today = date('d-m-Y');
        $this->db->select('a.no_antrian, a.nama_poli, d.nama_pegawai as nama_dokter');
        $this->db->from('rsp_antrian a');
        $this->db->join('kpg_dokter d', 'a.id_dokter = d.id', 'left');
        $this->db->where('a.status_antrian', 'Dipanggil');
        $this->db->where('a.tanggal', $today);
        $this->db->order_by('a.waktu_dipanggil', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function get_lanjut()
    {
        $today = date('d-m-Y');
        $this->db->select('a.no_antrian, p.nama_pasien, a.nama_poli');
        $this->db->from('rsp_antrian a');
        $this->db->join('mst_pasien p', 'a.id_pasien = p.id', 'left');
        $this->db->where('a.status_antrian', 'Menunggu');
        $this->db->where('a.tanggal', $today);
        $this->db->order_by('a.id', 'ASC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    public function panggil_pasien($id_antrian)
    {
        $antrian = $this->db->get_where('rsp_antrian', ['id' => $id_antrian])->row_array();
        if (!$antrian) return false;

        $waktu_antri_dt = new DateTime($antrian['tanggal_antri'] . ' ' . $antrian['waktu_antri']);
        $waktu_panggil_dt = new DateTime();
        
        $diff = $waktu_panggil_dt->diff($waktu_antri_dt);
        $lama_menunggu = $diff->format('%H:%I:%S');

        $data_update = [
            'status_antrian' => 'Dipanggil',
            'tanggal_dipanggil' => $waktu_panggil_dt->format('d-m-Y'),
            'waktu_dipanggil' => $waktu_panggil_dt->format('H:i:s'),
            'lama_menunggu' => $lama_menunggu
        ];

        $this->db->where('id', $id_antrian);
        $this->db->update('rsp_antrian', $data_update);
        return $this->db->affected_rows() > 0;
    }

    public function konfirmasi_pasien($id_antrian)
    {
        $data_update = ['status_antrian' => 'Dikonfirmasi'];
        $this->db->where('id', $id_antrian);
        $this->db->update('rsp_antrian', $data_update);
        return $this->db->affected_rows() > 0;
    }
}