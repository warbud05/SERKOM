<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagihanController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PenggunaanModel'); 
        $this->load->model('PelangganModel'); 
        $this->load->model('TarifModel');  
        $this->load->model('TagihanModel'); // Memuat model TagihanModel
        
        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    // Fungsi untuk menampilkan semua data tagihan
    public function index() {
        $data['title'] = 'Tagihan Listrik Pelanggan';
        $data['tagihan'] = $this->TagihanModel->ambil_semua_tagihan();
        $data['penggunaan'] = $this->PenggunaanModel->ambil_semua_penggunaan();
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();

        // Mendapatkan ID petugas dari sesi
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/tagihan/index', $data); // Menampilkan view dengan data tagihan
        $this->load->view('templates/footer');
    }


    // Fungsi untuk tunggakan
    public function tunggakan() {
        $data['title'] = 'Tunggakan Pelanggan';
        $data['tunggakan'] = $this->TagihanModel->pelanggan_menunggak();

        // Mendapatkan ID petugas dari sesi
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/tagihan/tunggakan', $data); // Menampilkan view dengan data tagihan
        $this->load->view('templates/footer');
    }
}
