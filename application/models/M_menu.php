<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Mengambil semua data menu
    public function get_all_menu()
    {
        $query = $this->db->get('MENU');
        return $query->result_array();
    }

    // Menambahkan data menu baru
    public function insert_menu($data) {
        return $this->db->insert('MENU', $data);
    }

    // Mengambil data menu berdasarkan ID
    public function get_menu_by_id($id_menu)
    {
        $query = $this->db->get_where('MENU', array('id_menu' => $id_menu));
        return $query->row_array();
    }

    // Mengupdate data menu berdasarkan ID
    public function update_menu($id_menu, $data) {
        $this->db->where('id_menu', $id_menu);
        return $this->db->update('MENU', $data);
    }
    // Menghapus data menu berdasarkan ID
    public function delete_menu($id_menu)
    {
        $this->db->where('id_menu', $id_menu);
        return $this->db->delete('MENU');
    }
    public function get_rekomendasi_menu() {
        $this->db->limit(5);
        $query = $this->db->get('menu');
        return $query->result_array();
    }
}
