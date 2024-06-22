<?php
class M_transaksi extends CI_Model {

    public function get_pesanan_by_antrian($idAntrian) {
        return $this->db->get_where('transaksi', ['idAntrian' => $idAntrian])->result_array();
    }
}
?>
