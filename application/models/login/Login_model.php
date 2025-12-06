<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function login($username)
    {
        $this->db->select('u.*, l.nama_level');
        $this->db->from('adm_user u');
        $this->db->join('adm_level l', 'u.id_level = l.id', 'left');
        $this->db->where('u.username', $username);
        $this->db->where('u.status', 'Aktif');
        return $this->db->get()->row();
    }
}