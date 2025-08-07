<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian_model extends CI_Model
{
    public function insert_antrian($data)
    {
        $this->load->model('master_data/Poli_model');
        $poli = $this->Poli_model->get_poli_by_id($data['id_poli']);
        $kode_poli = $poli ? $poli['kode'] : 'POL';
        $nama_poli = $poli ? $poli['nama'] : '';

        $this->db->where('id_poli', $data['id_poli']);
        $this->db->where('tanggal', $data['tanggal']);
        $this->db->from('rsp_antrian');
        $count_today = $this->db->count_all_results();
        $next_num = $count_today + 1;

        $data_antrian = [
            'id_registrasi' => $data['id_registrasi'],
            'kode_invoice' => $data['kode_invoice'],
            'id_pasien' => $data['id_pasien'],
            'id_poli' => $data['id_poli'],
            'id_dokter' => $data['id_dokter'],
            'no_antrian' => sprintf("%s-%03d", $kode_poli, $next_num),
            'nama_poli' => $nama_poli,
            'tanggal_antri' => date('d-m-Y'),
            'waktu_antri' => date('H:i:s'),
            'status_antrian' => 'Menunggu',
            'tanggal' => $data['tanggal'],
        ];

        $this->db->insert('rsp_antrian', $data_antrian);
        return $this->db->affected_rows() > 0;
    }

    public function get_no_antrian_by_id($id)
    {
        $this->db->select('no_antrian');
        $this->db->from('rsp_antrian');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
}
