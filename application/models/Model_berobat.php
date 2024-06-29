<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_berobat extends CI_model{


	public function get_all() {
		$query = $this->db
			->select('berobat.*, pasien.Nama_PasienKlinik, pasien.Tanggal_LahirPasien, pasien.Jenis_KelaminPasien, 
                        dokter.Nama_Dokter, dokter.Poli_ID, poli.Nama_Poli')
			->from('berobat')
			->join('pasien', 'pasien.PasienKlinik_ID = berobat.PasienKlinik_ID')
			->join('dokter', 'dokter.Dokter_ID = berobat.Dokter_ID')
			->join('poli', 'poli.Poli_ID = dokter.Poli_ID')
			->order_by('berobat.No_Transaksi', 'DESC')
			->get();
		return $query->result();
	}


	public function simpan($data)
	{
        $day = $this->input->post('day');
        $selected_month_name = $this->input->post('month');
        $year = $this->input->post('year');
    
        $month = date('m', strtotime($selected_month_name));
    
        $date_string = sprintf("%04d-%02d-%02d", $year, $month, $day);
    
        $data['Tanggal_Berobat'] = $date_string;
    
        $query = $this->db->insert("berobat", $data);
        
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function edit($No_Transaksi)
	{
		
		$query = $this->db->where("No_Transaksi", $No_Transaksi)
				->get("berobat");

		if($query){
			return $query->row();
		}else{
			return false;
		}

	}

	public function update($data, $id)
	{
		
		// Extract day, month, and year from the input
        $day = $this->input->post('day');
        $selected_month_name = $this->input->post('month');
        $year = $this->input->post('year');
        
        // Convert month name to month number
        $month = date('m', strtotime($selected_month_name));
        
        // Format the date string in YYYY-MM-DD format
        $date_string = sprintf("%04d-%02d-%02d", $year, $month, $day);
        
        // Set the formatted date string to the 'Tanggal_Berobat' field
        $data['Tanggal_Berobat'] = $date_string;

        // Perform the update operation
        $query = $this->db->update("berobat", $data, $id);

        return $query ? true : false;

	}

	public function hapus($id)
	{
		
		$query = $this->db->delete("berobat", $id);

		if($query){
			return true;
		}else{
			return false;
		}
	}
}
