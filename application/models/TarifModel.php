<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TarifModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memuat database
    }

    // Mengambil semua tarif dari database
    public function lihat_tarif() {
        $query = $this->db->get('tarif');
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }

    // Menambahkan tarif baru ke database
    public function tambah_tarif($data) {
        // Menambahkan data ke tabel tarif
        $this->db->insert('tarif', $data);

        // Mengembalikan ID dari data yang baru saja ditambahkan
        return $this->db->insert_id();
    }

    // Mengambil tarif berdasarkan ID
    public function get_tarif_by_id($id) {
        $query = $this->db->get_where('tarif', array('id_tarif' => $id));
        return $query->row_array(); // Mengembalikan hasil sebagai array
    }

    // Memperbarui tarif berdasarkan ID
    public function update_tarif($id, $data) {
        $this->db->where('id_tarif', $id);
        return $this->db->update('tarif', $data);
    }

    // Menghapus tarif berdasarkan ID
    public function hapus_tarif($id) {
        $this->db->where('id_tarif', $id);
        return $this->db->delete('tarif');
    }

    public function ambil_tarif_terbaru() {
        // Mengambil tarif terbaru berdasarkan ID tarif tertinggi atau kriteria lain
        $this->db->select('tarif_perkwh');
        $this->db->from('tarif');
        $this->db->order_by('id_tarif', 'DESC'); // Mengurutkan berdasarkan ID tarif yang terbaru
        $this->db->limit(1); // Mengambil hanya satu record terbaru

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan hasil query sebagai objek
        } else {
            return null; // Jika tidak ada data
        }
    }
}
