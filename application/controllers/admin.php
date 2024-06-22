<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url() . 'welcome?pesan=belumlogin');
        }

        $this->load->model('M_makan');
        $this->load->model('M_antrian');
        $this->load->model('M_menu');
        $this->load->model('M_transaksi');
        $this->load->library('upload');
        $this->load->helper('url');
  
    }

    public function index()
    {
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("template/index");
        $this->load->view("template/footer");
    }

    public function daftar_menu()
    {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("daftar_menu", $data);
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

    public function tambah_menu_proses() {
        $config['upload_path'] = './assets_5/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048; // Optional: Set a maximum file size
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $error = $this->upload->display_errors();
            // Handle upload error
            // For example, you can pass this error to the view
            $this->session->set_flashdata('error', $error);
            redirect('admin/tambah_menu');
        } else {
            $upload_data = $this->upload->data();
            $gambar = $upload_data['file_name'];

            $data = array(
                'nama_menu' => $this->input->post('nama_menu'),
                'gambar' => $gambar,
                'harga' => $this->input->post('harga'),
                'jenis_menu' => $this->input->post('jenis_menu'),
                'status' => $this->input->post('status')
            );

            $this->M_menu->insert_menu($data);
            redirect('admin/daftar_menu');
        }
    }

    public function edit_menu($id_menu)
    {
        $data['menu'] = $this->M_menu->get_menu_by_id($id_menu);
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("edit_menu", $data);
        $this->load->view("template/footer");
    }
    public function update_menu_proses($id_menu)
    {
        // Load the upload library with the configuration
        $config['upload_path'] = './assets_5/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048; // Set max size if needed
        $this->upload->initialize($config);

        $data = array(
            'nama_menu' => $this->input->post('nama_menu'),
            'harga' => $this->input->post('harga'),
            'jenis_menu' => $this->input->post('jenis_menu'),
            'status' => $this->input->post('status')
        );

        // Check if there is a file to upload
        if (!empty($_FILES['gambar']['name'])) {
            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $data['gambar'] = $upload_data['file_name'];
            } else {
                // Handle the upload error
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('admin/edit_menu/' . $id_menu);
                return;
            }
        }
        // Update the menu data
        if ($this->M_menu->update_menu($id_menu, $data)) {
            // Set success message
            $this->session->set_flashdata('success', 'Menu updated successfully');
        } else {
            // Set failure message
            $this->session->set_flashdata('error', 'Failed to update menu');
        }
        // Redirect to the menu list
        redirect('admin/daftar_menu');
    }
    public function del_menu($id_menu)
    {
        $this->M_menu->delete_menu($id_menu);
        redirect('admin/daftar_menu');
    }

    //transaksi
    public function transaksi() {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('transaksi/transaksi', $data);
        $this->load->view('template/footer');
    }
    public function add_to_cart($id_menu) {
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

    public function update_cart() {
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

    public function remove_from_cart($rowid) {
        $this->cart->remove($rowid);
        redirect('admin/transaksi');
    }

    public function checkout() {
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

    //order
    function entri_order()
    {
        $data['transaksi'] = $this->M_makan->get_data('transaksi')->result();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("entri_order", $data); // 
        $this->load->view("template/footer");

    }

    public function dataAntrian()
    {
        $pesanan = $this->M_antrian->get_antrian(['status !=' => 2]);
        echo json_encode($pesanan);
    }

    public function dataAntrianSelesai()
    {
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date('Y-m-d') . " 00:00:00";
        $pesanan_selesai = $this->M_antrian->get_antrian(['status' => 2, 'tanggal >=' => $tanggal]);
        echo json_encode($pesanan_selesai);
    }

    public function proses()
    {
        $id = $this->input->post("no_faktur_jual");
        $status = $this->input->post("statusTransaksi");
        $data = ["status" => $status + 1];
        if ($status == 0) {
            $data["id_user"] = $this->session->userdata('id_user');
            date_default_timezone_set("Asia/Jakarta");
            $data["tanggal"] = date('Y-m-d H:i:s');
        }

        $this->M_antrian->update_antrian(['no_faktur_jual' => $no_faktur_jual], $data);
        echo json_encode("");
    }

    public function rincianPesanan()
    {
        $idAntrian = $this->input->post("no_faktur_jual");
        $pesanan = $this->M_transaksi->get_pesanan_by_antrian($id);
        foreach ($pesanan as &$item) {
            $menu = $this->M_menu->get_menu_by_id($item["id_Menu"]);
            $item["nama"] = $menu["nama"];
            $item["harga"] = $menu["harga"];
        }
        echo json_encode($pesanan);
    }

}
?>