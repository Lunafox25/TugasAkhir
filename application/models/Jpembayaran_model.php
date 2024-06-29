<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jpembayaran_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jbayar() {
        $query = $this->db->get('tjenispembayaran');
        return $query->result();
    }

    public function get_jbayar_by_id($id) {
        $this->db->where('id_jbayar', $id);
        $query = $this->db->get('tjenispembayaran');
        return $query->row();
    }

    public function insert_jbayar($data) {
        $this->db->insert('tjenispembayaran', $data);
        return $this->db->insert_id();
    }

    public function update_jbayar($id, $data) {
        $this->db->where('id_jbayar', $id);
        $this->db->update('tjenispembayaran', $data);
        return $this->db->affected_rows();
    }

    public function delete_jbayar($id) {
        $this->db->where('id_jbayar', $id);
        $this->db->delete('tjenispembayaran');
        return $this->db->affected_rows();
    }
}