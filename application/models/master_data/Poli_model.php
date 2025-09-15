<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poli_model extends CI_Model
{

    public function get_data_poli($cari = null)
    {
        $sql = "SELECT a.* FROM mst_poli a WHERE 1=1";
        $params = [];

        if ($cari) {
            $sql .= " AND (a.kode LIKE ? OR a.nama LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }

        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function get_poli_by_id($id)
    {
        $sql = "SELECT a.* FROM mst_poli a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function insert_poli($data)
    {
        $this->db->insert('mst_poli', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_poli($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('mst_poli', $data);

        $data_update = [
            'nama_poli' => $data['nama']
        ];
        $this->db->where('id_poli', $id)->update('mst_diagnosa', $data_update);
        $this->db->where('id_poli', $id)->update('mst_tindakan', $data_update);
        $this->db->where('id_poli', $id)->update('kpg_dokter', $data_update);
        $this->db->where('id_poli', $id)->update('rsp_booking', $data_update);
        $this->db->where('id_poli', $id)->update('rsp_registrasi', $data_update);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function delete_poli($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mst_poli');
        return $this->db->affected_rows() > 0;
    }
}
