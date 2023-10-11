<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataMaster_model extends CI_Model {

	public function getAgamaById($id)
	{
		return $this->db->get_where('agama', ['id' => $id])->row_array();
	}
	public function getFakultasById($id)
	{
		return $this->db->get_where('fakultas', ['id' => $id])->row_array();
	}
	public function getProdiById($id)
	{
		return $this->db->get_where('prodi', ['id' => $id])->row_array();
	}
	public function getKelasById($id)
	{
		return $this->db->get_where('kelas', ['id' => $id])->row_array();
	}
	public function getMataKuliahById($id)
	{
		return $this->db->get_where('mata_kuliah', ['id' => $id])->row_array();
	}
	public function getPendidikanById($id)
	{
		return $this->db->get_where('pendidikan', ['id' => $id])->row_array();
	}
	public function getStatusMahasiswaById($id)
	{
		return $this->db->get_where('status_mahasiswa', ['id' => $id])->row_array();
	}
	public function getTahunAjaranById($id)
	{
		return $this->db->get_where('tahun_ajaran', ['id' => $id])->row_array();
	}
	public function getKontenById($id)
	{
		return $this->db->get_where('content', ['id' => $id])->row_array();
	}
	public function getPertanyaan1ById($id)
	{
		return $this->db->get_where('pertanyaan_1', ['id' => $id])->row_array();
	}
	public function getPertanyaan2ById($id)
	{
		return $this->db->get_where('pertanyaan_2', ['id' => $id])->row_array();
	}
	
}