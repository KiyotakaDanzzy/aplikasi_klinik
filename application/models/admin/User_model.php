<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_data_user($cari = null)
    {
        $this->db->select("a.id, a.nama_pegawai as nama, a.username, a.nama_level as level, a.status");
        $this->db->from('adm_user a');

        if ($cari) {
            $this->db->group_start();
            $this->db->like('a.nama_pegawai', $cari);
            $this->db->or_like('a.username', $cari);
            $this->db->group_end();
        }

        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('adm_user', ['id' => $id])->row_array();
    }

    public function insert_user($data)
    {
        $this->db->where('username', $data['username']);
        if ($this->db->count_all_results('adm_user') > 0) {
            return false;
        }
        return $this->db->insert('adm_user', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('adm_user', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('adm_user');
    }

    public function get_pegawai_list($cari = null)
    {
        $this->db->select('id, nama, nama_jabatan');
        $this->db->from('kpg_pegawai');

        $this->db->where("id NOT IN (SELECT id_pegawai FROM adm_user WHERE id_pegawai IS NOT NULL)", NULL, FALSE);

        if ($cari) {
            $this->db->group_start();
            $this->db->like('nama', $cari);
            $this->db->or_like('nama_jabatan', $cari);
            $this->db->group_end();
        }
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    public function get_level_list()
    {
        return $this->db->get('adm_level')->result();
    }
}
