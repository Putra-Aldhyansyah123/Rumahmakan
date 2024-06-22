<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tugas_uts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Mkaryawan');
        $this->load->model('Divisi_model');
        $this->load->model('Mabsen');
    }

    public function index()
    {
        $this->load->view("template_uts/head");
        $this->load->view("template_uts/sidebar");
        $this->load->view("template_uts/navbar");
        $this->load->view("template_uts/content");
        $this->load->view("template_uts/footer");
    }
    //karyawan
    public function data_karyawan()
    {
        $data['karyawan'] = $this->Mkaryawan->get_all_karyawan();
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('vdatakaryawan', $data);
        $this->load->view("template_uts/footer.php");
    }
    public function tambah_karyawan()
    {
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('tambah_data');
        $this->load->view("template_uts/footer.php");
    }

    public function simpan_karyawan()
    {
        // Mengambil data dari form
        $Nama = $this->input->post('Nama_karyawan', true);
        $Nomor_Identitas = $this->input->post('Nomor_Identitas', true);
        $Alamat = $this->input->post('Alamat_karyawan', true);
        $Informasi_Kontak = $this->input->post('Informasi_Kontak', true);

        // Konfigurasi upload gambar
        $config['upload_path'] = './assets_2/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = uniqid(); // Generate unique file name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            // Jika upload gagal, tampilkan pesan error
            $error = array('error' => $this->upload->display_errors());
            // Handle error disini, misalnya:
            echo "Error uploading file: " . $error['error'];
        } else {
            // Jika upload berhasil, ambil data gambar yang diupload
            $data_upload = $this->upload->data();

            // Simpan data karyawan beserta nama file gambar ke database
            $data = array(
                'Nama_karyawan' => $Nama,
                'Nomor_Identitas' => $Nomor_Identitas,
                'Alamat_karyawan' => $Alamat,
                'Informasi_Kontak' => $Informasi_Kontak,
                'gambar' => $data_upload['file_name'] // Simpan nama file gambar ke database
            );

            $this->Mkaryawan->simpan_karyawan($data);

            redirect('tugas_uts/data_karyawan');
        }
    }
    public function del_data($id_karyawan)
    {
        $this->Mkaryawan->fmDelete($id_karyawan);
        redirect('tugas_uts/data_karyawan');
    }

    public function edit_karyawan($id_karyawan)
    {
        // Ambil data karyawan berdasarkan ID
        $data['karyawan'] = $this->Mkaryawan->get_karyawan_by_id($id_karyawan);
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('edit_data', $data);
        $this->load->view("template_uts/footer.php");
    }

    public function update_karyawan()
    {
        // Ambil data dari form
        $id_karyawan = $this->input->post('id_karyawan');
        $Nama = $this->input->post('Nama_karyawan');
        $Nomor_Identitas = $this->input->post('Nomor_Identitas');
        $Alamat = $this->input->post('Alamat_karyawan');
        $Informasi_Kontak = $this->input->post('Informasi_Kontak');
    
        // Validasi apakah ID karyawan tersedia
        if (empty($id_karyawan)) {
            show_error('ID karyawan tidak valid');
            return;
        }
    
        // Pastikan bahwa file gambar diupload dengan benar
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path'] = './assets_2/upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = uniqid(); // Generate unique file name
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('gambar')) {
                // Jika upload gagal, tangani error dengan cara yang lebih baik
                $error_msg = $this->upload->display_errors();
                show_error("Error uploading file: $error_msg");
                return;
            }
    
            // Jika upload berhasil, ambil data gambar yang diupload
            $data_upload = $this->upload->data();
    
            // Simpan data ke dalam array
            $data = array(
                'Nama_karyawan' => $Nama,
                'Nomor_Identitas' => $Nomor_Identitas,
                'Alamat_karyawan' => $Alamat,
                'Informasi_Kontak' => $Informasi_Kontak,
                'gambar' => $data_upload['file_name'] // Simpan nama file gambar ke database
            );
        } else {
            // Jika tidak ada file yang diupload, hanya update data tanpa gambar
            $data = array(
                'Nama_karyawan' => $Nama,
                'Nomor_Identitas' => $Nomor_Identitas,
                'Alamat_karyawan' => $Alamat,
                'Informasi_Kontak' => $Informasi_Kontak,
            );
        }
    
        // Panggil model untuk melakukan update data karyawan
        $result = $this->Mkaryawan->update_karyawan($id_karyawan, $data);
        
        if (!$result) {
            // Handle jika update gagal
            show_error('Gagal melakukan update data karyawan.');
            return;
        }
    
        // Redirect kembali ke halaman data karyawan
        redirect('tugas_uts/data_karyawan');
    }

    
    //divisi
    public function data_divisi()
    {
        // Get data divisi from model
        $data['divisi'] = $this->Divisi_model->get_all_divisi();
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('vdivisi', $data);
        $this->load->view("template_uts/footer.php");

    }

    public function tambah_divisi()
    {
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('tambah_divisi');
        $this->load->view("template_uts/footer.php");
    }

    public function simpan_divisi()
    {
        // Ambil data dari form
        $nama_divisi = $this->input->post('nama_divisi');
        $shift = $this->input->post('shift');

        // Buat array data untuk disimpan ke database
        $data = array(
            'nama_divisi' => $nama_divisi,
            'shift' => $shift
        );

        // Panggil model untuk menyimpan data divisi
        $this->Divisi_model->simpan_divisi($data);

        // Redirect ke halaman data divisi
        redirect('Tugas_uts/data_divisi');
    }

    public function edit_divisi($id_divisi)
    {
        $data['divisi'] = $this->Divisi_model->get_divisi_by_id($id_divisi);
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('edit_divisi', $data);
        $this->load->view("template_uts/footer.php");
    }

    public function del_divisi($id_divisi)
    {
        // Hapus data divisi berdasarkan ID menggunakan model
        $this->Divisi_model->delete_divisi($id_divisi);

        // Redirect kembali ke halaman data divisi
        redirect('Tugas_uts/data_divisi');
    }
    public function update_divisi()
    {
        // Ambil data dari form
        $nama_divisi = $this->input->post('nama_divisi');
        $shift = $this->input->post('shift');

        // Buat array data untuk disimpan ke database
        $data = array(
            'nama_divisi' => $nama_divisi,
            'shift' => $shift
        );

        // Panggil model untuk melakukan update data divisi
        $this->Divisi_model->update_divisi($id_divisi, $data);

        // Redirect ke halaman data divisi
        redirect('Tugas_uts/data_divisi');
    }
    //absen
    public function absen_karyawan()
{
    // Ambil data karyawan dan divisi dari model
    $this->load->model('Mkaryawan');
    $this->load->model('Divisi_model');
    
    // Fetch data for dropdowns
    $data['karyawan'] = $this->Mkaryawan->get_all_karyawan();
    $data['divisi'] = $this->Divisi_model->get_all_divisi();
    
    // Jika form disubmit, tangani logika untuk memasukkan data absensi karyawan ke dalam database
    if ($this->input->post()) {
        // Ambil data dari form
        $data_absen = array(
            'tgl' => $this->input->post('tgl'),
            'jam_msk' => $this->input->post('jam_msk'),
            'jam_klr' => $this->input->post('jam_klr'),
            'keterangan' => $this->input->post('keterangan'),
            'id_divisi' => $this->input->post('id_divisi'),
            'id_karyawan' => $this->input->post('id_karyawan')
        );
    
        // Panggil model untuk menyimpan data absensi
        $this->load->model('Mabsen');
        $this->Mabsen->insert_absen($data_absen);
    
        // Redirect atau tampilkan pesan sukses jika diperlukan
        // Di sini saya hanya akan redirect ke halaman kehadiran, tanpa menampilkan pesan sukses
        redirect('Tugas_uts/kehadiran');
    } else {
        // Jika tidak disubmit, tampilkan form absensi
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('vdataabsensi', $data); // Assuming the view file name is "vdataabsensi.php"
        $this->load->view("template_uts/footer.php");
    }
}
    
    public function kehadiran()
    {
        $data['absensi'] = $this->Mabsen->get_absensi();
        // Load view dengan data absensi
        $this->load->view("template_uts/head.php");
        $this->load->view("template_uts/sidebar.php");
        $this->load->view("template_uts/navbar.php");
        $this->load->view('kehadiranku', $data);
        $this->load->view("template_uts/footer.php");
    }
    
}
?>