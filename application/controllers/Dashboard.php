<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        $this->accessible_roles = [1];
        parent::__construct();
        $this->load->model('Model_pesanan');
    }

    public function index() {
        $user = $this->session->userdata('user_data');

        if (!$user) {
            redirect('login');
        } else {
        $data['user'] = $user;
        $data['title'] = 'Dashboard';
        $data['main_view'] = 'dashboard';
        $data['pesanan'] = $this->Model_pesanan->get_all_pesanan();
        // Count the statuses by id_status
        $data['status_counts'] = [
            1 => 0, // Pending
            2 => 0, // Processing
            3 => 0, // Packing
            4 => 0, // Shipped
            5 => 0, // Completed
            6 => 0  // Cancelled
        ];
        
        foreach ($data['pesanan'] as $pesan) {
            if (isset($data['status_counts'][$pesan->id_status])) {
                $data['status_counts'][$pesan->id_status]++;
            }
        }
        
        $data['total_pesanan'] = count($data['pesanan']);
        $this->load->view('layout', $data);}
    }
}
