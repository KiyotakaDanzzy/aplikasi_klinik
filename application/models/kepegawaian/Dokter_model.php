<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter_model extends CI_Model
{

    public function get_data_dokter($cari = null)
    {
        $sql = "SELECT a.* FROM kpg_dokter a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.nama_pegawai LIKE ? OR a.nama_poli LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }

        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_dokter_by_id($id)
    {
        $sql = "SELECT a.* FROM kpg_dokter a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function get_dokter_by_poli($id_poli)
    {
        $sql = "SELECT a.id, a.nama_pegawai FROM kpg_dokter a WHERE a.id_poli = ?";
        $query = $this->db->query($sql, array($id_poli));
        return $query->result();
    }

    public function get_dokter_ada($id_poli, $tanggal_db, $waktu, $hari)
    {
        if (empty($id_poli) || empty($tanggal_db) || empty($waktu) || empty($hari)) return [];
        $this->db->select('d.id, d.nama_pegawai, j.jam_mulai, j.jam_selesai');
        $this->db->from('kpg_dokter d');
        $this->db->join('rsp_jadwal_dokter j', 'd.id_pegawai = j.id_pegawai');
        $this->db->where('d.id_poli', $id_poli);
        $this->db->where('j.hari', $hari);
        $this->db->where($this->db->escape($waktu) . ' BETWEEN j.jam_mulai AND j.jam_selesai');
        return $this->db->get()->result();
    }


    public function insert_dokter($data)
    {
        $this->db->insert('kpg_dokter', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_dokter($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kpg_dokter', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_dokter($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kpg_dokter');
        return $this->db->affected_rows() > 0;
    }

    public function get_dokter_by_pegawai_id($id_pegawai)
    {
        $sql = "SELECT a.* FROM kpg_dokter a WHERE a.id_pegawai = ?";
        $query = $this->db->query($sql, array($id_pegawai));
        return $query->row_array();
    }
}
