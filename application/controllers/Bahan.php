<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends MY_Controller {
    
    public function __construct() {
        $this->accessible_roles = [1, 2];
        parent::__construct();
        $this->load->model('Bahan_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
        $data['user'] = $user;
        $data['title'] = 'Data Bahan';
        $data['main_view'] = 'data_bahan';
        $data['bahans'] = $this->Bahan_model->get_all_bahan();
        $this->load->view('layout', $data);
        }
    }

    public function create() {
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Tambah Data Bahan';
        $data['main_view'] = 'tambah_bahan';
        $this->load->view('layout', $data);
    }

    public function store() {
        $this->form_validation->set_rules('id_bahan', 'ID Bahan', 'required');
        $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('hrg_bahan_display', 'Harga Bahan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $hrg_bahan_display = $this->input->post('hrg_bahan_display');
            $hrg_bahan = preg_replace('/\D/', '', $hrg_bahan_display); // Remove non-digit characters

            $data = [
                'id_bahan' => $this->input->post('id_bahan'),
                'nama_bahan' => $this->input->post('nama_bahan'),
                'satuan' => $this->input->post('satuan'),
                'hrg_bahan' => $hrg_bahan,
            ];

            $this->Bahan_model->insert_bahan($data);
            $this->session->set_flashdata('success', 'Bahan berhasil ditambahkan.');
            redirect('bahan'); // redirect ke index method dari bahan controller
        }
    }

    public function edit($id) {
        if (empty($id)) {
            show_404();
            return;
        }
        $data['bahan'] = $this->Bahan_model->get_bahan_by_id($id);
        if (empty($data['bahan'])) {
            show_404();
            return;
        }
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Edit Data Bahan';
        $data['main_view'] = 'edit_bahan';
        $this->load->view('layout', $data);
    }

    public function update($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id_bahan', 'ID Bahan', 'required');
        $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('hrg_bahan_display', 'Harga Bahan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $hrg_bahan_display = $this->input->post('hrg_bahan_display');
            $hrg_bahan = preg_replace('/\D/', '', $hrg_bahan_display); // Remove non-digit characters

            $data = [
                'id_bahan' => $this->input->post('id_bahan'),
                'nama_bahan' => $this->input->post('nama_bahan'),
                'satuan' => $this->input->post('satuan'),
                'hrg_bahan' => $hrg_bahan,
            ];

            $this->Bahan_model->update_bahan($id, $data);
            $this->session->set_flashdata('success', 'Bahan berhasil diubah.');
            redirect('bahan'); 
        }
    }

    public function cancel() {
        redirect('bahan');
    }

    public function delete($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->Bahan_model->delete_bahan($id);
        $this->session->set_flashdata('success', 'Bahan berhasil dihapus.');
        redirect('bahan'); 
    }
}
