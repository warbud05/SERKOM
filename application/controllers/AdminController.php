<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); 

        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect(base_url('login'));
        }
    }

    public function index() {
        $id = $this->session->userdata('session_id');
        $akses = $this->session->userdata('session_akses');

        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);
        $data['title'] = 'Dashboard';

        if ($akses == 'Petugas') {
            $data['jumlah_pelanggan'] = $this->UserModel->ambil_jumlah_pelanggan();
            $data['jumlah_tarif'] = $this->UserModel->ambil_jumlah_tarif();
            $data['jumlah_penggunaan'] = $this->UserModel->ambil_jumlah_penggunaan();
            $data['pendapatan_sistem'] = $this->UserModel->hitung_total_pendapatan_sistem();

        } else { 
            $data['pendapatan_agen'] = $this->UserModel->hitung_total_pemasukan($id);
            $data['jumlah_transaksi_agen'] = $this->UserModel->hitung_jumlah_transaksi_by_petugas($id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('backend/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function laporan_pendapatan() {
        if ($this->session->userdata('session_akses') !== 'Agen') {
            redirect('admin'); 
            return;
        }

        $id_petugas = $this->session->userdata('session_id');

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $data['laporan'] = $this->PembayaranModel->get_laporan_pendapatan_agen($id_petugas, $start_date, $end_date);

        $total_pendapatan = 0;
        foreach ($data['laporan'] as $row) {
            $total_pendapatan += $row['biaya_admin'];
        }

        $data['total_pendapatan'] = $total_pendapatan;
        $data['total_transaksi'] = count($data['laporan']);

        $data['title'] = 'Laporan Pendapatan Agen';
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id_petugas);
        $data['start_date'] = $start_date; 
        $data['end_date'] = $end_date; 

        $this->load->view('templates/header', $data);
        $this->load->view('backend/laporan/laporan_pendapatan', $data);
        $this->load->view('templates/footer');
    }
}
