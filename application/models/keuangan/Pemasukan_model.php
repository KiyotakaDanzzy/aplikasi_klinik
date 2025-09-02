<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan_model extends CI_Model
{

    public function get_data_pemasukan($cari = null)
    {
        $this->db->select("a.id, a.keterangan, FORMAT(a.nominal, 0, 'en_US') as nominal, b.nama as nama_jenis_biaya");
        $this->db->from('rsp_pemasukan a');
        $this->db->join('rsp_jenis_biaya b', 'a.id_jenis_biaya = b.id', 'left');

        if ($cari) {
            $this->db->group_start();
            $this->db->like('b.nama', $cari);
            $this->db->or_like('a.keterangan', $cari);
            $this->db->group_end();
        }

        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pemasukan_by_id($id)
    {
        $this->db->select('a.*, b.nama as nama_jenis_biaya');
        $this->db->from('rsp_pemasukan a');
        $this->db->join('rsp_jenis_biaya b', 'a.id_jenis_biaya = b.id', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insert_pemasukan($data)
    {
        $this->db->insert('rsp_pemasukan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pemasukan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('rsp_pemasukan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_pemasukan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rsp_pemasukan');
        return $this->db->affected_rows() > 0;
    }
}
