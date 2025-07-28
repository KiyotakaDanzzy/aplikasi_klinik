<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli_model extends CI_Model {

    public function get_data_poli($cari = null)
    {
        $this->db->from('mst_poli');
        if ($cari) {
            $this->db->like('kode', $cari);
            $this->db->or_like('nama', $cari);
        }
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_poli_by_id($id)
    {
        return $this->db->get_where('mst_poli', ['id' => $id])->row_array();
    }

    public function insert_poli($data)
    {
        $this->db->insert('mst_poli', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_poli($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('mst_poli', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_poli($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_poli');
        return $this->db->affected_rows() > 0;
    }
}