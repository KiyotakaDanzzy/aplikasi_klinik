<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tindakan_model extends CI_Model
{

    public function get_data_tindakan($cari = null)
    {
        $this->db->select("a.id, a.nama, FORMAT(a.harga, 0, 'en_US') as harga, b.nama as nama_poli");
        $this->db->from('mst_tindakan a');
        $this->db->join('mst_poli b', 'a.id_poli = b.id', 'left');
        
        if ($cari) {
            $this->db->group_start();
            $this->db->like('a.nama', $cari);
            $this->db->or_like('b.nama', $cari);
            $this->db->group_end();
        }

        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_tindakan_by_id($id)
    {
        $this->db->select('a.*, b.nama as nama_poli');
        $this->db->from('mst_tindakan a');
        $this->db->join('mst_poli b', 'a.id_poli = b.id', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
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

    public function insert_master_data($data)
    {
        $this->db->insert('mst_tindakan', $data);
        return $this->db->insert_id();
    }
}
