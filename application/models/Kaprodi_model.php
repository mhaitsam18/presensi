<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi_model extends CI_Model {

	public function getPengampuById($id)
	{
		return $this->db->get_where('pengampu', ['id' => $id])->row_array();
	}
	
}