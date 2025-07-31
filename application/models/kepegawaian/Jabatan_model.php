<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model {

    public function get_data_jabatan($cari = null)
    {
        $sql = "SELECT a.* FROM kpg_jabatan a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND a.nama LIKE ?";
            $params[] = "%$cari%";
        }
        
        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }
    
    public function get_jabatan_by_id($id)
    {
        $sql = "SELECT a.* FROM kpg_jabatan a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_jabatan($data)
    {
        $this->db->insert('kpg_jabatan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_jabatan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kpg_jabatan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_jabatan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kpg_jabatan');
        return $this->db->affected_rows() > 0;
    }
}