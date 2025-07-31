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
