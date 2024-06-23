<?php
class M_pelanggan extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_nama_pelanggan($id_pelanggan) {
        $this->db->where('id', $id_pelanggan);
        $query = $this->db->get('pelanggan');
        return $query->row()->nama;
    }

    public function get_poin($id_pelanggan) {
        $this->db->where('id', $id_pelanggan);
        $query = $this->db->get('pelanggan');
        return $query->row()->poin;
    }
}
