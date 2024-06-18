<?php
class M_antrian extends CI_Model {

    protected $table = "antrian";

    // Method untuk mengambil data antrian berdasarkan kondisi tertentu
    public function get_antrian($where = []) {
        if (!empty($where)) {
            return $this->db->get_where($this->table, $where)->result_array();
        } else {
            return $this->db->get($this->table)->result_array();
        }
    }

    // Method untuk memperbarui data antrian berdasarkan kondisi
    public function update_antrian($where, $data) {
        $this->db->where($where);
        $this->db->update($this->table, $data);
    }
}
?>
