<?php

    class Pasien_model extends CI_Model 
    {

        public function get_data_pasien($cari = null)
        {
            $sql = "SELECT * FROM pasien WHERE 1=1";
            $params = [];

            if ($cari) {
                $sql .= " AND (nama_pasien LIKE ? OR no_rm LIKE ?)";
                $params[] = "%$cari%";
                $params[] = "%$cari%";
            }

            $sql .= " ORDER BY id DESC";
            $query = $this->db->query($sql, $params);
            return $query->result();
        }

        public function get_pasien_by_id($id)
        {
            $sql = "SELECT * FROM pasien WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        public function insert_pasien($data)
        {
            $this->db->insert('pasien', $data);
            return $this->db->affected_rows() > 0;
        }

        public function update_pasien($id, $data)
        {
            $this->db->where('id', $id);
            $this->db->update('pasien', $data);
            return $this->db->affected_rows() > 0;
        }

        public function delete_pasien($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('pasien');
            return $this->db->affected_rows() > 0;
        }




    }

?>