<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembayaranModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

        // Fungsi baru untuk mengambil data laporan pendapatan Agen dengan filter tanggal
    public function get_laporan_pendapatan_agen($id_petugas, $start_date = null, $end_date = null) {
        $this->db->select('id_tagihan, nama_pelanggan, tanggal_pembayaran, biaya_admin');
        $this->db->from('pembayaran');
        $this->db->where('id_petugas', $id_petugas);

        if ($start_date) {
            $this->db->where('tanggal_pembayaran >=', $start_date . ' 00:00:00');
        }

        if ($end_date) {
            $this->db->where('tanggal_pembayaran <=', $end_date . ' 23:59:59');
        }

        $this->db->order_by('tanggal_pembayaran', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function ambil_tagihan_belum_bayar() {
        // Menggunakan Query Builder untuk memudahkan penulisan query
        $this->db->select('
            tagihan.*, 
            pelanggan.nama AS nama_pelanggan,
            pelanggan.no_meter,
            penggunaan.bulan, 
            penggunaan.tahun, 
            penggunaan.meter_awal, 
            penggunaan.meter_akhir, 
            penggunaan.tgl_cek, 
            petugas.nama_petugas,
            petugas.biaya_admin,
            tarif.kode_tarif, 
            tarif.golongan, 
            tarif.daya, 
            tarif.tarif_perkwh
        ');

        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->join('penggunaan', 'tagihan.id_penggunaan = penggunaan.id_penggunaan', 'left');
        $this->db->join('petugas', 'penggunaan.id_petugas = petugas.id_petugas', 'left');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');  // Bergabung dengan tabel tarif
        $this->db->where('tagihan.status', 'Belum Dibayar');

        
        $query = $this->db->get();
        $tagihan_belum_bayar = $query->result();
        
        // Array untuk menyimpan denda per pelanggan
        $denda_per_pelanggan = [];
        
        // Menghitung jumlah tagihan per pelanggan
        foreach ($tagihan_belum_bayar as $tagihan) {
            $id_pelanggan = $tagihan->id_pelanggan;
            
            if (!isset($denda_per_pelanggan[$id_pelanggan])) {
                $denda_per_pelanggan[$id_pelanggan] = 0;
            }
            
            $denda_per_pelanggan[$id_pelanggan]++;
        }
        
        // Menentukan denda berdasarkan jumlah tagihan
        $denda = [];
        foreach ($denda_per_pelanggan as $id_pelanggan => $jumlah_tagihan) {
            if ($jumlah_tagihan >= 2) {
                $denda[$id_pelanggan] = 5500 * ($jumlah_tagihan - 1);
            } else {
                $denda[$id_pelanggan] = 0;
            }
        }
        
        // Menambahkan denda ke setiap tagihan
        foreach ($tagihan_belum_bayar as &$tagihan) {
            $id_pelanggan = $tagihan->id_pelanggan;
            $tagihan->denda = isset($denda[$id_pelanggan]) ? $denda[$id_pelanggan] : 0;
        }
        
        // Mengembalikan hasil sebagai array objek
        return $tagihan_belum_bayar;
    }


    // Fungsi Bayar
    public function proses_pembayaran($id_tagihan, $jumlah_uang) {
        // Implementasikan logika untuk memproses pembayaran
        // Misalnya, mengurangi tagihan dan mencatat pembayaran
        
        // Contoh query sederhana
        $data = array(
            'jumlah_uang' => $jumlah_uang
        );

        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update('tagihan', $data);
    }

    public function ubah_status_tagihan($id_tagihan, $status) {
        // Update status tagihan
        $this->db->set('status', $status);
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->update('tagihan');
    }
    
    
    // Fungsi untuk menyimpan data pembayaran
    public function simpan_pembayaran($data) {
        // Pastikan data adalah array yang sesuai dengan struktur tabel
        if (is_array($data)) {
            // Insert data into 'pembayaran' table
            $this->db->insert('pembayaran', $data);

            // Mengecek apakah insert berhasil
            if ($this->db->affected_rows() > 0) {
                return true; // Berhasil
            } else {
                return false; // Gagal
            }
        } else {
            return false; // Data tidak valid
        }
    }

    // Ambil Pembayaran By Id
    public function get_pembayaran_by_id($id_tagihan) {
        $this->db->from('pembayaran'); // Pastikan nama tabel sesuai
        $this->db->where('id_tagihan', $id_tagihan);
        $query = $this->db->get();
        return $query->row(); // Mengembalikan satu baris data
    }


    public function ambil_pembayaran_by_petugas($id_petugas) {
        $this->db->from('pembayaran');
        $this->db->where('id_petugas', $id_petugas);
        $this->db->order_by('tanggal_pembayaran', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Fungsi untuk mengambil semua pembayaran
    public function ambil_semua_pembayaran() {
        // Menentukan tabel yang digunakan
        $this->db->from('pembayaran');
        
        // Mengambil semua data dari tabel pembayaran
        $query = $this->db->get();
        
        // Mengembalikan hasil query sebagai array
        return $query->result_array();
    }

}
