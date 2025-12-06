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

    public function cek_duplikat($nama_poli)
    {
        $this->db->where('nama', $nama_poli);
        $query = $this->db->get('mst_poli');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function cek_duplikat_update($nama_poli, $id_kecuali)
    {
        $this->db->where('nama', $nama_poli);
        $this->db->where('id !=', $id_kecuali);
        $query = $this->db->get('mst_poli');
        return $query->num_rows() > 0;
    }

    public function insert_poli($data)
    {
        $nama_poli = $data['nama'];
        if ($this->cek_duplikat($nama_poli)) {
            return false;
        } else {
            $this->db->insert('mst_poli', $data);
            return $this->db->affected_rows() > 0;
        }
    }

    public function update_poli($id, $data)
    {
        if ($this->cek_duplikat_update($data['nama'], $id)) {
            return "DUPLIKAT";
        };

        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('mst_poli', $data);

        $data_update = [
            'nama_poli' => $data['nama']
        ];

        $tabel_relasi = ['mst_diagnosa', 'mst_tindakan', 'kpg_dokter', 'rsp_booking', 'rsp_registrasi'];
        foreach($tabel_relasi as $tabel) {
            $this->db->where('id_poli', $id)->update($tabel, $data_update);
        }
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
