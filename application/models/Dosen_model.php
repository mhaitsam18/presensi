<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen_model extends CI_Model {

	public function getNilaiMahasiswaById($id)
	{
		return $this->db->get_where('nilai_mahasiswa', ['id' => $id])->row_array();
	}
	public function getNilaiMataKuliahById($id)
	{
		return $this->db->get_where('nilai_mata_kuliah', ['id' => $id])->row_array();
	}
	public function getSubNilaiMataKuliahById($id)
	{
		return $this->db->get_where('sub_nilai_mata_kuliah', ['id' => $id])->row_array();
	}

	// Fungsi untuk melakukan proses upload file
	public function upload_file($filename){
		
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '4048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
		
		$this->load->library('upload', $config);
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function insert_excelSubNilaiMataKuliah($data)
	{
		$this->db->insert_batch('sub_nilai_mata_kuliah', $data);
	}
	
}