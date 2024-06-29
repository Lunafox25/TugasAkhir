<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pesanan extends CI_Model {

    public function get_all_pesanan() {
        $query = $this->db
            ->select('tpesanan.*, tstatus.status, tjasakirim.nama_jasa, tsitusbelanjaonline.url_situs,
                    tsitusbelanjaonline.nama_situs, tjenispembayaran.jns_pembayaran')
            ->from('tpesanan')
            ->join('tstatus', 'tpesanan.id_status = tstatus.id_status')
            ->join('tjasakirim', 'tpesanan.id_jasakirim = tjasakirim.id_jasakirim')
            ->join('tsitusbelanjaonline', 'tpesanan.id_situs = tsitusbelanjaonline.id_situs')
            ->join('tjenispembayaran', 'tpesanan.id_jbayar = tjenispembayaran.id_jbayar')
            ->order_by('tpesanan.id_pesanan', 'DESC')
            ->get();
        return $query->result();
    }

    public function get_pesanan_by_id($id) {
        $query = $this->db
            ->select('tpesanan.*, tstatus.status, tjasakirim.nama_jasa, tsitusbelanjaonline.url_situs,
                    tsitusbelanjaonline.nama_situs, tjenispembayaran.jns_pembayaran')
            ->from('tpesanan')
            ->join('tstatus', 'tpesanan.id_status = tstatus.id_status')
            ->join('tjasakirim', 'tpesanan.id_jasakirim = tjasakirim.id_jasakirim')
            ->join('tsitusbelanjaonline', 'tpesanan.id_situs = tsitusbelanjaonline.id_situs')
            ->join('tjenispembayaran', 'tpesanan.id_jbayar = tjenispembayaran.id_jbayar')
            ->where('tpesanan.id_pesanan', $id) // Added where clause to filter by id
            ->get();
        return $query->row(); // Changed to row() to fetch a single record
    }

    public function get_pesanan_by_date_range_with_details($tanggal_awal, $tanggal_akhir) {
        $this->db->select('*');
        $this->db->from('tpesanan');
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $query = $this->db->get();
        $pesanans = $query->result();

        foreach ($pesanans as $pesanan) {
            $pesanan->detail_barangs = $this->Model_dbarang->get_detailbarang_by_id($pesanan->id_pesanan);
            $pesanan->detail_bahans = $this->Model_dbahan->get_detailbahan_by_id($pesanan->id_pesanan);
        }

        return $pesanans;
    }

    public function insert_pesanan($data) {
        $this->db->insert('tpesanan', $data);
        return $this->db->insert_id();
    }

    public function update_pesanan($id, $data) {
        $this->db->where('id_pesanan', $id);
        $this->db->update('tpesanan', $data);
        return $this->db->affected_rows();
    }

    public function check_code_exists($table, $code) {
        $this->db->where('kd_' . $table, $code);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function delete_pesanan($id) {
        $this->db->where('id_pesanan', $id);
        $this->db->delete('tpesanan');
        return $this->db->affected_rows();
    }
}
