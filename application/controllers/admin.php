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
        $this->load->model('M_pesanan');
        $this->load->library('upload');
        $this->load->library('cart');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['pesanan'] = $this->M_pesanan->get_all_pesanan();
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("template/index", $data);
        $this->load->view("template/footer");
    }

    public function daftar_menu()
    {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("menu/daftar_menu", $data);
        $this->load->view("template/footer");
    }

    public function tambah_menu()
    {
        $this->load->view("template/head");
        $this->load->view("template/sidebar");
        $this->load->view("template/navbar");
        $this->load->view("menu/tambah_menu");
        $this->load->view("template/footer");
    }

    public function tambah_menu_proses() {
        $config['upload_path'] = './assets_5/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048; // Optional: Set a maximum file size
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $error = $this->upload->display_errors();
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
        $this->load->view("menu/edit_menu", $data);
        $this->load->view("template/footer");
    }

    public function update_menu_proses($id_menu)
    {
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

        if (!empty($_FILES['gambar']['name'])) {
            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $data['gambar'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('admin/edit_menu/' . $id_menu);
                return;
            }
        }

        if ($this->M_menu->update_menu($id_menu, $data)) {
            $this->session->set_flashdata('success', 'Menu updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update menu');
        }
        redirect('admin/daftar_menu');
    }

    public function del_menu($id_menu)
    {
        $this->M_menu->delete_menu($id_menu);
        redirect('admin/daftar_menu');
    }

    public function pelanggan() {
        $data['orders'] = $this->M_transaksi->get_all_orders();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('order/index', $data);
        $this->load->view('template/footer');
    }
    public function pesanan() {
        $data['pesanan'] = $this->M_pesanan->get_all_pesanan();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('pesanan/index', $data);
        $this->load->view('template/footer');
    }

    public function transaksi() {
        $data['menu'] = $this->M_menu->get_all_menu();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('transaksi/index', $data);
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
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty' => $this->input->post('qty')
        );
        $this->cart->update($data);
        redirect('admin/transaksi');
    }

    public function remove_from_cart($rowid) {
        $this->cart->remove($rowid);
        redirect('admin/transaksi');
    }

    public function checkout() {
        $cart_contents = $this->cart->contents();
        foreach ($cart_contents as $item) {
            $data = array(
                'id_menu' => $item['id'],
                'qty' => $item['qty'],
                'harga' => $item['price'],
                'total' => $item['subtotal'],
                'tanggal' => date('Y-m-d H:i:s')
            );
            $this->M_transaksi->insert_transaksi($data);
        }
        $this->cart->destroy();
        redirect('admin/transaksi');
    }


    public function entri_order() {
        $data['orders'] = $this->M_transaksi->get_all_orders();
        $this->load->view('template/head');
        $this->load->view('template/sidebar');
        $this->load->view('template/navbar');
        $this->load->view('order/index', $data);
        $this->load->view('template/footer');
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
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url().'login?pesan=logout');
    }

}
?>