<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_karyawan extends CI_Model {

    public function login($username, $password) {
        $this->db->select('*');
        $this->db->from('tkaryawan');
        $this->db->join('tjabatan', 'tkaryawan.id_jabatan = tjabatan.id_jabatan');
        $this->db->where('username', $username);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $user = $query->row_array();

            if (password_verify($password, $user['password'])) {
                return $user; // Return user data if login successful
            } else {
                return FALSE; // Return FALSE on invalid password
            }
        } else {
            return FALSE; // Return FALSE if username not found
        }
    }

    public function get_karyawan() {
        $this->db->select('tkaryawan.*, tjabatan.nama_jabatan');
        $this->db->from('tkaryawan');
        $this->db->join('tjabatan', 'tkaryawan.id_jabatan = tjabatan.id_jabatan');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_karyawan_by_id($id) {
        $this->db->where('id_karyawan', $id);
        $query = $this->db->get('tkaryawan');
        return $query->row();
    }

    public function insert_karyawan($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->db->insert('tkaryawan', $data);
        return $this->db->insert_id();
    }

    public function update_karyawan($id, $data) {
        // Hash the password if it's provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $this->db->where('id_karyawan', $id);
        return $this->db->update('tkaryawan', $data);
    }

    public function delete_karyawan($id) {
        $this->db->where('id_karyawan', $id);
        $this->db->delete('tkaryawan');
        return $this->db->affected_rows();
    }
}