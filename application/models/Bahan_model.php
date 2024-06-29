<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_bahan() {
        $query = $this->db->get('tbahan');
        return $query->result();
    }

    public function get_bahan_by_id($id) {
        $this->db->where('id_bahan', $id);
        $query = $this->db->get('tbahan');
        return $query->row();
    }

    public function insert_bahan($data) {
        $this->db->insert('tbahan', $data);
        return $this->db->insert_id();
    }

    public function update_bahan($id, $data) {
        $this->db->where('id_bahan', $id);
        $this->db->update('tbahan', $data);
        return $this->db->affected_rows();
    }

    public function delete_bahan($id) {
        $this->db->where('id_bahan', $id);
        $this->db->delete('tbahan');
        return $this->db->affected_rows();
    }
}