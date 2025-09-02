<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {

    public function get_data_pasien($cari = null)
    {
        $sql = "SELECT a.* FROM mst_pasien a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.no_rm LIKE ? OR a.nama_pasien LIKE ? OR a.nik LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }
        
        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }
    
    public function get_pasien_by_id($id)
    {
        $sql = "SELECT a.* FROM mst_pasien a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_pasien($data)
    {
        $this->db->select_max('id');
        $query = $this->db->get('mst_pasien');
        $last_id = $query->row()->id;
        $next_id = $last_id + 1;

        $data['no_rm'] = sprintf("RM%05d", $next_id);
        // $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->db->insert('mst_pasien', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pasien($id, $data)
    {
        // if (!empty($data['password'])) {
        //     $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // } else {
        //     unset($data['password']);
        // }

        $this->db->where('id', $id);
        $this->db->update('mst_pasien', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_pasien($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_pasien');
        return $this->db->affected_rows() > 0;
    }
}