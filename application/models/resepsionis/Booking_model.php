<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{

    public function get_data_booking($cari = null, $status = null)
    {
        $this->db->select('b.id, b.kode_booking, b.nama_pasien, b.nik, b.nama_poli, b.tanggal, b.waktu, b.status_booking, d.nama_pegawai as nama_dokter');
        $this->db->from('rsp_booking b');
        $this->db->join('kpg_dokter d', 'b.id_dokter = d.id', 'left');

        if ($cari) {
            $this->db->group_start();
            $this->db->like('b.kode_booking', $cari);
            $this->db->or_like('b.nama_pasien', $cari);
            $this->db->or_like('b.nama_poli', $cari);
            $this->db->or_like('d.nama_pegawai', $cari);
            $this->db->group_end();
        }

        if ($status) {
            $this->db->where('b.status_booking', $status);
        }
        
        $this->db->order_by('b.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_booking_by_id($id)
    {
        $this->db->select('b.*, d.nama_pegawai as nama_dokter');
        $this->db->from('rsp_booking b');
        $this->db->join('kpg_dokter d', 'b.id_dokter = d.id', 'left');
        $this->db->where('b.id', $id);
        return $this->db->get()->row_array();
    }

    public function insert_booking($data)
    {
        $today_format = date('dmy');
        $this->db->like('kode_booking', 'KB' . $today_format, 'after');
        $this->db->from('rsp_booking');
        $count_today = $this->db->count_all_results();
        $next_num = $count_today + 1;

        $data['kode_booking'] = sprintf("KB%s-%03d", $today_format, $next_num);
        $data['status_booking'] = 'Pending';
        $data['tanggal_booking'] = date('d-m-Y H:i:s');

        $this->db->insert('rsp_booking', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_booking($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('rsp_booking', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_booking($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rsp_booking');
        return $this->db->affected_rows() > 0;
    }
}