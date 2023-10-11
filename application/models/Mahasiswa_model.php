<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

	public function getTakById($id)
	{
		return $this->db->get_where('tak', ['id' => $id])->row_array();
	}
}