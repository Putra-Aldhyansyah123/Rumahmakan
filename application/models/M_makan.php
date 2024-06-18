<?php
class M_makan extends CI_Model {
    
    // Method untuk mengambil data berdasarkan kondisi tertentu
    public function edit_data($where, $table) {
       return $this->db->get_where($table, $where);
    }
    
    // Method untuk mengambil semua data dari tabel tertentu
    public function get_data($table) {
       return $this->db->get($table);
    }
    
    // Method untuk memasukkan data ke dalam tabel tertentu
    public function insert_data($data, $table) {
        $this->db->insert($table, $data);
    }
    
    // Method untuk memperbarui data pada tabel tertentu berdasarkan kondisi
    public function update_data($where, $data, $table) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    
    // Method untuk menghapus data dari tabel tertentu berdasarkan kondisi
    public function delete_data($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
?>
