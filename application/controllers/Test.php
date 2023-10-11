<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->library('form_validation');
		$this->load->model('Dosen_model');
	}

	public function index()
	{
		$this->db->select('*, nilai_mahasiswa.id AS nmid');
		$this->db->where('nim', '6701184012');
		$this->db->join('mahasiswa', 'mahasiswa.id = nilai_mahasiswa.id_mahasiswa');
		$nilai_mahasiswa = $this->db->get('nilai_mahasiswa')->row_array();
		var_dump($nilai_mahasiswa);
				
	}
}