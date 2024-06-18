<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaksi extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function insert_transaction($data) {
        $this->db->insert('pesanan', $data);
        return $this->db->insert_id();
    }

    public function insert_transaction_items($items) {
        $this->db->insert_batch('transaksi', $items);
    }

    public function get_pesanan_by_antrian($id_antrian) {
        $this->db->select('t.*, m.nama_menu as nama, t.jumlah as jml, t.harga')
                 ->from('transaksi t')
                 ->join('menu m', 't.id_menu = m.id_menu')
                 ->where('t.no_faktur_jual', $id_antrian);
        $query = $this->db->get();
        return $query; // Return the query object instead of calling result_array()
    }
}

