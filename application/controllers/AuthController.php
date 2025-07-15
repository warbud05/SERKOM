<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['form', 'url', 'pln_helper']);
        $this->load->model('UserModel');
    }

    public function index() {
        // Pengecekan session yang lebih kuat
        if ($this->session->has_userdata('session_id') && $this->session->userdata('session_id') != '') {
            redirect('admin');
            return;
        }

        $data['title'] = 'Login';
        $this->load->view('halaman_login', $data);
    }

    public function login() {
        // HANYA proses jika metode POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('login');
            return;
        }

        // Pengecekan ini redundan jika POST, tapi sebagai pengaman tambahan
        if ($this->session->has_userdata('session_id') && $this->session->userdata('session_id') != '') {
            redirect('admin');
            return;
        }
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
             $this->set_message('error', 'Username dan Password wajib diisi.');
             redirect('login');
             return;
        }
       
        // Lanjutkan ke authenticate jika tidak kosong
        $this->authenticate($username, $password);
    }
    
    private function authenticate($username, $password) {
        $user = $this->UserModel->dapatkan_akun_petugas($username);

        if ($user && password_verify($password, $user['password'])) {
            $this->session->sess_regenerate(TRUE);
            
            $session_data = [
                'session_id'         => $user['id_petugas'],
                'session_username'   => $user['username'],
                'session_nama_petugas' => $user['nama_petugas'],
                'session_foto'       => foto_profil_url($user['foto_profil']),
                'session_akses'      => $user['akses']
            ];
            
            $this->session->set_userdata($session_data);
            
            $this->set_message('success', 'Login berhasil! Selamat datang, ' . $user['nama_petugas']);
            redirect('admin');
        } else {
            $this->set_message('error', 'Kombinasi username dan password salah.');
            redirect('login');
        }
    }

    public function logout() {
        if ($this->session->userdata('session_id')) {
            $this->set_message('success', 'Anda telah berhasil logout.');
            $this->session->sess_destroy();
        }
        redirect('login');
    }

    private function set_message($type, $text) {
        $this->session->set_flashdata('message', [
            'type' => $type,
            'text' => $text
        ]);
    }
}