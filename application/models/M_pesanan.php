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
    public function get_pesanan_terbaru($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get('pesanan');
        return $query->result();
    }

    public function get_total_pesanan($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->from('pesanan');
        return $this->db->count_all_results();
    }

    public function get_total_pengeluaran($id_pelanggan) {
        $this->db->select_sum('total');
        $this->db->where('id_pelanggan', $id_pelanggan);
        $query = $this->db->get('pesanan');
        return $query->row()->total;
    }

    public function get_menu_favorit($id_pelanggan) {
        $this->db->select('menu.nama_menu, COUNT(pesanan.id_menu) as jumlah');
        $this->db->from('pesanan');
        $this->db->join('menu', 'pesanan.id_menu = menu.id');
        $this->db->where('pesanan.id_pelanggan', $id_pelanggan);
        $this->db->group_by('pesanan.id_menu');
        $this->db->order_by('jumlah', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->nama_menu;
    }
    public function get_rekomendasi_menu() {
        $this->db->limit(5);
        $query = $this->db->get('menu');
        return $query->result_array();
    }
}

