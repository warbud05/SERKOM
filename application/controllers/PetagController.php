<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PetagController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');  

        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    public function index() {
        $data['title'] = 'Petugas dan Agen';
        $data['petag'] = $this->UserModel->get_petugas_list();

        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/petag/index', $data); 
        $this->load->view('templates/footer');
    }

    public function tambah() {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);

        $foto_profil = NULL;

        if (!empty($_FILES['foto_profil']['name'])) {
            if ($this->upload->do_upload('foto_profil')) {
                $foto_profil = $this->upload->data('file_name');
            } else {
                $foto_profil = NULL; 
            }
        }

$data = array(
        'nama_petugas' => $this->input->post('nama_petugas'),
        'alamat' => $this->input->post('alamat'),
        'no_telepon' => $this->input->post('no_telepon'),
        'jk' => $this->input->post('jk'),
        'foto_profil' => $foto_profil,
        'username' => $this->input->post('username'),
        // Ganti md5() dengan password_hash()
        'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
        'biaya_admin' => $this->input->post('biaya_admin'),
        'akses' => $this->input->post('akses')
    );

        $id_petugas = $this->UserModel->tambah_petugas($data);
        $this->session->set_flashdata('alert', 'tambah_petugas_berhasil');
        redirect('petag'); 
    }


    // Update Petugas atau Agen
    public function update($id) {
        if (empty($id)) {
            $this->session->set_flashdata('alert', 'id_tidak_valid');
            redirect('petag');
        }

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);

        $foto_profil = NULL;

        if (!empty($_FILES['foto_profil']['name'])) {
            if ($this->upload->do_upload('foto_profil')) {
                $foto_profil = $this->upload->data('file_name');
            } else {
                $foto_profil = NULL; 
            }
        }

        $data = array(
        'nama_petugas' => $this->input->post('nama_petugas'),
        'alamat' => $this->input->post('alamat'),
        'no_telepon' => $this->input->post('no_telepon'),
        'jk' => $this->input->post('jk'),
        'username' => $this->input->post('username'),
        'biaya_admin' => $this->input->post('biaya_admin'),
        'akses' => $this->input->post('akses')
    );

    // Tambahkan password ke array data HANYA jika diisi
    if (!empty($this->input->post('password'))) {
        $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
    }
    
    // Tambahkan foto profil jika ada foto baru
    if ($foto_profil) {
        $data['foto_profil'] = $foto_profil;
    }

    $this->UserModel->update_petugas($id, $data);
        $this->session->set_flashdata('alert', 'update_petugas_berhasil');
        redirect('petag');
    }


    // fungsi Hapus Petugas
    public function hapus($id) {
        if (empty($id)) {
            $this->session->set_flashdata('alert', 'id_tidak_valid');
            redirect('petag');
        }

        $this->UserModel->hapus_petugas($id);

        $this->session->set_flashdata('alert', 'hapus_petugas_berhasil');
        redirect('petag');
    }

}
?>
