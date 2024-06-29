<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_barang() {
        $query = $this->db->get('tbarang');
        return $query->result();
    }

    public function get_barang_by_id($id) {
        $this->db->where('id_barang', $id);
        $query = $this->db->get('tbarang');
        return $query->row();
    }

    public function insert_barang($data) {
        $this->db->insert('tbarang', $data);
        return $this->db->insert_id();
    }

    public function update_barang($id, $data) {
        $this->db->where('id_barang', $id);
        $this->db->update('tbarang', $data);
        return $this->db->affected_rows();
    }

    public function delete_barang($id) {
        $this->db->where('id_barang', $id);
        $this->db->delete('tbarang');
        return $this->db->affected_rows();
    }
}