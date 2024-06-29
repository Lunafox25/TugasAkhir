<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubahprofil extends MY_Controller {

    public function __construct() {
        $this->accessible_roles = [1, 2];
        parent::__construct();

        $this->load->model('Model_karyawan');
        $this->load->model('Jabatan_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $user = $this->session->userdata('user_data');
        if (!$user) {
            redirect('login');
            return;
        }

        $id = $user['id_karyawan']; // Assuming 'id_karyawan' is the key for user ID in session data

        $data['karyawan'] = $this->Model_karyawan->get_karyawan_by_id($id);
        if (empty($data['karyawan'])) {
            show_404();
            return;
        }

        $data['user'] = $this->session->userdata('user_data');
        $data['jabatans'] = $this->Jabatan_model->get_all_jabatan();
        $data['title'] = 'Ubah Profil';
        $data['main_view'] = 'ubahprofil';
        $this->load->view('layout', $data);
    }

    public function ubahprofil() {
        $user = $this->session->userdata('user_data');
        if (!$user) {
            show_404();
            return;
        }

        $id = $user['id_karyawan']; // Assuming 'id_karyawan' is the key for user ID in session data
        // Your logic for this method
    }

    public function updateprofil() {
        $user = $this->session->userdata('user_data');
        if (!$user) {
            show_404();
            return;
        }

        $id = $user['id_karyawan']; // Assuming 'id_karyawan' is the key for user ID in session data

        $this->form_validation->set_rules('id_karyawan', 'ID Karyawan', 'required');
        $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
        $this->form_validation->set_rules('telp', 'No Telp', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $data = [
                'id_karyawan' => $this->input->post('id_karyawan', TRUE),
                'nama_karyawan' => $this->input->post('nama_karyawan', TRUE),
                'telp' => $this->input->post('telp', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'username' => $this->input->post('username', TRUE),
                'id_jabatan' => $this->input->post('id_jabatan', TRUE)
            ];

            // Pass the data and password to the model
            $password = $this->input->post('password', TRUE);
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->Model_karyawan->update_karyawan($id, $data)) {
                $this->session->set_flashdata('success', 'Profil anda berhasil diubah.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat mengubah data.');
            }
            redirect('pesanan');
        }
    }
}
