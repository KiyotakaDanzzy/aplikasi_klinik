<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diagnosa_model extends CI_Model
{

    public function get_data_diagnosa($cari = null)
    {
        $this->db->select("a.id, a.nama_diagnosa, a.nama_poli");
        $this->db->from('mst_diagnosa a');
        
        if ($cari) {
            $this->db->group_start();
            $this->db->like('a.nama_diagnosa', $cari);
            $this->db->or_like('a.nama_poli', $cari);
            $this->db->group_end();
        }

        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
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

    public function insert_master_data($data)
    {
        $this->db->insert('mst_diagnosa', $data);
        return $this->db->insert_id();
    }
}
