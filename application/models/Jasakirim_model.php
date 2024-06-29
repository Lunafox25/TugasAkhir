<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jasakirim_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jasakirim() {
        $query = $this->db->get('tjasakirim');
        return $query->result();
    }

    public function get_jasakirim_by_id($id) {
        $this->db->where('id_jasakirim', $id);
        $query = $this->db->get('tjasakirim');
        return $query->row();
    }

    public function insert_jasakirim($data) {
        $this->db->insert('tjasakirim', $data);
        return $this->db->insert_id();
    }

    public function update_jasakirim($id, $data) {
        $this->db->where('id_jasakirim', $id);
        $this->db->update('tjasakirim', $data);
        return $this->db->affected_rows();
    }

    public function delete_jasakirim($id) {
        $this->db->where('id_jasakirim', $id);
        $this->db->delete('tjasakirim');
        return $this->db->affected_rows();
    }
}