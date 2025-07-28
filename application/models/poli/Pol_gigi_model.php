<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pol_gigi_model extends CI_Model {

    private $table = 'pol_gigi';

    public function get_data($cari = null)
    {
        $this->db->from($this->table);
        if ($cari) {
            $this->db->like('kode_invoice', $cari)
                     ->or_like('id_pasien', $cari)
                     ->or_like('nama_pasien', $cari)
                     ->or_like('nama_dokter', $cari)
                     ->or_like('nik', $cari)
                     ->or_like('keluhan', $cari);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_data_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert_data($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_data($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}