<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_model extends CI_Model {

    public function get_data_tindakan($cari = null)
    {
        $sql = "SELECT a.* FROM mst_tindakan a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.nama LIKE ? OR a.nama_poli LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }
        
        $sql .= " ORDER BY a.id ASC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_tindakan_by_id($id)
    {
        $sql = "SELECT a.* FROM mst_tindakan a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_tindakan($data)
    {
        $this->db->insert('mst_tindakan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_tindakan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('mst_tindakan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_tindakan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_tindakan');
        return $this->db->affected_rows() > 0;
    }
}