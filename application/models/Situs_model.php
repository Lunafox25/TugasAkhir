<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Situs_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_situs() {
        $query = $this->db->get('tsitusbelanjaonline');
        return $query->result();
    }


    //Jika nanti dibutuhkan untuk membuat halaman data,edit, dan tambah
    public function get_situs_by_id($id) {
        $this->db->where('id_situs', $id);
        $query = $this->db->get('tsitusbelanjaonline');
        return $query->row();
    }

    public function insert_situs($data) {
        $this->db->insert('tsitusbelanjaonline', $data);
        return $this->db->insert_id();
    }

    public function update_situs($id, $data) {
        $this->db->where('id_situs', $id);
        $this->db->update('tsitusbelanjaonline', $data);
        return $this->db->affected_rows();
    }

    public function delete_situs($id) {
        $this->db->where('id_situs', $id);
        $this->db->delete('tsitusbelanjaonline');
        return $this->db->affected_rows();
    }
}