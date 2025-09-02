<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model {

    public function get_data_pegawai($cari = null)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE 1=1";
        $params = [];
        if ($cari) {
            $sql .= " AND (a.nama LIKE ? OR a.nama_jabatan LIKE ?)";
            $params[] = "%$cari%";
            $params[] = "%$cari%";
        }
        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql, $params);
        return $query->result();
    }
    
    public function get_pegawai_by_id($id)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE a.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function get_pegawai_by_jabatan_nama($nama_jabatan)
    {
        $sql = "SELECT a.* FROM kpg_pegawai a WHERE a.nama_jabatan = ?";
        $query = $this->db->query($sql, array($nama_jabatan));
        return $query->result();
    }

    public function get_dokter_info_by_pegawai_id($id_pegawai)
    {
        $sql = "SELECT a.* FROM kpg_dokter a WHERE a.id_pegawai = ?";
        $query = $this->db->query($sql, array($id_pegawai));
        return $query->row_array();
    }

    public function insert_pegawai_dan_dokter()
    {
        $this->load->model('kepegawaian/Jabatan_model');
        $this->load->model('master_data/Poli_model');

        $id_jabatan = $this->input->post('id_jabatan');
        $jabatan = $this->Jabatan_model->get_jabatan_by_id($id_jabatan);

        $this->db->trans_begin();

        $data_pegawai = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'id_jabatan' => $id_jabatan,
            'nama_jabatan' => $jabatan ? $jabatan['nama'] : ''
        ];
        $this->db->insert('kpg_pegawai', $data_pegawai);
        $id_pegawai_baru = $this->db->insert_id();

        if ($jabatan && $jabatan['nama'] == 'Dokter') {
            $id_poli = $this->input->post('id_poli');
            $poli = $this->Poli_model->get_poli_by_id($id_poli);

            if($id_poli && $poli){
                $data_dokter = [
                    'id_pegawai' => $id_pegawai_baru,
                    'nama_pegawai' => $this->input->post('nama'),
                    'id_poli' => $id_poli,
                    'nama_poli' => $poli['nama']
                ];
                $this->db->insert('kpg_dokter', $data_dokter);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Data Gagal Ditambahkan'];
        } else {
            $this->db->trans_commit();
            return ['status' => true, 'message' => 'Data Berhasil Ditambahkan'];
        }
    }

    public function update_pegawai_dan_dokter()
    {
        $this->load->model('kepegawaian/Jabatan_model');
        $this->load->model('master_data/Poli_model');

        $id_pegawai = $this->input->post('id');
        $id_jabatan = $this->input->post('id_jabatan');
        $jabatan = $this->Jabatan_model->get_jabatan_by_id($id_jabatan);

        $this->db->trans_begin();

        $data_pegawai = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'id_jabatan' => $id_jabatan,
            'nama_jabatan' => $jabatan ? $jabatan['nama'] : ''
        ];
        $this->db->where('id', $id_pegawai)->update('kpg_pegawai', $data_pegawai);
        $this->db->where('id_pegawai', $id_pegawai)->delete('kpg_dokter');

        if ($jabatan && $jabatan['nama'] == 'Dokter') {
            $id_poli = $this->input->post('id_poli');
            $poli = $this->Poli_model->get_poli_by_id($id_poli);
            if($id_poli && $poli){
                $data_dokter = [
                    'id_pegawai' => $id_pegawai,
                    'nama_pegawai' => $this->input->post('nama'),
                    'id_poli' => $id_poli,
                    'nama_poli' => $poli['nama']
                ];

                $data_jadwal = [
                    'id_pegawai' => $id_pegawai,
                    'nama_pegawai' => $this->input->post('nama'),
                ];
                $this->db->insert('kpg_dokter', $data_dokter);
                $this->db->where('id_pegawai', $id_pegawai)->update('rsp_jadwal_dokter', $data_jadwal);
            }
        }
        else {
            $this->db->where('id_pegawai', $id_pegawai)->delete('rsp_jadwal_dokter');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Data Gagal Diperbarui'];
        } else {
            $this->db->trans_commit();
            return ['status' => true, 'message' => 'Data Berhasil Diperbarui'];
        }
    }

    public function delete_pegawai($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('kpg_pegawai');
        $this->db->where('id_pegawai', $id)->delete('kpg_dokter');
        $this->db->where('id_pegawai', $id)->delete('rsp_jadwal_dokter');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}