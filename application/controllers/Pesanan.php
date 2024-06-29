<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends MY_Controller {

    public function __construct() {
        $this->accessible_roles = [1, 2];
        parent::__construct();
        
        $this->load->model([
            'Model_pesanan',
            'Model_dbahan',
            'Model_dbarang',
            'Bahan_model',
            'Barang_model',
            'Jasakirim_model',
            'Situs_model',
            'Jpembayaran_model',
            'Status_model'
        ]);
        $this->load->library(['form_validation', 'session','upload']);
        $this->load->helper(['form', 'url', 'file']);
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
            $data['user'] = $user;
            $data['title'] = 'Pesanan';
            $data['pesanans'] = $this->Model_pesanan->get_all_pesanan();

            $view = $user['id_role'] == 1 ? 'admin/pesanan/data_pesanan' : 'staff/daftar_pesanan';
            $data['main_view'] = $view;

            $this->load->view('layout', $data);
        }
    }

    public function detail($id) {
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Detail Pesanan';

        // Fetch pesanan details
        $data['pesanan'] = $this->Model_pesanan->get_pesanan_by_id($id); 
        $data['detail_barangs'] = $this->Model_dbarang->get_detailbarang_by_id($id);
        $data['detail_bahans'] = $this->Model_dbahan->get_detailbahan_by_id($id);

        if (empty($data['pesanan'])) { // Added check for empty pesanan
            show_404();
            return;
        }

        $data['main_view'] = 'detail_pesanan';
        $this->load->view('layout', $data);
    }

    public function create() {
        $user = $this->session->userdata('user_data');
        $data['user'] = $user;
        if ($user['id_role'] == 2) {
            redirect('pesanan');
            return;
        }
        $data['title'] = 'Tambah Data Pesanan';
        $data['jasakirims'] = $this->Jasakirim_model->get_all_jasakirim();
        $data['situss'] = $this->Situs_model->get_all_situs();
        $data['jbayars'] = $this->Jpembayaran_model->get_all_jbayar();
        $data['statuss'] = $this->Status_model->get_all_status();
        $data['barangs'] = $this->Barang_model->get_all_barang();
        $data['bahans'] = $this->Bahan_model->get_all_bahan();
        $data['main_view'] = 'admin/pesanan/tambah_pesanan';
        $this->load->view('layout', $data);
    }

    public function store() {
        $this->form_validation->set_rules('id_pesanan', 'ID pesanan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('resi', 'Resi', 'required');
        $this->form_validation->set_rules('id_jasakirim', 'Jasa Pengiriman', 'required');
        $this->form_validation->set_rules('id_situs', 'Situs Belanja Online', 'required');
        $this->form_validation->set_rules('id_jbayar', 'Jenis Pembayaran', 'required');
        $this->form_validation->set_rules('id_status', 'Status', 'required');
        $this->form_validation->set_rules('totalharga', 'Total Harga', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data_pesanan = [
                'id_pesanan' => $this->input->post('id_pesanan'),
                'tanggal' => $this->input->post('tanggal'),
                'resi' => $this->input->post('resi'),
                'id_jasakirim' => $this->input->post('id_jasakirim'),
                'id_situs' => $this->input->post('id_situs'),
                'id_jbayar' => $this->input->post('id_jbayar'),
                'id_status' => $this->input->post('id_status'),
                'totalharga' => $this->input->post('totalharga'),
            ];
    
            $this->Model_pesanan->insert_pesanan($data_pesanan);
    
            $this->_insert_detailbarang($this->input->post('id_pesanan'));
            $this->_insert_detailbahan($this->input->post('id_pesanan'));
    
            $this->session->set_flashdata('success', 'Pesanan berhasil ditambahkan.');
            redirect('pesanan');
        }
    }
    
    private function _insert_detailbarang($id_pesanan) {
        $id_barang = $this->input->post('id_barang');
        $qty_barang = $this->input->post('qty_barang');
        $file_desain = $_FILES['file_desain'];
        $tot_hrgbarang = $this->input->post('tot_hrgbarang');
    
        if (!empty($id_barang) && is_array($id_barang)) {
            for ($i = 0; $i < count($id_barang); $i++) {
                $data_detailbarang = [
                    'kd_detailbarang' => $this->generate_unique_code('detailbarang'),
                    'id_pesanan' => $id_pesanan,
                    'id_barang' => $id_barang[$i],
                    'qty_barang' => $qty_barang[$i],
                    'tot_hrgbarang' => $tot_hrgbarang[$i],
                ];
    
                if (!empty($file_desain['name'][$i])) {
                    $upload_path = './uploads/';
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'jpg|jpeg|png|zip'; // adjust according to your needs
                    $config['file_name'] = $file_desain['name'][$i];
    
                    // Create a temporary array for each file
                    $_FILES['single_file']['name'] = $file_desain['name'][$i];
                    $_FILES['single_file']['type'] = $file_desain['type'][$i];
                    $_FILES['single_file']['tmp_name'] = $file_desain['tmp_name'][$i];
                    $_FILES['single_file']['error'] = $file_desain['error'][$i];
                    $_FILES['single_file']['size'] = $file_desain['size'][$i];
    
                    $this->upload->initialize($config); // Re-initialize the upload library with the new config
    
                    if ($this->upload->do_upload('single_file')) {
                        $upload_data = $this->upload->data();
                        $data_detailbarang['file_desain'] = $upload_path . $upload_data['file_name'];
                    } else {
                        $data_detailbarang['file_desain'] = '';
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                    }
                }
    
                $this->Model_dbarang->insert_detailbarang($data_detailbarang);
            }
        }
    }    
    

    private function _insert_detailbahan($id_pesanan) {
        $id_bahan = $this->input->post('id_bahan');
        $qty_bahan = $this->input->post('qty_bahan');
        $tot_hrgbahan = $this->input->post('tot_hrgbahan');

        if (!empty($id_bahan) && is_array($id_bahan)) {
        for ($i = 0; $i < count($id_bahan); $i++) {
            $data_detailbahan = [
                'kd_detailbahan' => $this->generate_unique_code('detailbahan'),
                'id_pesanan' => $id_pesanan,
                'id_bahan' => $id_bahan[$i],
                'qty_bahan' => $qty_bahan[$i],
                'tot_hrgbahan' => $tot_hrgbahan[$i],
            ];
            $this->Model_dbahan->insert_detailbahan($data_detailbahan);
        }
    }
    }

    private function generate_unique_code($type) {
        if ($type == 'detailbarang') {
            $code = 'DB' . mt_rand(100000000000, 999999999999);
            while ($this->Model_dbarang->check_code_exists('detailbarang', $code)) {
                $code = 'DB' . mt_rand(100000000000, 999999999999);
            }
        } elseif ($type == 'detailbahan') {
            $code = 'DN' . mt_rand(100000000000, 999999999999);
            while ($this->Model_dbahan->check_code_exists('detailbahan', $code)) {
                $code = 'DN' . mt_rand(100000000000, 999999999999);
            }
        }
        return $code;
    }

    public function edit($id) {
        $user = $this->session->userdata('user_data');
        if (empty($id)) {
            show_404();
            return;
        }

        $data['user'] = $user;
        if ($user['id_role'] == 2) {
            redirect('pesanan');
            return;
        }

        $data['pesanan'] = $this->Model_pesanan->get_pesanan_by_id($id);
        if (empty($data['pesanan'])) {
            show_404();
            return;
        }

        $data['detail_barangs'] = $this->Model_dbarang->get_detailbarang_by_id($id);
        $data['detail_bahans'] = $this->Model_dbahan->get_detailbahan_by_id($id);
        $data['user'] = $this->session->userdata('user_data');
        $data['title'] = 'Edit Data Pesanan';
        $data['jasakirims'] = $this->Jasakirim_model->get_all_jasakirim();
        $data['situss'] = $this->Situs_model->get_all_situs();
        $data['jbayars'] = $this->Jpembayaran_model->get_all_jbayar();
        $data['statuss'] = $this->Status_model->get_all_status();
        $data['barangs'] = $this->Barang_model->get_all_barang();
        $data['bahans'] = $this->Bahan_model->get_all_bahan();
        $data['main_view'] = 'admin/pesanan/edit_pesanan';
        $this->load->view('layout', $data);
    }

    public function update($id) {
        if (empty($id)) {
            show_404();
            return;
        }
    
        $this->form_validation->set_rules('id_pesanan', 'ID pesanan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('resi', 'Resi', 'required');
        $this->form_validation->set_rules('id_jasakirim', 'Jasa Pengiriman', 'required');
        $this->form_validation->set_rules('id_situs', 'Situs Belanja Online', 'required');
        $this->form_validation->set_rules('id_jbayar', 'Jenis Pembayaran', 'required');
        $this->form_validation->set_rules('id_status', 'Status', 'required');
        $this->form_validation->set_rules('totalharga', 'Total Harga', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'id_pesanan' => $this->input->post('id_pesanan'),
                'tanggal' => $this->input->post('tanggal'),
                'resi' => $this->input->post('resi'),
                'id_jasakirim' => $this->input->post('id_jasakirim'),
                'id_situs' => $this->input->post('id_situs'),
                'id_jbayar' => $this->input->post('id_jbayar'),
                'id_status' => $this->input->post('id_status'),
                'totalharga' => $this->input->post('totalharga'),
            ];
    
            $this->Model_pesanan->update_pesanan($id, $data);
    
            // Update detail_barang and detail_bahan
            $this->Model_dbarang->delete_by_pesanan($id);
            $this->_update_detailbarang($id);
    
            $this->Model_dbahan->delete_by_pesanan($id);
            $this->_update_detailbahan($id);
    
            $this->session->set_flashdata('success', 'Pesanan berhasil diubah.');
            redirect('pesanan');
        }
    }
    
    private function _update_detailbarang($id_pesanan) {
        $id_barang = $this->input->post('id_barang');
        $qty_barang = $this->input->post('qty_barang');
        $file_desain = $_FILES['file_desain'];
        $tot_hrgbarang = $this->input->post('tot_hrgbarang');
    
        if (!empty($id_barang) && is_array($id_barang)) {
            for ($i = 0; $i < count($id_barang); $i++) {
                $data_detailbarang = [
                    'kd_detailbarang' => $this->generate_unique_code('detailbarang'),
                    'id_pesanan' => $id_pesanan,
                    'id_barang' => $id_barang[$i],
                    'qty_barang' => $qty_barang[$i],
                    'tot_hrgbarang' => $tot_hrgbarang[$i],
                ];
    
                if (!empty($file_desain['name'][$i])) {
                    $upload_path = './uploads/';
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'jpg|jpeg|png|zip';
                    $config['file_name'] = $file_desain['name'][$i];
    
                    $_FILES['single_file']['name'] = $file_desain['name'][$i];
                    $_FILES['single_file']['type'] = $file_desain['type'][$i];
                    $_FILES['single_file']['tmp_name'] = $file_desain['tmp_name'][$i];
                    $_FILES['single_file']['error'] = $file_desain['error'][$i];
                    $_FILES['single_file']['size'] = $file_desain['size'][$i];
    
                    $this->upload->initialize($config);
    
                    if ($this->upload->do_upload('single_file')) {
                        // Delete old file if it exists
                        $old_file_path = $this->Model_dbarang->get_file_desain_by_id($id_barang[$i]);
                        if (!empty($old_file_path) && file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
    
                        $upload_data = $this->upload->data();
                        $data_detailbarang['file_desain'] = $upload_path . $upload_data['file_name'];
                    } else {
                        $data_detailbarang['file_desain'] = $this->Model_dbarang->get_file_desain_by_id($id_barang[$i]);
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                    }
                } else {
                    $data_detailbarang['file_desain'] = $this->Model_dbarang->get_file_desain_by_id($id_barang[$i]);
                }
    
                $this->Model_dbarang->insert_detailbarang($data_detailbarang);
            }
        }
    }    
    
    private function _update_detailbahan($id_pesanan) {
        $id_bahan = $this->input->post('id_bahan');
        $qty_bahan = $this->input->post('qty_bahan');
        $tot_hrgbahan = $this->input->post('tot_hrgbahan');
    
        if (!empty($id_bahan) && is_array($id_bahan)) {
            for ($i = 0; $i < count($id_bahan); $i++) {
                $data_detailbahan = [
                    'kd_detailbahan' => $this->generate_unique_code('detailbahan'),
                    'id_pesanan' => $id_pesanan,
                    'id_bahan' => $id_bahan[$i],
                    'qty_bahan' => $qty_bahan[$i],
                    'tot_hrgbahan' => $tot_hrgbahan[$i],
                ];
                $this->Model_dbahan->insert_detailbahan($data_detailbahan);
            }
        }
    }
    

    public function cancel() {
        redirect('pesanan');
    }

    public function print() {
        $this->form_validation->set_rules('tanggal_awal', 'Tanggal Awal', 'required');
        $this->form_validation->set_rules('tanggal_akhir', 'Tanggal Akhir', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
    
            $data['pesanans'] = $this->Model_pesanan->get_pesanan_by_date_range_with_details($tanggal_awal, $tanggal_akhir);
            $data['title'] = 'Laporan Pesanan';
    
            $this->load->view('laporan_pesanan', $data);
        }
    }
    

    public function delete($id) {
        if (empty($id)) {
            show_404();
            return;
        }
        
        // Delete related detail_barang and detail_bahan records
        $this->Model_dbarang->delete_by_pesanan($id);
        $this->Model_dbahan->delete_by_pesanan($id);
        
        // Delete the pesanan
        $this->Model_pesanan->delete_pesanan($id);
        $this->session->set_flashdata('success', 'Pesanan dan detail terkait berhasil dihapus.');
        
        redirect('pesanan');
    }
    
    // Add these methods to handle AJAX requests
    public function fetch_bahans() {
        if ($this->input->is_ajax_request()) {
            $bahans = $this->Bahan_model->get_all_bahan();
            echo json_encode($bahans);
        } else {
            show_404();
        }
    }

    public function fetch_barangs() {
        if ($this->input->is_ajax_request()) {
            $barangs = $this->Barang_model->get_all_barang();
            echo json_encode($barangs);
        } else {
            show_404();
        }
    }
    
    public function process_status($id) {
        $data['pesanan'] = $this->Model_pesanan->get_pesanan_by_id($id);
        if (empty($data['pesanan'])) {
            show_404();
            return;
        }

        $data['title'] = 'Keterangan';
        $data['main_view'] = 'admin/pesanan/update_status';
        $this->load->view('layout', $data);
    }
    
    public function update_status() {
        $id = $this->input->post('id_pesanan');
        $keterangan = $this->input->post('keterangan');
        $pesanan = $this->Model_pesanan->get_pesanan_by_id($id);
        $new_status = $pesanan->id_status < 6 ? $pesanan->id_status + 1 : $pesanan->id_status;
    
        $data = [
            'keterangan' => $keterangan,
            'id_status' => $new_status
        ];
    
        // Handle file upload
        if (!empty($_FILES['file_keterangan']['name'])) {
            $upload_path = './uploads/';
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|zip'; // adjust as needed
            $config['file_name'] = time() . '_' . $_FILES['file_keterangan']['name'];
    
            $_FILES['single_file']['name'] = $_FILES['file_keterangan']['name'];
            $_FILES['single_file']['type'] = $_FILES['file_keterangan']['type'];
            $_FILES['single_file']['tmp_name'] = $_FILES['file_keterangan']['tmp_name'];
            $_FILES['single_file']['error'] = $_FILES['file_keterangan']['error'];
            $_FILES['single_file']['size'] = $_FILES['file_keterangan']['size'];
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('single_file')) {
                // Delete old file if it exists
                if (!empty($pesanan->file) && file_exists($pesanan->file)) {
                    unlink($pesanan->file);
                }
    
                $upload_data = $this->upload->data();
                $data['file'] = $upload_path . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
    
        $this->Model_pesanan->update_pesanan($id, $data);
        $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui.');
        redirect('pesanan');
    }
    
    
    public function undo_status($id) {
        $pesanan = $this->Model_pesanan->get_pesanan_by_id($id);
        $new_status = $pesanan->id_status > 1 ? $pesanan->id_status - 1 : $pesanan->id_status;

        $data = [
            'id_status' => $new_status
        ];

        $this->Model_pesanan->update_pesanan($id, $data);
        $this->session->set_flashdata('success', 'Status pesanan berhasil dikembalikan.');
        redirect('pesanan');
    }
}
?>
