<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenggunaanController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PenggunaanModel'); 
        $this->load->model('PelangganModel'); 
        $this->load->model('TarifModel');  
        $this->load->model('UserModel'); // Load UserModel
        
        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    // Fungsi untuk menampilkan semua data pelanggan
    public function index() {
        $data['title'] = 'Penggunaan Listrik Pelanggan';
        $data['penggunaan'] = $this->PenggunaanModel->ambil_semua_penggunaan();
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();

        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/penggunaan/index', $data); // Menampilkan view dengan data pelanggan
        $this->load->view('templates/footer');
    }

    public function tambah() {
        // SECURITY CHECK: Hanya petugas yang boleh menambah penggunaan
        if ($this->session->userdata('session_akses') !== 'Petugas') {
            $this->session->set_flashdata('alert', 'akses_ditolak');
            redirect('penggunaan');
            return; // Hentikan eksekusi
        }
        
        // Ambil data dari input
        $id_pelanggan = $this->input->post('id_pelanggan');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $meter_awal = $this->input->post('meter_awal');
        $meter_akhir = $this->input->post('meter_akhir');
        $tgl_cek = date('Y-m-d');
        $id_petugas = $this->session->userdata('session_id');

        // Cek apakah input yang diperlukan ada
        if ($id_pelanggan && $bulan && $tahun && $meter_awal !== null && $meter_akhir !== null) {
            // Hitung jumlah meter
            $jumlah_meter = $meter_akhir - $meter_awal;

            // Ambil id_tarif dari pelanggan
            $id_tarif = $this->PenggunaanModel->ambil_id_tarif($id_pelanggan);

            // Ambil tarif per KWh berdasarkan id_tarif
            $tarif = $this->PenggunaanModel->ambil_tarif_berdasarkan_id($id_tarif);
            $tarif_perkwh = $tarif->tarif_perkwh;

            // Hitung jumlah bayar
            $jumlah_bayar = $jumlah_meter * $tarif_perkwh;

            // Simpan data penggunaan
            $data_penggunaan = array(
                'id_pelanggan' => $id_pelanggan,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'meter_awal' => $meter_awal,
                'meter_akhir' => $meter_akhir,
                'tgl_cek' => $tgl_cek,
                'id_petugas' => $id_petugas
            );
            
            $id_penggunaan = $this->PenggunaanModel->tambah_penggunaan($data_penggunaan);
            
            // Buat ID Tagihan
            $id_tagihan = $this->generate_id_tagihan();

            // Simpan tagihan
            $data_tagihan = array(
                'id_tagihan' => $id_tagihan,
                'id_pelanggan' => $id_pelanggan,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_meter' => $jumlah_meter,
                'tarif_perkwh' => $tarif_perkwh,
                'jumlah_bayar' => $jumlah_bayar,
                'status' => 'Belum Dibayar',
                'id_petugas' => $id_petugas,
                'id_penggunaan' => $id_penggunaan
            );

            $this->PenggunaanModel->tambah_tagihan($data_tagihan);

            $this->session->set_flashdata('alert', 'tambah_penggunaan_berhasil');
            redirect('penggunaan'); // Redirect ke halaman penggunaan
        } else {
            $this->session->set_flashdata('alert', 'gagal_tambah_penggunaan');
            redirect('penggunaan'); // Redirect ke halaman penggunaan
        }
    }

    private function generate_id_tagihan() {
        $random_number = mt_rand(10000, 99999); 
        return 'BYR-' . $random_number;
    }


    public function hapus($id_penggunaan) {
        // Cek apakah ID penggunaan valid
        if (!$id_penggunaan) {
            $this->session->set_flashdata('alert', 'gagal_hapus_penggunaan');
            redirect('penggunaan');
            return;
        }

        // Hapus data dari tabel 'penggunaan'.
        // Database akan secara otomatis menghapus data terkait di 'tagihan' dan 'pembayaran'
        // berkat ON DELETE CASCADE.
        $this->PenggunaanModel->hapus_penggunaan($id_penggunaan);

        // Set pesan sukses dan redirect.
        $this->session->set_flashdata('alert', 'hapus_penggunaan_berhasil');
        redirect('penggunaan');
    }

}
