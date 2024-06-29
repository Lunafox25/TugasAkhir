<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $user = $this->session->userdata('user_data');
            if ($user['id_role'] == 1) {
                redirect('karyawan');
            } else {
                redirect('menu');
            }
        } else {
            $this->load->view('view_login'); // Load login view for new login
        }
    }

    public function validate() {
        $this->load->model('Model_karyawan'); // Load Model_karyawan

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Model_karyawan->login($username, $password);

        if ($user) {
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_data', $user);

            // **Access Control based on Role :**
            if ($user['id_role'] == 1) {
                redirect('karyawan'); // Redirect Owner to specific dashboard
            } else if ($user['id_role'] == 2) {
                redirect('pesanan'); // Redirect Staff to specific dashboard
            } else {
                redirect('login'); // Default redirect for other roles
            }
        } else {
            $this->session->set_flashdata('login_error', 'Invalid username or password.');
            redirect('login'); // Redirect back to login with error message
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_data');
        $this->session->sess_destroy();
        redirect('login');
    }
}