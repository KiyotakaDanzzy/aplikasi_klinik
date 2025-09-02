<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengeluaran_model extends CI_Model
{

    public function get_data_pengeluaran($cari = null)
    {
        $this->db->select("a.id, a.keterangan, FORMAT(a.nominal, 0, 'en_US') as nominal, b.nama as nama_jenis_biaya");
        $this->db->from('rsp_pengeluaran a');
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

    public function get_pengeluaran_by_id($id)
    {
        $this->db->select('a.*, b.nama as nama_jenis_biaya');
        $this->db->from('rsp_pengeluaran a');
        $this->db->join('rsp_jenis_biaya b', 'a.id_jenis_biaya = b.id', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insert_pengeluaran($data)
    {
        $this->db->insert('rsp_pengeluaran', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pengeluaran($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('rsp_pengeluaran', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_pengeluaran($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rsp_pengeluaran');
        return $this->db->affected_rows() > 0;
    }
}
