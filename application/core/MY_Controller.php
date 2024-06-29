<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $accessible_roles = [];
    protected $user = null; // Add user property

    public function __construct() {
        parent::__construct();
        $this->load_user_data(); // Load user data
        $this->check_access();
    }

    // Load user data from session
    protected function load_user_data() {
        $this->user = $this->session->userdata('user_data');
    }

    protected function check_access() {
        // Debugging: Output user role
        log_message('debug', 'User Role: ' . (isset($this->user['id_role']) ? $this->user['id_role'] : 'No role set'));
        log_message('debug', 'Accessible Roles: ' . implode(', ', $this->accessible_roles));
    
        // Check if user role is set
        if (!isset($this->user['id_role'])) {
            log_message('debug', 'No user role set in session.');
            $this->akses_tolak = true;
            return;
        }
    
        // Check if user role is in accessible roles
        if (in_array($this->user['id_role'], $this->accessible_roles)) {
            log_message('debug', 'User has access.');
            return; // Allow access
        } else {
            log_message('debug', 'User does not have access.');
            $this->akses_tolak = true;
        }
    }
}
