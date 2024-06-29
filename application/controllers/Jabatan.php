<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends MY_Controller {
    
    public function __construct() {
        $this->accessible_roles = [1];
        parent::__construct();
        $this->load->model('Jabatan_model');
        $this->load->library('form_validation');
        
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
        $data['user'] = $user;
        $data['title'] = 'Data Jabatan';
        $data['main_view'] = 'admin/karyawan/data_jabatan';
        $data['jabatans'] = $this->Jabatan_model->get_all_jabatan();
        $this->load->view('layout', $data);}
    }

    public function create() {
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Tambah Data Jabatan';
        $data['main_view'] = 'admin/karyawan/tambah_jabatan';
        $this->load->view('layout', $data);
    }

    public function store() {
        $this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'required');
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required');
        $this->form_validation->set_rules('id_role', 'ID Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'id_jabatan' => $this->input->post('id_jabatan'),
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'id_role' => $this->input->post('id_role'),
            ];

            $this->Jabatan_model->insert_jabatan($data);
            $this->session->set_flashdata('success', 'Jabatan berhasil ditambahkan.');
            redirect('jabatan'); // redirect ke index method dari Jabatan controller
        }
    }
    public function edit($id) {
        if (empty($id)) {
            show_404();
            return;
        }
        $data['jabatan'] = $this->Jabatan_model->get_jabatan_by_id($id);
        if (empty($data['jabatan'])) {
            show_404();
            return;
        }
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Edit Data Jabatan';
        $data['main_view'] = 'admin/karyawan/edit_jabatan';
        $this->load->view('layout', $data);
    }

    public function update($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'required');
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required');
        $this->form_validation->set_rules('id_role', 'ID Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'id_jabatan' => $this->input->post('id_jabatan'),
                'nama_jabatan' => $this->input->post('nama_jabatan'),
                'id_role' => $this->input->post('id_role'),
            ];

            $this->Jabatan_model->update_jabatan($id, $data);
            $this->session->set_flashdata('success', 'Jabatan berhasil diubah.');
            redirect('jabatan'); 
        }
    }

    public function cancel() {
        redirect('jabatan');
    }

    public function delete($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->Jabatan_model->delete_jabatan($id);
        $this->session->set_flashdata('success', 'Jabatan berhasil dihapus.');
        redirect('jabatan'); 
    }
}