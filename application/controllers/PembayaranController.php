<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembayaranController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('PenggunaanModel'); 
        $this->load->model('PelangganModel'); 
        $this->load->model('TarifModel');  
        $this->load->model('TagihanModel');
        $this->load->model('PembayaranModel');

        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); 
        }
    }

    public function index() {
        $data['title'] = 'Pembayaran Tagihan';
        $data['pembayaran'] = $this->PembayaranModel->ambil_tagihan_belum_bayar();
        $data['tagihan'] = $this->TagihanModel->ambil_semua_tagihan();
        $data['penggunaan'] = $this->PenggunaanModel->ambil_semua_penggunaan();
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();

        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/pembayaran/index', $data); 
        $this->load->view('templates/footer');
    }

    public function riwayat_pembayaran() {
        $data['title'] = 'Riwayat Pembayaran'; 

        $id_petugas = $this->session->userdata('session_id');
        $akses = $this->session->userdata('session_akses');

        if ($akses == 'Agen') {
            $data['pembayaran'] = $this->PembayaranModel->ambil_pembayaran_by_petugas($id_petugas);
        } else { 
            $data['pembayaran'] = $this->PembayaranModel->ambil_semua_pembayaran();
        }

        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id_petugas);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/pembayaran/riwayat_pembayaran', $data);
        $this->load->view('templates/footer', $data); 
    }

    public function bayar() {
        $id_petugas_login = $this->session->userdata('session_id');

        $agen_data = $this->UserModel->dapatkan_petugas_berdasarkan_id($id_petugas_login);
        $biaya_admin_agen = $agen_data['biaya_admin'];

        $id_tagihan = $this->input->post('id_tagihan');
        $id_penggunaan = $this->input->post('id_penggunaan');
        $id_pelanggan = $this->input->post('id_pelanggan');
        $no_meter = $this->input->post('no_meter');
        $meter_awal = $this->input->post('meter_awal');
        $meter_akhir = $this->input->post('meter_akhir');
        $kode_tarif = $this->input->post('kode_tarif');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $nama_pelanggan = $this->input->post('nama_pelanggan');
        $jumlah_meter = $this->input->post('jumlah_meter');

        $tarif_perkwh = $this->sanitize_currency($this->input->post('tarif_perkwh'));
        $tagihan_listrik = $this->sanitize_currency($this->input->post('tagihan_listrik'));
        $denda = $this->sanitize_currency($this->input->post('denda')); 
        $total_bayar = $this->sanitize_currency($this->input->post('total_bayar'));
        $jumlah_uang = $this->sanitize_currency($this->input->post('jumlah_uang'));

        $uang_kembali = $this->hitungan_uang_kembali($jumlah_uang, $total_bayar);

        if ($jumlah_uang < $total_bayar) {
            $this->session->set_flashdata('error', 'Jumlah uang tidak mencukupi total bayar.');
            redirect('pembayaran');
            return;
        }

        $this->PembayaranModel->ubah_status_tagihan($id_tagihan, 'Sudah Terbayar');

        $data_pembayaran = array(
            'id_tagihan' => $id_tagihan,
            'id_penggunaan' => $id_penggunaan,
            'id_petugas' => $id_petugas_login, 
            'id_pelanggan' => $id_pelanggan,
            'no_meter' => $no_meter,
            'meter_awal' => $meter_awal,
            'meter_akhir' => $meter_akhir,
            'kode_tarif' => $kode_tarif,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nama_pelanggan' => $nama_pelanggan,
            'jumlah_meter' => $jumlah_meter,
            'tarif_perkwh' => $tarif_perkwh,
            'tagihan_listrik' => $tagihan_listrik,
            'biaya_admin' => $biaya_admin_agen, 
            'denda' => $denda,
            'total_bayar' => $total_bayar,
            'jumlah_uang' => $jumlah_uang,
            'uang_kembali' => $uang_kembali
        );

        $this->PembayaranModel->simpan_pembayaran($data_pembayaran);
        $this->session->set_flashdata('success', 'Pembayaran berhasil.');
        redirect('PembayaranController/bukti_bayar/' . $id_tagihan);
    }


    private function sanitize_currency($currency) {
        return (int) preg_replace('/[^0-9]/', '', $currency);
    }

    private function hitungan_uang_kembali($jumlah_uang, $total_bayar) {
        return $jumlah_uang - $total_bayar;
    }


    public function bukti_bayar($id_tagihan) {

        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $data['pembayaran'] = $this->PembayaranModel->get_pembayaran_by_id($id_tagihan);

        if (!$data['pembayaran']) {
            show_404(); 
        }

        $this->load->view('backend/pembayaran/bukti_bayar', $data);
    }
}
