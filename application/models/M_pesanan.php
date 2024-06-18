<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pesanan extends CI_Model {
    public function get_all_pesanan() {
        $this->db->select('pesanan.*, pelanggan.nama_pelanggan');
        $this->db->from('pesanan');
        $this->db->join('pelanggan', 'pesanan.id_pelanggan = pelanggan.id_pelanggan');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pesanan_detail($no_faktur_jual) {
        $this->db->select('transaksi.*, menu.nama_menu');
        $this->db->from('transaksi');
        $this->db->join('menu', 'transaksi.id_menu = menu.id_menu');
        $this->db->where('transaksi.no_faktur_jual', $no_faktur_jual);
        $query = $this->db->get();
        return $query->result();
    }
}
