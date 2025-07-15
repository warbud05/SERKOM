<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TarifController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('TarifModel'); // Memuat model TarifModel
        $this->load->library('session'); // Memuat library session

        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    // Menampilkan daftar tarif
    public function index() {
        $data['title'] = 'Daftar Tarif';
        $data['tarif'] = $this->TarifModel->lihat_tarif(); // Mendapatkan semua tarif dari model
        
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/tarif/index', $data); // Tampilkan daftar tarif
        $this->load->view('templates/footer');
    }

    // Menambahkan tarif
    public function tambah() {
        // Ambil data dari input POST
        $data = array(
            'kode_tarif' => $this->input->post('kode_tarif'),
            'golongan' => $this->input->post('golongan'),
            'daya' => $this->input->post('daya'),
            'tarif_perkwh' => $this->input->post('tarif_perkwh')
        );

        // Coba simpan data ke model
        if ($this->TarifModel->tambah_tarif($data)) {
            // Jika berhasil, set pesan sukses
            $this->session->set_flashdata('alert', 'tambah_tarif_berhasil');
        } else {
            // Jika gagal, set pesan gagal
            $this->session->set_flashdata('alert', 'tambah_tarif_gagal');
        }

        // Redirect ke halaman tarif
        redirect('tarif');
    }

    // Memperbarui tarif
    public function update($id) {
        // Ambil data dari input POST
        $data = array(
            'kode_tarif' => $this->input->post('kode_tarif'),
            'golongan' => $this->input->post('golongan'),
            'daya' => $this->input->post('daya'),
            'tarif_perkwh' => $this->input->post('tarif_perkwh')
        );

        // Coba update data ke model
        if ($this->TarifModel->update_tarif($id, $data)) {
            $this->session->set_flashdata('alert', 'update_tarif_berhasil');
        } else {
            $this->session->set_flashdata('alert', 'update_tarif_gagal');
        }

        // Redirect ke halaman tarif
        redirect('tarif');
    }

    // Menghapus tarif
    public function hapus($id) {
        if ($this->TarifModel->hapus_tarif($id)) {
            $this->session->set_flashdata('alert', 'hapus_tarif_berhasil');
        } else {
            $this->session->set_flashdata('alert', 'hapus_tarif_gagal');
        }
        redirect('tarif');
    }
}
