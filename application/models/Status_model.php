<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_status() {
        $query = $this->db->get('tstatus');
        return $query->result();
    }

    public function get_status_by_id($id) {
        $this->db->where('id_status', $id);
        $query = $this->db->get('tstatus');
        return $query->row();
    }

    public function insert_status($data) {
        $this->db->insert('tstatus', $data);
        return $this->db->insert_id();
    }

    public function update_status($id, $data) {
        $this->db->where('id_status', $id);
        $this->db->update('tstatus', $data);
        return $this->db->affected_rows();
    }

    public function delete_status($id) {
        $this->db->where('id_status', $id);
        $this->db->delete('tstatus');
        return $this->db->affected_rows();
    }
}