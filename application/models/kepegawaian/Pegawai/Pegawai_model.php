<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model {

    public function get_data_pegawai($cari = null)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.nama LIKE ? OR a.nama_jabatan LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }
        
        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }
    
    public function get_pegawai_by_id($id)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function get_pegawai_by_jabatan_nama($nama_jabatan)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE a.nama_jabatan = ?";
        $query = $this->db->query($sql, array($nama_jabatan));
        return $query->result();
    }

    public function insert_pegawai($data)
    {
        $this->db->insert('kpg_pegawai', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pegawai($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kpg_pegawai', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_pegawai($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kpg_pegawai');
        return $this->db->affected_rows() > 0;
    }
}