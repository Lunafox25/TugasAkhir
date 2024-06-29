<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jabatan() {
        $query = $this->db->get('tjabatan');
        return $query->result();
    }

    public function get_jabatan_by_id($id) {
        $this->db->where('id_jabatan', $id);
        $query = $this->db->get('tjabatan');
        return $query->row();
    }

    public function insert_jabatan($data) {
        $this->db->insert('tjabatan', $data);
        return $this->db->insert_id();
    }

    public function update_jabatan($id, $data) {
        $this->db->where('id_jabatan', $id);
        $this->db->update('tjabatan', $data);
        return $this->db->affected_rows();
    }

    public function delete_jabatan($id) {
        $this->db->where('id_jabatan', $id);
        $this->db->delete('tjabatan');
        return $this->db->affected_rows();
    }
}