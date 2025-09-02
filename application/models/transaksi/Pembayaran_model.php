<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    public function get_pasien_belum_bayar($cari = null)
    {
        $this->db->from('rsp_pembayaran');
        $this->db->where('bayar IS NULL');
        if ($cari) {
            $this->db->group_start();
            $this->db->like('kode_invoice', $cari);
            $this->db->or_like('nama_pasien', $cari);
            $this->db->or_like('nik', $cari);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_full_detail_by_invoice($kode_invoice)
    {
        $data = [];
        $data['pembayaran'] = $this->db->get_where('rsp_pembayaran', ['kode_invoice' => $kode_invoice])->row_array();

        if (!$data['pembayaran']) {
            return null;
        }

        $pol_gigi = $this->db->get_where('pol_gigi', ['kode_invoice' => $kode_invoice])->row_array();
        $data['tindakan'] = [];
        if($pol_gigi){
            $data['tindakan'] = $this->db->get_where('pol_gigi_tindakan', ['id_pol_gigi' => $pol_gigi['id']])->result_array();
        }

        $pol_resep = $this->db->get_where('pol_resep', ['kode_invoice' => $kode_invoice])->row_array();
        $data['resep'] = [];
        $data['racikan'] = [];

        if ($pol_resep) {
            $data['resep'] = $this->db->get_where('pol_resep_obat', ['id_pol_resep' => $pol_resep['id']])->result_array();
            $racikan_utama = $this->db->get_where('pol_resep_racikan', ['id_pol_resep' => $pol_resep['id']])->result_array();
            
            foreach ($racikan_utama as $racik) {
                $detail = $this->db->get_where('pol_resep_racikan_detail', ['id_pol_resep_racikan' => $racik['id']])->result_array();
                $racik['detail'] = $detail;
                $data['racikan'][] = $racik;
            }
        }       
        return $data;
    }

    public function get_full_detail_by_id($id)
    {
        $pembayaran = $this->db->get_where('rsp_pembayaran', ['id' => $id])->row_array();
        if ($pembayaran) {
            return $this->get_full_detail_by_invoice($pembayaran['kode_invoice']);
        }
        return null;
    }


    public function update_pembayaran($kode_invoice, $data)
    {
        $this->db->where('kode_invoice', $kode_invoice);
        $this->db->update('rsp_pembayaran', $data);
        return $this->db->affected_rows() > 0;
    }
    
    public function get_riwayat_pembayaran($cari = null)
    {
        $this->db->from('rsp_pembayaran');
        $this->db->where('bayar IS NOT NULL');
        if ($cari) {
            $this->db->group_start();
            $this->db->like('kode_invoice', $cari);
            $this->db->or_like('nama_pasien', $cari);
            $this->db->or_like('nik', $cari);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_riwayat_by_id($id)
    {
        return $this->db->get_where('rsp_pembayaran', ['id' => $id])->row_array();
    }
}