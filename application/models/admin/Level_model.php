<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level_model extends CI_Model
{
    public function get_data_level($cari = null)
    {
        $this->db->from('adm_level');
        if ($cari) {
            $this->db->like('nama_level', $cari);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_level_by_id($id)
    {
        return $this->db->get_where('adm_level', ['id' => $id])->row_array();
    }

    public function insert_level($data)
    {
        $this->db->where('nama_level', $data['nama_level']);
        if ($this->db->get('adm_level')->num_rows() > 0) {
            return false;
        }
        return $this->db->insert('adm_level', $data);
    }

    public function update_level($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('adm_level', $data);
    }

    public function delete_level($id)
    {
        $this->db->trans_begin();
        $this->db->where('id_level', $id)->delete('adm_level_akses'); // Hapus akses dulu
        $this->db->where('id', $id)->delete('adm_level');
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_sidebar_menu($id_level)
    {
        $this->db->select('g.nama_grup_hak_akses, h.nama_hak_akses, h.link');
        $this->db->from('adm_level_akses la');
        $this->db->join('adm_hak_akses h', 'la.id_hak_akses = h.id');
        $this->db->join('adm_grup_hak_akses g', 'h.id_grup_hak_akses = g.id');
        $this->db->where('la.id_level', $id_level);
        $this->db->order_by('g.id', 'ASC');
        $this->db->order_by('h.id', 'ASC');
        $result = $this->db->get()->result();

        $menu = [];
        foreach ($result as $row) {
            $menu[$row->nama_grup_hak_akses][] = [
                'nama' => $row->nama_hak_akses,
                'link' => $row->link
            ];
        }
        return $menu;
    }
}