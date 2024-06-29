<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_dbahan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_detailbahan($data) {
        return $this->db->insert('detailbahan', $data);
    }

    public function check_code_exists($table, $code) {
        $this->db->where('kd_detailbahan', $code);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function get_all_detailbahan() {
        $this->db->select('detailbahan.*, tbahan.nama_bahan, tbahan.satuan, tbahan.hrg_bahan');
        $this->db->from('detailbahan');
        $this->db->join('tbahan', 'detailbahan.id_bahan = tbahan.id_bahan');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_detailbahan_by_id($id_pesanan) {
        $this->db->select('detailbahan.*, tbahan.nama_bahan, tbahan.hrg_bahan, tbahan.satuan');
        $this->db->from('detailbahan');
        $this->db->join('tbahan', 'detailbahan.id_bahan = tbahan.id_bahan');
        $this->db->where('detailbahan.id_pesanan', $id_pesanan);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function delete_by_pesanan($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->delete('detailbahan');
    }
    
    public function update_detailbahan($id, $data) {
        $this->db->where('id_pesanan', $id);
        return $this->db->update('detailbahan', $data);
    }

    public function exists_by_pesanan($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        $query = $this->db->get('detailbahan');
        return $query->num_rows() > 0;
    }
    
}
