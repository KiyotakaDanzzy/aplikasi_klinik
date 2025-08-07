<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi_model extends CI_Model
{
    public function get_data_registrasi($cari = null)
    {
        $this->db->select('r.id, r.kode_invoice, r.nama_pasien, r.nama_poli, r.nama_dokter, r.tanggal, r.waktu, r.status_registrasi, a.no_antrian');
        $this->db->from('rsp_registrasi r');
        $this->db->join('rsp_antrian a', 'a.id_registrasi = r.id', 'left');

        if ($cari) {
            $this->db->group_start();
            $this->db->like('r.kode_invoice', $cari);
            $this->db->or_like('r.nama_pasien', $cari);
            $this->db->or_like('r.nama_poli', $cari);
            $this->db->group_end();
        }

        $this->db->order_by('r.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_registrasi_by_id($id)
    {
        $this->db->select('r.*, p.alamat, p.no_telp, a.no_antrian');
        $this->db->from('rsp_registrasi r');
        $this->db->join('mst_pasien p', 'r.id_pasien = p.id', 'left');
        $this->db->join('rsp_antrian a', 'a.id_registrasi = r.id', 'left');
        $this->db->where('r.id', $id);
        return $this->db->get()->row_array();
    }

    public function insert_registrasi($data)
    {
        $today_format = date('dmy');
        $this->db->like('kode_invoice', 'KI' . $today_format, 'after');
        $this->db->from('rsp_registrasi');
        $count_today = $this->db->count_all_results();
        $next_num = $count_today + 1;

        $data['kode_invoice'] = sprintf("KI%s-%03d", $today_format, $next_num);
        $data['status_registrasi'] = 'Sukses';

        $this->db->insert('rsp_registrasi', $data);
        $new_id = $this->db->insert_id();

        return [
            'id' => $new_id,
            'kode_invoice' => $data['kode_invoice']
        ];
    }

    public function update_registrasi($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('rsp_registrasi', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_registrasi($id)
    {
        $this->db->trans_begin();
        $this->db->where('id_registrasi', $id)->delete('rsp_antrian');
        $this->db->where('id', $id)->delete('rsp_registrasi');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
