<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends MY_Controller {

    public function __construct() {
        $this->accessible_roles = [1];
        parent::__construct();
        
        $this->load->model('Model_karyawan');
        $this->load->model('Jabatan_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
        $data['user'] = $user;
        $data['title'] = 'Data Karyawan';
        $data['main_view'] = 'admin/karyawan/data_karyawan';
        $data['karyawans'] = $this->Model_karyawan->get_karyawan();
        $this->load->view('layout', $data);}
    }

    public function create() {
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Tambah Data Karyawan';
        $data['main_view'] = 'admin/karyawan/tambah_karyawan';
        $data['jabatans'] = $this->Jabatan_model->get_all_jabatan();
        $this->load->view('layout', $data);
    }

    public function store() {
        $this->form_validation->set_rules('id_karyawan', 'ID Karyawan', 'required');
        $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
        $this->form_validation->set_rules('telp', 'No Telp', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'id_karyawan' => $this->input->post('id_karyawan'),
                'nama_karyawan' => $this->input->post('nama_karyawan'),
                'telp' => $this->input->post('telp'),
                'alamat' => $this->input->post('alamat'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'id_jabatan' => $this->input->post('id_jabatan')
            ];

            $this->Model_karyawan->insert_karyawan($data);
            $this->session->set_flashdata('success', 'Data Karyawan berhasil ditambahkan.');
            redirect('karyawan'); // redirect ke index method dari Jabatan controller
        }
    }
    public function edit($id) {
        if (empty($id)) {
            show_404();
            return;
        }
        $data['karyawan'] = $this->Model_karyawan->get_karyawan_by_id($id);
        if (empty($data['karyawan'])) {
            show_404();
            return;
        }
        $data['user'] = $this->session->userdata('user_data');
        $data['jabatans'] = $this->Jabatan_model->get_all_jabatan();
        $data['title'] = 'Edit Data Karyawan';
        $data['main_view'] = 'admin/karyawan/edit_karyawan';
        $this->load->view('layout', $data);
    }

    public function update($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id_karyawan', 'ID Karyawan', 'required');
        $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
        $this->form_validation->set_rules('telp', 'No Telp', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
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
                $data['password'] = $password;
            }

            if ($this->Model_karyawan->update_karyawan($id, $data)) {
                $this->session->set_flashdata('success', 'Data Karyawan berhasil diubah.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat mengubah data.');
            }
            redirect('karyawan');
        }
    }
    
    public function cancel() {
        redirect('karyawan');
    }
    
    public function delete($id) {
        if (empty($id)) {     
            show_404();
            return;
        }

        $this->Model_karyawan->delete_karyawan($id);
        $this->session->set_flashdata('success', 'Data Karyawan berhasil dihapus.');
        redirect('karyawan'); 
    }
}