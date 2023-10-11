<?php 

function is_logged_in()
{
	$ci = get_instance();
	if (!$ci->session->userdata('email')) {
		redirect('auth');
	} else{
		$role_id = $ci->session->userdata('role_id');
		$menu = $ci->uri->segment(1);
		if ($menu == 'Dosen' || $menu == 'dosen') {
			$menu = 'Dosen Pengampu';
		}
		$queryMenu = $ci->db->get_where('user_menu', ['menu'=> $menu])->row_array();
		$menu_id = $queryMenu['id'];
		$userAccess = $ci->db->get_where('user_access_menu', ['role_id'=> $role_id, 'menu_id' => $menu_id]);
		if ($userAccess->num_rows()<1) {
			redirect('auth/blocked');
		}
	}
}

function check_access($role_id, $menu_id)
{
	$ci = get_instance();

	$ci->db->where('role_id', $role_id);
	$ci->db->where('menu_id', $menu_id);
	$result = $ci->db->get('user_access_menu');

	if ($result->num_rows() > 0) {
		return "checked='checked'";
	}

}

function cek_angkatan($angkatan, $arr_angkatan)
{
	$ci = get_instance();

	foreach ($arr_angkatan as $row => $value) {
		if ($value == $angkatan) {
			return "checked='checked'";
			break;
		}
	}

}

function nilaiMutuIndeks($indeks, $sks)
{
	$nilai_mutu = 0;
	switch ($indeks) {
		case 'A':
			$nilai_mutu = 4*$sks;
			break;
		
		case 'AB':
			$nilai_mutu = 3.5*$sks;
			break;
		
		case 'B':
			$nilai_mutu = 3*$sks;
			break;
		
		case 'BC':
			$nilai_mutu = 2.5*$sks;
			break;
		
		case 'C':
			$nilai_mutu = 2*$sks;
			break;
		
		case 'CD':
			$nilai_mutu = 1.5*$sks;
			break;
		
		case 'D':
			$nilai_mutu = 1*$sks;
			break;
		
		case 'DE':
			$nilai_mutu = 0.5*$sks;
			break;
		
		case 'E':
			$nilai_mutu = 0*$sks;
			break;

		case 'T':
			$nilai_mutu = 0*$sks;
			break;

			
	}
	return $nilai_mutu;
}

function hasilIndeks($hasil)
{
	if ($hasil > 80) {
		$indeks = 'A';
	} elseif ($hasil > 75) {
		$indeks = 'AB';
	} elseif ($hasil > 70) {
		$indeks = 'B';
	} elseif ($hasil > 60) {
		$indeks = 'BC';
	} elseif ($hasil > 40) {
		$indeks = 'C';
	} elseif ($hasil > 30) {
		$indeks = 'CD';
	} elseif ($hasil > 20) {
		$indeks = 'D';
	} elseif ($hasil > 10) {
		$indeks = 'DE';
	} elseif ($hasil < 10) {
		$indeks = 'E';
	} else {
		$indeks = 'T';
	}
	return $indeks;
}
function convertRomawi($int)
{
	if ($int == 1) {
		return 'I';
	} elseif ($int == 2) {
		return 'II';
	} elseif ($int == 3) {
		return 'III';
	} elseif ($int == 4) {
		return 'IV';
	} elseif ($int == 5) {
		return 'V';
	} elseif ($int == 6) {
		return 'VI';
	} else{
		return '-';
	}
}