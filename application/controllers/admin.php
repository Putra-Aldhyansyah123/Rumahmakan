<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_menu');
        $this->load->model('M_transaksi');
        $this->load->model('M_pesanan');
        $this->load->library('cart');
    }


    public function detail($no_faktur_jual)
    {
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $data['detail'] = $this->M_pesanan->get_pesanan_detail($no_faktur_jual);
        $this->load->view("pesanan/detail", $data);
        $this->load->view("template/footer");
    }

    public function index()
    {


        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        // $data['pesanan'] = $this->M_pesanan->get_all_pesanan();
        $data['pesanan'] = $this->db->query("SELECT * FROM pesanan ORDER BY no_faktur_jual ASC LIMIT 7")->result();

        $this->load->view("pesanan/index", $data);
        $this->load->view("template/footer");
    }

    public function index_list()
    {


        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $data['pesanan'] = $this->M_pesanan->get_all_pesanan();
        $this->load->view("pesanan/index_list", $data);
        $this->load->view("template/footer");
    }

    public function daftar_menu()
    {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("daftar_menu", $data); // 
        $this->load->view("template/footer");
    }

    public function tambah_menu()
    {
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("tambah_menu");
        $this->load->view("template/footer");
    }

    public function tambah_menu_proses()
    {
        $data = array(
            'nama_menu' => $this->input->post('nama_menu'),
            'gambar' => $this->input->post('gambar'),
            'harga' => $this->input->post('harga'),
            'jenis_menu' => $this->input->post('jenis_menu'),
            'status' => $this->input->post('status')
        );

        $this->M_menu->insert_menu($data);
        redirect('admin/daftar_menu');
    }

    public function edit_menu($id_menu)
    {
        $data['menu'] = $this->M_menu->get_menu_by_id($id_menu);
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("edit_menu", $data); // View untuk form edit menu
        $this->load->view("template/footer");
    }

    public function update_menu_proses($id_menu)
    {
        $data = array(
            'nama_menu' => $this->input->post('nama_menu'),
            'gambar' => $this->input->post('gambar'), // Biasanya akan di-upload dan diambil nama filenya
            'harga' => $this->input->post('harga'),
            'jenis_menu' => $this->input->post('jenis_menu'),
            'status' => $this->input->post('status')
        );

        $this->M_menu->update_menu($id_menu, $data);
        redirect('admin/daftar_menu');
    }


    public function del_menu($id_menu)
    {
        $this->M_menu->delete_menu($id_menu);
        redirect('admin/delete_menu');
    }

    public function entri_order()
    {
        $data['transaksi'] = $this->M_transaksi->get_pesanan_by_antrian('transaksi')->result();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("entri_order", $data);
        $this->load->view("template/footer");
    }


    public function transaksi()
    {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('transaksi/transaksi', $data);
        $this->load->view('template/footer');
    }



    public function add_to_cart($id_menu)
    {
        $menu = $this->M_menu->get_menu_by_id($id_menu);
        $data = array(
            'id' => $menu->id_menu,
            'qty' => 1,
            'price' => $menu->harga,
            'name' => $menu->nama_menu
        );
        $this->cart->insert($data);
        redirect('admin/transaksi');
    }

    public function update_cart()
    {
        $cart_info = $this->input->post('cart');
        foreach ($cart_info as $id => $cart) {
            $data = array(
                'rowid' => $cart['rowid'],
                'qty' => $cart['qty']
            );
            $this->cart->update($data);
        }
        redirect('admin/transaksi');
    }

    public function remove_from_cart($rowid)
    {
        $this->cart->remove($rowid);
        redirect('admin/transaksi');
    }

    public function checkout()
    {
        $cart = $this->cart->contents();
        if (empty($cart)) {
            redirect('admin/transaksi');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        // Insert transaction data
        $transaction_data = array(
            'nama_user' => $this->session->userdata('nama_user'), // Assuming user name is stored in session
            'tanggal' => date('Y-m-d'),
            'id_user' => $this->session->userdata('id_user'), // Assuming user ID is stored in session
            'no_meja' => 1, // Default or get from input
            'id_pelanggan' => 1, // Default or get from input
            'nama_pelanggan' => 'Pelanggan Umum', // Default or get from input
            'total' => $total
        );
        $transaction_id = $this->M_transaksi->insert_transaction($transaction_data);

        // Insert transaction items
        $transaction_items = array();
        foreach ($cart as $item) {
            $transaction_items[] = array(
                'no_faktur_jual' => $transaction_id,
                'id_menu' => $item['id'],
                'id_pelanggan' => 1, // Default or get from input
                'harga' => $item['price'],
                'jumlah' => $item['qty']
            );
        }
        $this->M_transaksi->insert_transaction_items($transaction_items);

        // Clear cart
        $this->cart->destroy();

        redirect('admin/transaksi');
    }

    public function dataAntrian()
    {
        $antrian = $this->M_transaksi->get_antrian(['status !=' => 2]);
        echo json_encode($antrian);
    }

    public function dataAntrianSelesai()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Y-m-d') . " 00:00:00";
        $antrian_selesai = $this->M_transaksi->get_antrian(['status' => 2, 'tanggal >=' => $tanggal]);
        echo json_encode($antrian_selesai);
    }

    public function proses()
    {
        $id = $this->input->post("idTransaksi");
        $status = $this->input->post("statusTransaksi");
        $data = ["status" => $status + 1];
        if ($status == 0) {
            $data["id_user"] = $this->session->userdata('id_user');
            date_default_timezone_set("Asia/Jakarta");
            $data["tanggal"] = date('Y-m-d H:i:s');
        }

        $this->M_transaksi->update_antrian(['id' => $id], $data);
        echo json_encode("");
    }

    public function rincianPesanan()
    {
        $idAntrian = $this->input->post("idAntrian");
        $pesanan = $this->M_transaksi->get_pesanan_by_antrian($idAntrian);
        foreach ($pesanan as &$item) {
            $menu = $this->M_menu->get_menu_by_id($item["id_menu"]);
            $item["nama"] = $menu->nama_menu;
            $item["harga"] = $menu->harga;
        }
        echo json_encode($pesanan);
    }
}
