<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnosa_model extends CI_Model {

    public function get_data_diagnosa($cari = null)
    {
        $sql = "SELECT a.id, a.nama_diagnosa, b.nama as nama_poli 
                FROM mst_diagnosa a 
                LEFT JOIN mst_poli b ON a.id_poli = b.id 
                WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.nama_diagnosa LIKE ? OR b.nama LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }

        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_diagnosa_by_id($id)
    {
        $sql = "SELECT a.* FROM mst_diagnosa a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_diagnosa($data)
    {
        $this->db->insert('mst_diagnosa', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_diagnosa($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('mst_diagnosa', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_diagnosa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_diagnosa');
        return $this->db->affected_rows() > 0;
    }
}