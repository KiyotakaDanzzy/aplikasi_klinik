<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_dokter_model extends CI_Model
{

    public function get_all_schedules_join($id_poli = null, $jam = null)
    {
        $sql = "SELECT a.*, b.nama_poli 
                FROM rsp_jadwal_dokter a
                JOIN kpg_dokter b ON a.id_pegawai = b.id_pegawai
                WHERE 1=1";
        $params = [];

        if ($id_poli) {
            $sql .= " AND b.id_poli = ?";
            $params[] = $id_poli;
        }

        if ($jam) {
            $sql .= " AND ? BETWEEN a.jam_mulai AND a.jam_selesai";
            $params[] = $jam;
        }

        $sql .= " ORDER BY a.jam_mulai ASC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_jadwal_by_dokter_id($id_dokter)
    {
        $sql = "SELECT a.* FROM rsp_jadwal_dokter a JOIN kpg_dokter b ON a.id_pegawai = b.id_pegawai WHERE b.id = ? ORDER BY FIELD(a.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
        $query = $this->db->query($sql, array($id_dokter));
        return $query->result_array();
    }

    public function insert_jadwal_batch($id_dokter, $hari, $jam_mulai, $jam_selesai)
    {
        $this->load->model('Dokter_model');
        $dokter = $this->Dokter_model->get_dokter_by_id($id_dokter);

        if (!$dokter || !$hari) return false;

        $this->db->trans_begin();
        $batch_data = [];
        foreach ($hari as $h) {
            if (!empty($jam_mulai[$h]) && !empty($jam_selesai[$h])) {
                $batch_data[] = [
                    'id_pegawai' => $dokter['id_pegawai'],
                    'nama_pegawai' => $dokter['nama_pegawai'],
                    'hari' => $h,
                    'jam_mulai' => $jam_mulai[$h],
                    'jam_selesai' => $jam_selesai[$h]
                ];
            }
        }

        if (!empty($batch_data)) {
            $this->db->insert_batch('rsp_jadwal_dokter', $batch_data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function update_jadwal_batch($id_dokter, $hari, $jam_mulai, $jam_selesai)
    {
        $this->load->model('Dokter_model');
        $dokter = $this->Dokter_model->get_dokter_by_id($id_dokter);
        if (!$dokter) return false;

        $this->db->trans_begin();
        $this->delete_by_dokter_id($id_dokter);

        $batch_data = [];
        if ($hari) {
            foreach ($hari as $h) {
                if (!empty($jam_mulai[$h]) && !empty($jam_selesai[$h])) {
                    $batch_data[] = [
                        'id_pegawai' => $dokter['id_pegawai'],
                        'nama_pegawai' => $dokter['nama_pegawai'],
                        'hari' => $h,
                        'jam_mulai' => $jam_mulai[$h],
                        'jam_selesai' => $jam_selesai[$h]
                    ];
                }
            }
        }

        if (!empty($batch_data)) {
            $this->db->insert_batch('rsp_jadwal_dokter', $batch_data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete_by_dokter_id($id_dokter)
    {
        $this->load->model('Dokter_model');
        $dokter = $this->Dokter_model->get_dokter_by_id($id_dokter);
        if (!$dokter) return false;

        $this->db->where('id_pegawai', $dokter['id_pegawai']);
        $this->db->delete('rsp_jadwal_dokter');
        return $this->db->affected_rows() >= 0;
    }
}
