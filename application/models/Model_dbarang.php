<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_dbarang extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_detailbarang($data) {
        return $this->db->insert('detailbarang', $data);
    }

    public function check_code_exists($table, $code) {
        $this->db->where('kd_detailbarang', $code);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function get_all_detailbarang() {
        $this->db->select('detailbarang.*, tbarang.nama_barang, tbarang.desc_barang, tbarang.ukuran, tbarang.harga');
        $this->db->from('detailbarang');
        $this->db->join('tbarang', 'detailbarang.id_barang = tbarang.id_barang');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_detailbarang_by_id($id_pesanan) {
        $this->db->select('detailbarang.*, tbarang.nama_barang, tbarang.desc_barang, tbarang.harga, tbarang.ukuran');
        $this->db->from('detailbarang');
        $this->db->join('tbarang', 'detailbarang.id_barang = tbarang.id_barang');
        $this->db->where('detailbarang.id_pesanan', $id_pesanan);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_file_desain_by_id($id_barang) {
        $this->db->select('file_desain');
        $this->db->from('detailbarang');
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->file_desain : '';
    }
    
    public function delete_by_pesanan($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->delete('detailbarang');
    }

    public function update_detailbarang($id, $data) {
        $this->db->where('id_pesanan', $id);
        return $this->db->update('detailbarang', $data);
    }

    public function exists_by_pesanan($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        $query = $this->db->get('detailbarang');
        return $query->num_rows() > 0;
    }
    
}
