<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the necessary models and libraries
        $this->load->model('M_pesanan');
        $this->load->model('M_menu');
        $this->load->model('M_pelanggan');
        $this->load->helper('url');
    }

    public function index() {
        // Get the logged-in customer's data

        // Get customer details
        $data['nama_pelanggan'] = $this->M_pelanggan->get_nama_pelanggan($id_pelanggan);
        
        // Get recent orders for the customer
        $data['pesanan_terbaru'] = $this->M_pesanan->get_pesanan_terbaru($id_pelanggan);

        // Get recommended menu for the customer
        $data['rekomendasi_menu'] = $this->M_menu->get_rekomendasi_menu();

        // Get customer statistics
        $data['total_pesanan'] = $this->M_pesanan->get_total_pesanan($id_pelanggan);
        $data['total_pengeluaran'] = $this->M_pesanan->get_total_pengeluaran($id_pelanggan);
        $data['menu_favorit'] = $this->M_pesanan->get_menu_favorit($id_pelanggan);
        $data['poin'] = $this->M_pesanan->get_poin($id_pelanggan);

        // Load the dashboard view

            $this->load->view('template/head');
            $this->load->view('template/sidebar');
            $this->load->view('template/navbar');
            $this->load->view('dashboard', $data);
            $this->load->view('template/footer');
    }
}
