<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenggunaanModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil semua data penggunaan
    public function ambil_semua_penggunaan() {
        $query = $this->db->get('penggunaan');
        return $query->result_array();
    }

    // Menambah data penggunaan
    public function tambah_penggunaan($data) {
        $this->db->insert('penggunaan', $data);
        return $this->db->insert_id(); // Mengembalikan ID dari record yang baru dimasukkan
    }

    // Menambah tagihan
    public function tambah_tagihan($data) {
        $this->db->insert('tagihan', $data);
    }

    // Ambil id tarif berdasarkan id_pelanggan yang di input pada tambah penggunaan
    public function ambil_id_tarif($id_pelanggan) {
        $this->db->select('id_tarif');
        $this->db->from('pelanggan');
        $this->db->where('id_pelanggan', $id_pelanggan);
        $query = $this->db->get();
        return $query->row()->id_tarif;
    }

    public function ambil_tarif_berdasarkan_id($id_tarif) {
        $this->db->where('id_tarif', $id_tarif);
        $query = $this->db->get('tarif');
        return $query->row();
    }


    // 
    public function hapus_tagihan_berdasarkan_penggunaan($id_penggunaan) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        $this->db->delete('tagihan');
    }

    public function hapus_penggunaan($id_penggunaan) {
        $this->db->where('id_penggunaan', $id_penggunaan);
        $this->db->delete('penggunaan');
    }

    
    // Fungsi untuk memperbarui data penggunaan listrik
    public function update_penggunaan($id_penggunaan, $data) {
        // Periksa apakah $data adalah array
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data harus berupa array');
        }

        $this->db->where('id_penggunaan', $id_penggunaan);
        return $this->db->update('penggunaan', $data);
    }


    // Metode untuk memperbarui data penggunaan listrik
    public function update_tagihan($id_penggunaan, $data) {
        // Periksa apakah $data adalah array
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data harus berupa array');
        }

        $this->db->where('id_penggunaan', $id_penggunaan);
        return $this->db->update('penggunaan', $data);
    } 


}
