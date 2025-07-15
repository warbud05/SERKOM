<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelangganModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    // Fungsi untuk mengambil semua data pelanggan dengan join tarif
    public function ambil_semua_pelanggan() {
        $this->db->select('p.*, t.kode_tarif'); // Pilih semua kolom dari pelanggan dan kode_tarif dari tarif
        $this->db->from('pelanggan p'); // Alias tabel pelanggan
        $this->db->join('tarif t', 'p.id_tarif = t.id_tarif', 'left'); // Join tabel tarif dengan alias
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }

    // Fungsi baru untuk mengambil detail pelanggan beserta daya dari tarifnya
    public function ambil_detail_pelanggan_dengan_daya($id) {
        $this->db->select('p.id_pelanggan, p.nama, t.daya');
        $this->db->from('pelanggan p');
        $this->db->join('tarif t', 'p.id_tarif = t.id_tarif', 'left');
        $this->db->where('p.id_pelanggan', $id);
        $query = $this->db->get();
        return $query->row_array(); // Mengembalikan satu baris hasil
    }

    // Fungsi untuk mengambil pelanggan berdasarkan ID
    public function ambil_pelanggan_berdasarkan_id($id) {
        $this->db->where('id_pelanggan', $id);
        $query = $this->db->get('pelanggan');
        return $query->row_array(); // Mengembalikan satu baris hasil sebagai array
    }

    // Menambahkan pelanggan baru ke database
    public function tambah_pelanggan($data) {
        // Validasi dan sanitasi data sebelum dimasukkan ke database
        if (empty($data)) {
            return false;
        }
        // Menambahkan data ke tabel pelanggan
        $this->db->insert('pelanggan', $data);

        // Mengembalikan ID dari data yang baru saja ditambahkan
        return $this->db->insert_id();
    }

    // Fungsi untuk memperbarui data pelanggan
    public function perbarui_pelanggan($id, $data) {
        // Validasi dan sanitasi data sebelum diperbarui
        if (empty($data) || empty($id)) {
            return false;
        }
        $this->db->where('id_pelanggan', $id);
        return $this->db->update('pelanggan', $data); // Memperbarui data dan mengembalikan hasil operasi
    }

    // Fungsi untuk menghapus pelanggan berdasarkan ID
    public function hapus_pelanggan($id) {
        // Validasi ID sebelum penghapusan
        if (empty($id)) {
            return false;
        }
        $this->db->where('id_pelanggan', $id);
        return $this->db->delete('pelanggan'); // Menghapus data dan mengembalikan hasil operasi
    }
    
    // Fungsi untuk mengambil semua data pelanggan tanpa join
    public function get_pelanggan() {
        $query = $this->db->get('pelanggan'); // Ganti 'pelanggan' dengan nama tabel yang sesuai
        return $query->result_array();
    }
}
?>
