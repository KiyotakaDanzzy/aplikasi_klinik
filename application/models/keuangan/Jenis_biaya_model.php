<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_biaya_model extends CI_Model
{

    public function get_data_jenis($cari = null)
    {
        $sql = "SELECT a.* FROM rsp_jenis_biaya a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.nama LIKE ?)";
            $params[] = "%$cari%";
        }

        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_jenis_by_id($id)
    {
        $sql = "SELECT a.* FROM rsp_jenis_biaya a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_jenis($data)
    {
        $this->db->insert('rsp_jenis_biaya', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_jenis($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('rsp_jenis_biaya', $data);
        $data_update = [
            'nama_jenis_biaya' => $data['nama']
        ];
        $this->db->where('id_jenis_biaya', $id)->update('rsp_pemasukan', $data_update);
        $this->db->where('id_jenis_biaya', $id)->update('rsp_pengeluaran', $data_update);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function delete_jenis($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rsp_jenis_biaya');
        return $this->db->affected_rows() > 0;
    }
}
