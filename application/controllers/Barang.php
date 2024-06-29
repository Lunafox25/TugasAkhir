<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MY_Controller {
    
    public function __construct() {
        $this->accessible_roles = [1, 2];
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->library('form_validation');
        
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
        $data['user'] = $user;
        $data['title'] = 'Data Barang';
        $data['main_view'] = 'data_barang';
        $data['barangs'] = $this->Barang_model->get_all_barang();
        $this->load->view('layout', $data);}
    }

    public function create() {
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Tambah Data Barang';
        $data['main_view'] = 'tambah_barang';
        $this->load->view('layout', $data);
    }

    public function store() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('desc_barang', 'Deskripsi Barang', 'required');
        $this->form_validation->set_rules('ukuran', 'Ukuran', 'required');
        $this->form_validation->set_rules('harga_display', 'Harga Barang', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $harga_display = $this->input->post('harga_display');
            $harga = preg_replace('/\D/', '', $harga_display); // Remove non-digit characters

            $data = [
                'id_barang' => $this->input->post('id_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'desc_barang' => $this->input->post('desc_barang'),
                'ukuran' => $this->input->post('ukuran'),
                'harga' => $harga,
            ];

            $this->Barang_model->insert_barang($data);
            $this->session->set_flashdata('success', 'Barang berhasil ditambahkan.');
            redirect('barang'); // redirect ke index method dari Barang controller
        }
    }
    public function edit($id) {
        if (empty($id)) {
            show_404();
            return;
        }
        $data['barang'] = $this->Barang_model->get_barang_by_id($id);
        if (empty($data['barang'])) {
            show_404();
            return;
        }
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Edit Data Barang';
        $data['main_view'] = 'edit_barang';
        $this->load->view('layout', $data);
    }

    public function update($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('desc_barang', 'Deskripsi Barang', 'required');
        $this->form_validation->set_rules('ukuran', 'Ukuran', 'required');
        $this->form_validation->set_rules('harga_display', 'Harga Barang', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $harga_display = $this->input->post('harga_display');
            $harga = preg_replace('/\D/', '', $harga_display); // Remove non-digit characters

            $data = [
                'id_barang' => $this->input->post('id_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'desc_barang' => $this->input->post('desc_barang'),
                'ukuran' => $this->input->post('ukuran'),
                'harga' => $harga,
            ];

            $this->Barang_model->update_barang($id, $data);
            $this->session->set_flashdata('success', 'Barang berhasil diubah.');
            redirect('barang'); 
        }
    }

    public function cancel() {
        redirect('barang');
    }

    public function delete($id) {
        if (empty($id)) {
            show_404();
            return;
        }

        $this->Barang_model->delete_barang($id);
        $this->session->set_flashdata('success', 'Barang berhasil dihapus.');
        redirect('barang'); 
    }
}