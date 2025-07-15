<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelangganController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PelangganModel'); 
        $this->load->model('TarifModel');  
        $this->load->model('UserModel'); 

        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); 
        }
    }

    public function index() {
        $data['title'] = 'Daftar Pelanggan';
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();
        
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $data['alert'] = $this->session->flashdata('alert');
        
        $this->load->view('templates/header', $data);
        $this->load->view('backend/pelanggan/index', $data); 
        $this->load->view('templates/footer');
    }

    public function detail($id) {
        $data['pelanggan'] = $this->PelangganModel->ambil_pelanggan_berdasarkan_id($id);
        $this->load->view('pelanggan/detail', $data); 
    }

    public function tambah() {
        if ($this->input->post()) {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'no_meter' => $this->input->post('no_meter'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tenggang' => $this->input->post('tenggang'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            $this->PelangganModel->tambah_pelanggan($data);
            $this->session->set_flashdata('alert', 'tambah_sukses'); 
            redirect('pelanggan'); 
        } else {
            $this->load->view('pelanggan/tambah'); 
        }
    }

    public function perbarui($id) {
        if ($this->input->post()) {
            $data = array(
                'no_meter' => $this->input->post('no_meter'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tenggang' => $this->input->post('tenggang'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            $this->PelangganModel->perbarui_pelanggan($id, $data);
            $this->session->set_flashdata('alert', 'update_sukses'); 
            redirect('pelanggan'); 
        } else {
            $data['pelanggan'] = $this->PelangganModel->ambil_pelanggan_berdasarkan_id($id);
            $this->load->view('pelanggan/perbarui', $data); 
        }
    }

    public function hapus($id) {
        $this->PelangganModel->hapus_pelanggan($id);
        $this->session->set_flashdata('alert', 'hapus_sukses'); 
        redirect('pelanggan'); 
    }

    public function ajaxIndex() {
        header('Content-Type: application/json');

        if (ob_get_contents()) ob_end_clean();

        $data = $this->PelangganModel->get_pelanggan();

        $json_data = json_encode($data);
        log_message('debug', 'JSON Data: ' . $json_data);

        echo $json_data;
        exit(); 
    }

    public function get_detail_json($id_pelanggan) {
        // Membersihkan buffer output yang mungkin ada sebelumnya untuk mencegah 'sampah'
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Panggil model untuk mendapatkan detail pelanggan
        $detail_pelanggan = $this->PelangganModel->ambil_detail_pelanggan_dengan_daya($id_pelanggan);
        
        $response = []; // Inisialisasi array response

        if ($detail_pelanggan) {
            $response = [
                'status' => 'success',
                'data'   => $detail_pelanggan
            ];
            // Set header HTTP Status 200 OK
            $this->output->set_status_header(200);
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Pelanggan tidak ditemukan'
            ];
            // Set header HTTP Status 404 Not Found
            $this->output->set_status_header(404);
        }

        // Gunakan metode output CI3 yang lebih andal untuk JSON
        $this->output
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($response, JSON_PRETTY_PRINT))
             ->_display();
        
        // Pastikan eksekusi script berhenti di sini
        exit;
    }

}
?>
