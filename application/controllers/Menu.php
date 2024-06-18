<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('MenuModel', 'menuModel');
        $this->load->library('session');
    }

    public function index()
    {
        if (!$this->session->userdata('nama') || $this->session->userdata('rule') != 1) {
            redirect(base_url() . "/dashboard");
        }
        $this->load->view('menu');
    }

    public function muatData()
    {
        echo json_encode($this->menuModel->where("hapus", NULL)->findAll());
    }

    public function tambah()
    {
        $data = [
            "nama" => $this->input->post("nama"),
            "harga" =>  $this->input->post("harga"),
            "jenis" => $this->input->post("jenis"),
            "foto" => "default.jpg",
            "status" => 0
        ];

        $this->menuModel->save($data);

        echo json_encode("");
    }

    public function hapus()
    {
        $id = $this->input->post("id");
        if ($id) {
            $tanggal = date('Y-m-d h:m:s', strtotime('today'));
            $this->menuModel->update($id, ["hapus" => $tanggal]);
            echo json_encode("");
        } else {
            echo json_encode("id kosong");
        }
    }

    public function ubahStatus()
    {
        $this->menuModel->update($this->input->post("id"), ["status" => $this->input->post("status")]);
    }

    public function getMenu()
    {
        echo json_encode($this->menuModel->where("id", $this->input->post("id"))->first());
    }

    public function upload()
    {
        $data = array();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('file', 'File', 'callback_file_check');

        if ($this->form_validation->run() == FALSE) {
            $data['success'] = 0;
            $data['error'] = $this->form_validation->error('file'); // Error response
        } else {
            if ($_FILES['file']['name']) {
                $config['upload_path'] = './public/images/menu';
                $config['allowed_types'] = 'jpg|jpeg|gif|png|webp';
                $config['max_size'] = 2048;
                $config['file_name'] = $this->input->post("namaMenu") . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $namaMenu = $uploadData['file_name'];
                    $idMenu = $this->input->post("idMenu");

                    $this->menuModel->update($idMenu, ["foto" => $namaMenu]);

                    $data['success'] = 1;
                    $data['message'] = 'Foto Berhasil diupload :)';
                } else {
                    $data['success'] = 2;
                    $data['message'] = $this->upload->display_errors();
                }
            } else {
                $data['success'] = 2;
                $data['message'] = 'Foto gagal diupload.';
            }
        }
        echo json_encode($data);
    }

    public function file_check($str)
    {
        if (empty($_FILES['file']['name'])) {
            $this->form_validation->set_message('file_check', 'The {field} field is required');
            return FALSE;
        }
        return TRUE;
    }
}
