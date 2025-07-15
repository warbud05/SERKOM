<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagihanModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mengambil semua data tagihan
    public function ambil_semua_tagihan() {
        $query = $this->db->get('tagihan');
        return $query->result_array();
    }
    
    
    // Fungsi untuk menghitung denda pelanggan menunggak
    public function pelanggan_menunggak() {
        // Query untuk mengambil data pelanggan yang memiliki lebih dari satu tagihan dengan status "Belum Dibayar"
        $this->db->select('p.id_pelanggan, p.no_meter, p.nama, p.alamat, p.tenggang, p.id_tarif, COUNT(t.id_tagihan) AS jumlah_tagihan');
        $this->db->from('tagihan t');
        $this->db->join('pelanggan p', 't.id_pelanggan = p.id_pelanggan');
        $this->db->where('t.status', 'Belum Dibayar');
        $this->db->group_by('p.id_pelanggan');
        $this->db->having('COUNT(t.id_tagihan) > 1');
        
        $result = $this->db->get()->result_array();

        // Menghitung denda berdasarkan jumlah tagihan
        $denda_per_tagihan = 5500;
        $denda_pelanggan = [];

        foreach ($result as $row) {
            $jumlah_tagihan = $row['jumlah_tagihan'];
            $id_pelanggan = $row['id_pelanggan'];
            
            // Denda dihitung berdasarkan jumlah tagihan yang lebih dari 1
            $denda = ($jumlah_tagihan - 1) * $denda_per_tagihan;
            
            $denda_pelanggan[] = [
                'id_pelanggan' => $id_pelanggan,
                'no_meter' => $row['no_meter'],
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'tenggang' => $row['tenggang'],
                'id_tarif' => $row['id_tarif'],
                'jumlah_tagihan' => $jumlah_tagihan,
                'denda' => $denda
            ];
        }

        return $denda_pelanggan;
    }

}
