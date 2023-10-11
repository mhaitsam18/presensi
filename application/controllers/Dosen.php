<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Dosen_model');
	}

	public function index($id_kelas = null)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array(); 
		$data['title'] = "Dashboard Dosen Wali";

		

		$this->db->select("COUNT(DISTINCT(id_nilai_mahasiswa)) AS jml_mhs, AVG(poin) AS avg_tak, semester AS semester_kelas");
		$this->db->group_by('semester');
		$data['hitung_tak'] = $this->db->get('tak')->result_array();
		
		$data['konten1'] = $this->db->get_where('content', ['id' => 1])->row_array();
		$data['konten2'] = $this->db->get_where('content', ['id' => 2])->row_array();

		$this->db->select("COUNT(mahasiswa.id) AS jml_mhs");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['value_mahasiswa'] = $this->db->get()->row_array();

		$this->db->select("AVG(ipk) AS avg_ipk, AVG(tak) AS avg_tak");
		$this->db->from('nilai_mahasiswa');
		$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['value_mahasiswa2'] = $this->db->get()->row_array();

		$this->db->select("AVG(presensi) AS avg_presensi");
		$this->db->from('nilai_mata_kuliah');
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['value_mahasiswa3'] = $this->db->get()->row_array();

		$this->db->select("COUNT(nilai_mahasiswa.id) AS jml_mhs, AVG(ipk) AS avg_ipk, AVG(tak) AS avg_tak, AVG(presensi) AS avg_presensi");
		$this->db->from('nilai_mahasiswa');
		$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('nilai_mata_kuliah.semester');
		$data['value_mahasiswa_semester'] = $this->db->get()->result_array();


		// $this->db->select("COUNT(DISTINCT(nilai_mahasiswa.id)) AS jml_mhs, AVG(tak) AS avg_tak, semester_kelas");
		// $this->db->from('nilai_mahasiswa');
		// $this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		// $this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		// $this->db->where('semester_kelas <=', 6);
		// if ($data['user']['role_id']!=1) {
		// 	$this->db->where('id_dosen_wali', $dosen['id']);
		// }
		// if ($id_kelas) {
		// 	$this->db->where('id_kelas', $id_kelas);
		// }
		// $this->db->group_by('kelas.semester_kelas');
		// $data['hitung_tak'] = $this->db->get()->result_array();


		$this->db->select("AVG(ip_semester.ipk) AS avg_ipk, AVG(ip) AS avg_ip");
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->where('ip !=', 0);
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('ip_semester.semester');
		$data['ip_ipk_mahasiswa_semester'] = $this->db->get('ip_semester')->result_array();
		

		$this->db->distinct();
		$this->db->select("ip_semester.semester AS smt");
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->where('ip !=', 0);
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('ip_semester.semester');
		$data['distinct_semester_ip_ipk'] = $this->db->get('ip_semester')->result_array();
		

		$this->db->select("pekerjaan_wali, COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('pekerjaan_wali');
		$data['pekerjaan_wali'] = $this->db->get()->result_array();

		$this->db->select("asal_daerah, COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('asal_daerah');
		$data['asal_daerah'] = $this->db->get()->result_array();

		$this->db->select("pendidikan.id AS pid, pendidikan, COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		$this->db->join('pendidikan', 'pendidikan.id=mahasiswa.pendidikan_wali', 'right');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('pendidikan_wali');
		$this->db->order_by('pendidikan.id', 'ASC');
		$data['pendidikan_wali'] = $this->db->get()->result_array();

		$this->db->select("status_mahasiswa.id AS sid, status, COUNT(id_status) AS count_status");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		$this->db->join('status_mahasiswa', 'status_mahasiswa.id=mahasiswa.id_status');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$this->db->group_by('id_status');
		$this->db->order_by('status_mahasiswa.id', 'ASC');
		$data['status'] = $this->db->get()->result_array();

		$this->db->select("COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['count_pendidikan'] = $this->db->get()->row_array();

		$this->db->select("COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['count_pekerjaan'] = $this->db->get()->row_array();

		$this->db->select("COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['count_asal'] = $this->db->get()->row_array();

		$this->db->select("COUNT(id_status) AS count_status");
		$this->db->from('mahasiswa');
		$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		if ($data['user']['role_id']!=1) {
			$this->db->where('id_dosen_wali', $dosen['id']);
		}
		if ($id_kelas) {
			$this->db->where('id_kelas', $id_kelas);
		}
		$data['count_status'] = $this->db->get()->row_array();
		if ($id_kelas) {
			$data['cur_kelas'] = $this->db->get_where('kelas', ['id' => $id_kelas])->row_array();
		}

		if ($data['user']['role_id'] == 4 || $data['user']['role_id'] == 5) {
			$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$data['kelas'] = $this->db->get_where('kelas', ['id_dosen_wali' => $dosen['id']])->result_array();
		} else {
			$data['kelas'] = $this->db->get('kelas')->result_array();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/index', $data);
		$this->load->view('templates/footer');
	}

	public function performa()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";

		if ($data['user']['role_id']==1) {
			$this->db->select('*, mahasiswa.id AS mid, kelas.id AS kid, COUNT(mahasiswa.id) AS count_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id_kelas = kelas.id', 'left');
			$this->db->group_by('kelas.id');
			$data['kelas'] = $this->db->get('kelas')->result_array();
		} elseif ($data['user']['role_id']==4 || $data['user']['role_id']==5) {
			$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$this->db->select('*, mahasiswa.id AS mid, kelas.id AS kid, COUNT(mahasiswa.id) AS count_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id_kelas = kelas.id', 'left');
			$this->db->group_by('kelas.id');
			$data['kelas'] = $this->db->get_where('kelas', ['id_dosen_wali' => $dosen['id']])->result_array();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/performa', $data);
		$this->load->view('templates/footer');
	}
	public function listMahasiswa($id_kelas = null, $sort_by = null, $sort = null)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";

		$this->db->select("pekerjaan_wali, COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$this->db->group_by('pekerjaan_wali');
		$data['pekerjaan_wali'] = $this->db->get()->result_array();
		
		$this->db->select("asal_daerah, COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$this->db->group_by('asal_daerah');
		$data['asal_daerah'] = $this->db->get()->result_array();
		
		$this->db->select("pendidikan.id AS pid, pendidikan, COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$this->db->join('pendidikan', 'pendidikan.id=mahasiswa.pendidikan_wali', 'right');
		$this->db->group_by('pendidikan_wali');
		$this->db->order_by('pendidikan.id', 'ASC');
		$data['pendidikan_wali'] = $this->db->get()->result_array();
		
		$this->db->select("COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$data['count_pendidikan'] = $this->db->get()->row_array();
		
		$this->db->select("COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$data['count_pekerjaan'] = $this->db->get()->row_array();
		
		$this->db->select("COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$this->db->where('id_kelas', $id_kelas);
		$data['count_asal'] = $this->db->get()->row_array();
		
		$this->db->select('*, user.id AS uid, mahasiswa.id AS mid');
		$this->db->from('user');
		$this->db->where('id_kelas', $id_kelas);
		$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		$data['mahasiswa'] = $this->db->get()->result_array();
		$data['kelas'] = $this->db->get_where('kelas', ['id' => $id_kelas])->row_array();

		$semester_kemarin = $data['kelas']['semester_kelas'] - 1;
		// $this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
		// $this->db->from('user');
		// $this->db->where('id_kelas', $id_kelas);
		// $this->db->where('ip_semester.semester', $semester_kemarin);
		// $this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		// $this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		// $this->db->order_by('ip', 'DESC');
		// $this->db->limit(5);
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.id_kelas', $id_kelas);
		$this->db->where('i1.semester', $data['kelas']['semester_kelas']);
		$this->db->join('mahasiswa m1', 'u1.id=m1.id_user');
		$this->db->join('nilai_mahasiswa n1', 'm1.id=n1.id_mahasiswa');
		$this->db->join('ip_semester i1', 'n1.id=i1.id_nilai_mahasiswa');
		if (!$sort_by) {
			$this->db->order_by('i1.ip', 'DESC');
		} elseif(!$sort){
			$this->db->order_by($sort_by, 'DESC');
		} else{
			$this->db->order_by($sort_by, $sort);
		}
		$this->db->limit(5);
		$data['mahasiswa_ip_tertinggi'] = $this->db->get()->result_array();
		
		// $this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
		// $this->db->from('user');
		// $this->db->where('id_kelas', $id_kelas);
		// $this->db->where('ip_semester.semester', $semester_kemarin);
		// $this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		// $this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		// $this->db->order_by('ip', 'ASC');
		// $this->db->limit(5);
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.id_kelas', $id_kelas);
		$this->db->where('i1.semester', $data['kelas']['semester_kelas']);
		$this->db->join('mahasiswa m1', 'u1.id=m1.id_user');
		$this->db->join('nilai_mahasiswa n1', 'm1.id=n1.id_mahasiswa');
		$this->db->join('ip_semester i1', 'n1.id=i1.id_nilai_mahasiswa');
		if (!$sort_by) {
			$this->db->order_by('ip', 'ASC');
		} elseif(!$sort){
			$this->db->order_by($sort_by, 'ASC');
		} else{
			$this->db->order_by($sort_by, $sort);
		}
		$this->db->limit(5);

		$data['mahasiswa_ip_terendah'] = $this->db->get()->result_array();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/list-mahasiswa', $data);
		$this->load->view('templates/footer');
	}

	public function topSemester($id_kelas = null, $semester = null, $sort_by = null, $sort = null)
	{

		$data['kelas'] = $this->db->get_where('kelas', ['id' => $id_kelas])->row_array();
		$data['cur_semester'] = $semester;
		$semester_kemarin = $semester - 1;
		// $this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
		// $this->db->from('user');
		// $this->db->where('id_kelas', $id_kelas);
		// $this->db->where('ip_semester.semester', $semester);
		// $this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		// $this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		// $this->db->order_by('ip', 'DESC');
		// $this->db->limit(5);
		// $data['mahasiswa_ip_tertinggi'] = $this->db->get()->result_array();
		
		// $this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
		// $this->db->from('user');
		// $this->db->where('id_kelas', $id_kelas);
		// $this->db->where('ip_semester.semester', $semester);
		// $this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		// $this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
		// $this->db->order_by('ip', 'ASC');
		// $this->db->limit(5);
		// $data['mahasiswa_ip_terendah'] = $this->db->get()->result_array();
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.id_kelas', $id_kelas);
		$this->db->where('i1.semester', $semester);
		$this->db->join('mahasiswa m1', 'u1.id=m1.id_user');
		$this->db->join('nilai_mahasiswa n1', 'm1.id=n1.id_mahasiswa');
		$this->db->join('ip_semester i1', 'n1.id=i1.id_nilai_mahasiswa');
		if (!$sort_by) {
			$this->db->order_by('ip', 'DESC');
		} elseif(!$sort){
			$this->db->order_by($sort_by, 'DESC');
		} else{
			$this->db->order_by($sort_by, $sort);
		}
		$this->db->limit(5);
		$data['mahasiswa_ip_tertinggi'] = $this->db->get()->result_array();
		
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_kemarin)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.id_kelas', $id_kelas);
		$this->db->where('i1.semester', $semester);
		$this->db->join('mahasiswa m1', 'u1.id=m1.id_user');
		$this->db->join('nilai_mahasiswa n1', 'm1.id=n1.id_mahasiswa');
		$this->db->join('ip_semester i1', 'n1.id=i1.id_nilai_mahasiswa');
		if (!$sort_by) {
			$this->db->order_by('ip', 'ASC');
		} elseif(!$sort){
			$this->db->order_by($sort_by, 'ASC');
		} else{
			$this->db->order_by($sort_by, $sort);
		}
		$this->db->limit(5);
		$data['mahasiswa_ip_terendah'] = $this->db->get()->result_array();
		$this->load->view('kaprodi/top-semester', $data);
	}
	
	public function performaMahasiswa($id_mahasiswa)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";
		$this->db->select('*, mahasiswa.id AS mid');
		$this->db->from('user');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$data['mahasiswa'] = $this->db->get()->row_array();

		$data['nilai_mahasiswa'] = $this->db->get_where('nilai_mahasiswa', ['id_mahasiswa' => $id_mahasiswa])->row_array();

		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$data['presensi'] = $this->db->get()->row_array();

		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$this->db->group_by('nilai_mata_kuliah.semester');
		$data['presensi_semester'] = $this->db->get()->result_array();

		$this->db->select('SUM(sks) AS sum_sks');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['sum_sks'] = $this->db->get()->row_array();


		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, mahasiswa.id AS mid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['nilai_mata_kuliah'] = $this->db->get()->result_array();

		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ip[$i] = 0;
			} else{
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ip[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$this->db->select('MAX(nilai_mata_kuliah.semester) AS max_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_mahasiswa', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$max_semester = $this->db->get()->row_array();
		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester <=', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ipk[$i] = 0;
			} elseif ($i+1 > $max_semester['max_semester']) {
				$ipk[$i] = 0;
			} else {
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ipk[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$data['ip'] = $ip;
		$data['ipk'] = $ipk;

		$data['catatan'] = $this->db->get_where('catatan', ['id_mahasiswa' => $id_mahasiswa])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/performa-mahasiswa', $data);
		$this->load->view('templates/footer');
	}

	public function insertCatatan()
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$dosen = $this->db->get_where('dosen', ['id_user' => $user['id']])->row_array();
		$this->form_validation->set_rules('subjek', 'Subjek', 'required|trim');
		$this->form_validation->set_rules('catatan', 'Catatan', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->performaMahasiswa($this->input->post('id_mahasiswa'));
		} else{
			$this->db->insert('catatan', [
				'id_mahasiswa' => $this->input->post('id_mahasiswa'),
				'id_dosen' => $dosen['id'],
				'subjek' => $this->input->post('subjek'),
				'catatan' => $this->input->post('catatan'),
				'waktu_post' => date('Y-m-d H:i:s'),
				'is_read' => 1
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Catatan Telah ditambahkan!
				</div>');
			redirect('Dosen/performaMahasiswa/'.$this->input->post('id_mahasiswa'));
			// redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function deleteCatatan($id)
	{
		$this->db->delete('catatan', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Catatan Telah dihapus!
			</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function detailNilaiMataKuliah($id_nilai_mata_kuliah)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";
		
		$this->db->select('*, sub_nilai_mata_kuliah.id AS snmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('sub_nilai_mata_kuliah');
		$this->db->where('id_nilai_mata_kuliah', $id_nilai_mata_kuliah);
		$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['sub_nilai_mata_kuliah'] = $this->db->get()->result_array();

		$data['id_nilai_mata_kuliah'] = $id_nilai_mata_kuliah;

		$this->db->select('*, mahasiswa.id AS mid');
		$this->db->from('mahasiswa');
		$this->db->where('mahasiswa.id', $this->input->get('id_mahasiswa'));
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$data['mahasiswa'] = $this->db->get()->row_array();
		$data['nama_mata_kuliah'] = $this->input->get('nama_mata_kuliah');
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/detail-nilai-mata-kuliah', $data);
		$this->load->view('templates/footer');
	}
	
	public function nilaiMahasiswa()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Data Nilai Mahasiswa";
		if(isset($_POST['upload'])){ // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->Dosen_model->upload_file('import_nilai_mahasiswa');
			
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/import_nilai_mahasiswa.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
				
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				'.$upload['error'].'
				</div>');
				redirect("Dosen/nilaiMahasiswa/");
			}
		}
		if ($data['user']['role_id']==1 || $data['user']['role_id']==5) {
			$this->db->select('*, SUM(sks) AS sum_sks, nilai_mahasiswa.id AS nmid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->group_by('nmid');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();

			$this->db->select('*, mahasiswa.id AS mid');
			$this->db->from('mahasiswa');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['mahasiswa'] = $this->db->get()->result_array();
		} elseif ($data['user']['role_id']==4) {
			$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$this->db->select('*, SUM(sks) AS sum_sks, nilai_mahasiswa.id AS nmid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mahasiswa');
			$this->db->where('id_dosen_wali', $dosen['id']);
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->group_by('nmid');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();

			$this->db->select('*, mahasiswa.id AS mid');
			$this->db->from('mahasiswa');
			$this->db->where('id_dosen_wali', $dosen['id']);
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['mahasiswa'] = $this->db->get()->result_array();
		}
		$this->form_validation->set_rules('id_mahasiswa', 'Student Name', 'required');
		$this->form_validation->set_rules('ipk', 'GPA', 'required');
		$this->form_validation->set_rules('tak', 'TAK', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dosen/data-nilai-mahasiswa', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('nilai_mahasiswa', [
				'id_mahasiswa' => $this->input->post('id_mahasiswa'),
				'ipk' => $this->input->post('ipk'),
				'tak' => $this->input->post('tak')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Student Score Added!
				</div>');
			redirect('Dosen/nilaiMahasiswa');
		}
	}

	public function nilaiMataKuliah()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Data Nilai Mata Kuliah";
		$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
		if(isset($_POST['upload'])){ // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->Dosen_model->upload_file('import_nilai_matkul');
			
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/import_nilai_matkul.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
				
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				'.$upload['error'].'
				</div>');
				redirect("Dosen/nilaiMataKuliah/");
			}
		}
			
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->where('nilai_mahasiswa.id', $this->uri->segment(3));
		$this->db->group_by('user.id');
		$data['mhs'] = $this->db->get('nilai_mahasiswa')->row_array();

		if ($data['user']['role_id']==1 || $data['user']['role_id']==5) {
			$this->db->select('*, nilai_mahasiswa.id AS nmid');
			$this->db->from('nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->group_by('nmid');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();
			
			if (!$this->uri->segment(3)) {
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$data['nilai_mata_kuliah'] = $this->db->get()->result_array();
			} else{
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('id_nilai_mahasiswa', $this->uri->segment(3));
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$data['nilai_mata_kuliah'] = $this->db->get()->result_array();
			}
			
		} elseif ($data['user']['role_id']==4) {
			$this->db->select('*, nilai_mahasiswa.id AS nmid');
			$this->db->from('nilai_mahasiswa');
			$this->db->where('id_dosen_wali', $dosen['id']);
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->group_by('nmid');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();
			if (!$this->uri->segment(3)) {
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('id_dosen_wali', $dosen['id']);
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$data['nilai_mata_kuliah'] = $this->db->get()->result_array();
			} else{
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('id_dosen_wali', $dosen['id']);
				$this->db->where('id_nilai_mahasiswa', $this->uri->segment(3));
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$data['nilai_mata_kuliah'] = $this->db->get()->result_array();
			}
		}
		$this->db->select('*, pengampu.id AS pid');
		$this->db->from('pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$data['pengampu'] = $this->db->get()->result_array();
		$this->form_validation->set_rules('id_nilai_mahasiswa', 'Student', 'required');
		$this->form_validation->set_rules('indeks', 'Index', 'required');
		$this->form_validation->set_rules('presensi1', 'Total Course', 'required');
		$this->form_validation->set_rules('presensi2', 'Total Presence', 'required');
		$this->form_validation->set_rules('tahun_ajaran', 'Academic Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');
		$this->form_validation->set_rules('id_pengampu', 'Lecturer Course', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dosen/data-nilai-mata-kuliah', $data);
			$this->load->view('templates/footer');
		} else{
			$presensi1 = $this->input->post('presensi1');
			$presensi2 = $this->input->post('presensi2');
			$presensi = $presensi2/$presensi1;
			$this->db->insert('nilai_mata_kuliah', [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'indeks' => $this->input->post('indeks'),
				'presensi' => $presensi,
				'tahun_ajaran' => $this->input->post('tahun_ajaran'),
				'semester' => $this->input->post('semester'),
				'id_pengampu' => $this->input->post('id_pengampu')
			]);
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id', $this->input->post('id_nilai_mahasiswa'));
			$this->db->update('nilai_mahasiswa', $data);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $this->input->post('semester'));
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ip_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ip = $total_nilai_mutu/$total_sks;
			$data = [
				'ip' => $ip
			];
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->where('semester', $this->input->post('semester'));
			$this->db->update('ip_semester', $data);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $this->input->post('semester'));
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ipk_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->where('semester', $this->input->post('semester'));
			$this->db->update('ip_semester', $data);
			
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Course Score Added!
				</div>');
			redirect('Dosen/nilaiMataKuliah');
		}
	}

	public function pengampu()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Pengampu Mata Kuliah";
		if ($data['user']['role_id']==1 || $data['user']['role_id']==5) {
			$this->db->select('*, pengampu.id AS pid');
			$this->db->from('pengampu');
			$this->db->join('dosen', 'pengampu.id_dosen=dosen.id');
			$this->db->join('user', 'dosen.id_user=user.id');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$data['pengampu'] = $this->db->get()->result_array();
		}elseif ($data['user']['role_id']==4) {
			$this->db->select('*, pengampu.id AS pid');
			$this->db->from('pengampu');
			$this->db->where('id_user', $data['user']['id']);
			$this->db->join('dosen', 'pengampu.id_dosen=dosen.id');
			$this->db->join('user', 'dosen.id_user=user.id');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$data['pengampu'] = $this->db->get()->result_array();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dosen/pengampu-mata-kuliah', $data);
		$this->load->view('templates/footer');
	}

	public function nilaiDosenPengampu($id_pengampu)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->db->select('*, pengampu.id AS pid');
		$this->db->from('pengampu');
		$this->db->where('pengampu.id', $id_pengampu);
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$row_pengampu = $this->db->get()->row_array();
		$data['title'] = "Data Nilai Mata Kuliah ".$row_pengampu['nama_mata_kuliah'].", Kode Dosen : ".$row_pengampu['kode_dosen'];
		$this->db->select('*, nilai_mahasiswa.id AS nmid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mahasiswa');
		$this->db->where('id_pengampu', $id_pengampu);
		$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->group_by('nmid');
		$data['nilai_mahasiswa'] = $this->db->get()->result_array();
		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_pengampu', $id_pengampu);
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$data['nilai_mata_kuliah'] = $this->db->get()->result_array();
		$this->db->select('*, pengampu.id AS pid');
		$this->db->from('pengampu');
		$this->db->where('pengampu.id', $id_pengampu);
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$data['pengampu'] = $this->db->get()->result_array();
		$this->form_validation->set_rules('id_nilai_mahasiswa', 'Student', 'required');
		$this->form_validation->set_rules('indeks', 'Index', 'required');
		$this->form_validation->set_rules('presensi1', 'Total Course', 'required');
		$this->form_validation->set_rules('presensi2', 'Total Presence', 'required');
		$this->form_validation->set_rules('tahun_ajaran', 'Academic Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');
		$this->form_validation->set_rules('id_pengampu', 'Lecturer Course', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dosen/data-nilai-mata-kuliah', $data);
			$this->load->view('templates/footer');
		} else{
			$presensi1 = $this->input->post('presensi1');
			$presensi2 = $this->input->post('presensi2');
			$presensi = $presensi2/$presensi1;
			$this->db->insert('nilai_mata_kuliah', [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'indeks' => $this->input->post('indeks'),
				'presensi' => $presensi,
				'tahun_ajaran' => $this->input->post('tahun_ajaran'),
				'semester' => $this->input->post('semester'),
				'id_pengampu' => $this->input->post('id_pengampu')
			]);
			$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id', $this->input->post('id_nilai_mahasiswa'));
			$this->db->update('nilai_mahasiswa', $data);

			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $this->input->post('semester'));
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ip_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ip = $total_nilai_mutu/$total_sks;
			$data = [
				'ip' => $ip
			];
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->where('semester', $this->input->post('semester'));
			$this->db->update('ip_semester', $data);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $this->input->post('semester'));
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ipk_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->where('semester', $this->input->post('semester'));
			$this->db->update('ip_semester', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Course Score Added!
				</div>');
			redirect("Dosen/nilaiDosenPengampu/$id_pengampu");
		}
	}

	public function SubNilaiMataKuliah()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Data Sub Nilai Mata Kuliah";
		$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();

		if ($data['user']['role_id']==1 || $data['user']['role_id']==5) {

			$this->db->select('*, nilai_mahasiswa.id AS nmid');
			$this->db->from('nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();

			$this->db->select('*, pengampu.id AS pid');
			$this->db->from('pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$data['pengampu'] = $this->db->get()->result_array();


			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['nilai_mata_kuliah'] = $this->db->get()->result_array();

			$this->db->select('*, sub_nilai_mata_kuliah.id AS snmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('sub_nilai_mata_kuliah');
			$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['sub_nilai_mata_kuliah'] = $this->db->get()->result_array();
		} elseif ($data['user']['role_id']==4) {

			$this->db->select('*, nilai_mahasiswa.id AS nmid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mahasiswa');
			$this->db->where('pengampu.id_dosen', $dosen['id']);
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('nilai_mata_kuliah', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$data['nilai_mahasiswa'] = $this->db->get()->result_array();
			
			$this->db->select('*, pengampu.id AS pid');
			$this->db->from('pengampu');
			$this->db->where('pengampu.id_dosen', $dosen['id']);
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$data['pengampu'] = $this->db->get()->result_array();

			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('pengampu.id_dosen', $dosen['id']);
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['nilai_mata_kuliah'] = $this->db->get()->result_array();

			$this->db->select('*, sub_nilai_mata_kuliah.id AS snmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('sub_nilai_mata_kuliah');
			$this->db->where('pengampu.id_dosen', $dosen['id']);
			$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$data['sub_nilai_mata_kuliah'] = $this->db->get()->result_array();
		}
		$this->form_validation->set_rules('id_nilai_mahasiswa', 'Student Score', 'required');
		$this->form_validation->set_rules('id_pengampu', 'Lecturer Course', 'required');
		$this->form_validation->set_rules('nama_penilaian', 'Score Name', 'required');
		$this->form_validation->set_rules('bobot', 'Value', 'required');
		$this->form_validation->set_rules('nilai', 'Score', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dosen/data-sub-nilai-mata-kuliah', $data);
			$this->load->view('templates/footer');
		} else{
			$data = [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'id_pengampu' => $this->input->post('id_pengampu')
			];
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, mata_kuliah.semester AS mks');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get_where('nilai_mata_kuliah', $data)->row_array();
			if ($nilai_mata_kuliah) {
				$id_nilai_mata_kuliah = $nilai_mata_kuliah['nmkid'];
			} else{
				$tahun_ajaran = date('Y').'/'.(date('Y')+1);
				$semester = $nilai_mata_kuliah['mks'];
				$this->db->insert('nilai_mata_kuliah', [
					'indeks' => 'T',
					'presensi' => 0,
					'tahun_ajaran' => $tahun_ajaran,
					'semester' => $semester,
					'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
					'id_pengampu' => $this->input->post('id_pengampu')
				]);
				$nilai_mata_kuliah = $this->db->get_where('nilai_mata_kuliah', $data)->row_array();
				$id_nilai_mata_kuliah = $nilai_mata_kuliah['nmkid'];
			}
			$this->db->insert('sub_nilai_mata_kuliah', [
				'nama_penilaian' => $this->input->post('nama_penilaian'),
				'bobot' => $this->input->post('bobot'),
				'nilai' => $this->input->post('nilai'),
				'id_nilai_mata_kuliah' => $id_nilai_mata_kuliah
			]);
			$this->db->select('*, (nilai*bobot) AS hasil, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
			$this->db->from('sub_nilai_mata_kuliah');
			$this->db->where('id_nilai_mata_kuliah', $id_nilai_mata_kuliah);
			$nilai_sub_mata_kuliah = $this->db->get()->result_array();
			$hasil = 0;
			$id_nilai_mahasiswa = 0;
			foreach ($nilai_sub_mata_kuliah as $key) {
				$hasil += $key['hasil'];
				$id_nilai_mahasiswa = $key['id_nilai_mahasiswa'];
			}
			$indeks = hasilIndeks($hasil);
			$this->db->where('id', $id_nilai_mata_kuliah);
			$this->db->update('nilai_mata_kuliah', ['indeks' => $indeks]);

			$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id', $id_nilai_mahasiswa);
			$this->db->update('nilai_mahasiswa', $data);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $semester);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ip_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ip = $total_nilai_mutu/$total_sks;
			$data = [
				'ip' => $ip
			];
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->where('semester', $semester);
			$this->db->update('ip_semester', $data);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $semester);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ipk_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data3 = [
				'ipk' => $ipk
			];
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->where('semester', $semester);
			$this->db->update('ip_semester', $data3);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Course Score Added!
				</div>');
			redirect("Dosen/subNilaiMataKuliah/");
		}
	}

	public function detailSubNilaiMataKuliah($id_nilai_mata_kuliah)
	{
		$data = array(); // Buat variabel $data sebagai array
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Detail Sub Nilai Mata Kuliah ";
		
		if(isset($_POST['upload'])){ // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->Dosen_model->upload_file('import_sub_nilai');
			
			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/import_sub_nilai.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
				
				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet; 
			}else{ // Jika proses upload gagal
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				'.$upload['error'].'
				</div>');
				redirect("Dosen/detailSubNilaiMataKuliah/".$id_nilai_mata_kuliah);
			}
		}
		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('nilai_mata_kuliah.id', $id_nilai_mata_kuliah);
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$data['nilai_mata_kuliah'] = $this->db->get()->row_array();

		$data['sub_nilai_mata_kuliah'] = $this->db->get_where('sub_nilai_mata_kuliah', ['id_nilai_mata_kuliah' => $id_nilai_mata_kuliah])->result_array();
		$this->form_validation->set_rules('id_nilai_mata_kuliah', 'Component Score', 'required');
		$this->form_validation->set_rules('nama_penilaian', 'Score Name', 'required');
		$this->form_validation->set_rules('bobot', 'Value', 'required');
		$this->form_validation->set_rules('nilai', 'Score', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dosen/detail-sub-nilai-mata-kuliah', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('sub_nilai_mata_kuliah', [
				'nama_penilaian' => $this->input->post('nama_penilaian'),
				'bobot' => $this->input->post('bobot'),
				'nilai' => $this->input->post('nilai'),
				'id_nilai_mata_kuliah' => $this->input->post('id_nilai_mata_kuliah')
			]);
			$this->db->select('*, (nilai*bobot) AS hasil');
			$this->db->from('sub_nilai_mata_kuliah');
			$this->db->where('id_nilai_mata_kuliah', $this->input->post('id_nilai_mata_kuliah'));
			$nilai_sub_mata_kuliah = $this->db->get()->result_array();
			$hasil = 0;
			foreach ($nilai_sub_mata_kuliah as $key) {
				$hasil += $key['hasil'];
			}
			$indeks = hasilIndeks($hasil);
			$this->db->where('id', $this->input->post('id_nilai_mata_kuliah'));
			$this->db->update('nilai_mata_kuliah', ['indeks' => $indeks]);

			$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$update = [
				'ipk' => $ipk
			];
			$this->db->where('id', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->update('nilai_mahasiswa', $update);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $data['nilai_mata_kuliah']['nmk_semester']);
			$this->db->where('id_nilai_mahasiswa', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ip_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ip = $total_nilai_mutu/$total_sks;
			$update = [
				'ip' => $ip
			];
			$this->db->where('id_nilai_mahasiswa', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->where('semester', $data['nilai_mata_kuliah']['nmk_semester']);
			$this->db->update('ip_semester', $update);
			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $data['nilai_mata_kuliah']['nmk_semester']);
			$this->db->where('id_nilai_mahasiswa', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();

			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($ipk_semester as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$update = [
				'ipk' => $ipk
			];
			$this->db->where('id_nilai_mahasiswa', $data['nilai_mata_kuliah']['id_nilai_mahasiswa']);
			$this->db->where('semester', $data['nilai_mata_kuliah']['nmk_semester']);
			$this->db->update('ip_semester', $update);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Course Score Added!
				</div>');
			redirect("Dosen/detailSubNilaiMataKuliah/".$this->input->post('id_nilai_mata_kuliah'));
		}
	}

	public function uploadDetailSubNilaiMataKuliah($id_nilai_mata_kuliah)
	{
		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('nilai_mata_kuliah.id', $id_nilai_mata_kuliah);
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$this->db->join('dosen', 'dosen.id=pengampu.id_dosen');
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$nilai_mata_kuliah = $this->db->get()->row_array();
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/import_sub_nilai.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		
		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'nama_penilaian'=>$row['A'], // Insert data nis dari kolom A di excel
					'bobot'=>$row['B'], // Insert data nama dari kolom B di excel
					'nilai'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
					'id_nilai_mata_kuliah' => $id_nilai_mata_kuliah,
				));
			}
			
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
		$this->Dosen_model->insert_excelSubNilaiMataKuliah($data);
		$this->db->select('*, (nilai*bobot) AS hasil');
		$this->db->from('sub_nilai_mata_kuliah');
		$this->db->where('id_nilai_mata_kuliah', $id_nilai_mata_kuliah);
		$nilai_sub_mata_kuliah = $this->db->get()->result_array();
		$hasil = 0;
		foreach ($nilai_sub_mata_kuliah as $key) {
			$hasil += $key['hasil'];
		}
		$indeks = hasilIndeks($hasil);
		$this->db->where('id', $id_nilai_mata_kuliah);
		$this->db->update('nilai_mata_kuliah', ['indeks' => $indeks]);

		$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$nilai_mata_kuliah_a = $this->db->get()->result_array();
		$total_sks = 0;
		$total_nilai_mutu = 0;
		foreach ($nilai_mata_kuliah_a as $key) {
			$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
			$total_sks += $key['sks'];
			$total_nilai_mutu += $nilai_mutu;
		}
		$ipk = $total_nilai_mutu/$total_sks;
		$update = [
			'ipk' => $ipk
		];
		$this->db->where('id', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->update('nilai_mahasiswa', $update);

		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('nilai_mata_kuliah.semester', $nilai_mata_kuliah['nmk_semester']);
		$this->db->where('id_nilai_mahasiswa', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$ip_semester = $this->db->get()->result_array();

		$total_sks = 0;
		$total_nilai_mutu = 0;
		foreach ($ip_semester as $key) {
			$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
			$total_sks += $key['sks'];
			$total_nilai_mutu += $nilai_mutu;
		}
		$ip = $total_nilai_mutu/$total_sks;
		$update = [
			'ip' => $ip
		];
		$this->db->where('id_nilai_mahasiswa', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->where('semester', $nilai_mata_kuliah['nmk_semester']);
		$this->db->update('ip_semester', $update);
		
		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('nilai_mata_kuliah.semester <=', $nilai_mata_kuliah['nmk_semester']);
		$this->db->where('id_nilai_mahasiswa', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$ipk_semester = $this->db->get()->result_array();

		$total_sks = 0;
		$total_nilai_mutu = 0;
		foreach ($ipk_semester as $key) {
			$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
			$total_sks += $key['sks'];
			$total_nilai_mutu += $nilai_mutu;
		}
		$ipk = $total_nilai_mutu/$total_sks;
		$data = [
			'ipk' => $ipk
		];
		$this->db->where('id_nilai_mahasiswa', $nilai_mata_kuliah['id_nilai_mahasiswa']);
		$this->db->where('semester', $nilai_mata_kuliah['nmk_semester']);
		$this->db->update('ip_semester', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			New Course Score Added!
			</div>');
		redirect("Dosen/detailSubNilaiMataKuliah/".$id_nilai_mata_kuliah); // Redirect ke halaman awal (ke controller siswa fungsi index)
	}


	public function uploadNilaiMataKuliah()
	{

		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/import_nilai_matkul.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				$this->db->select('*, nilai_mahasiswa.id AS nmid');
				$this->db->join('mahasiswa', 'mahasiswa.id = nilai_mahasiswa.id_mahasiswa');
				$nilai_mahasiswa = $this->db->get_where('nilai_mahasiswa', ['nim' => $row['A']])->row_array();
				if (!$nilai_mahasiswa) {
					break;
					// $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					// 	Student NIM is not registered!
					// 	</div>');
				} else{
					$data = array(
						'id_nilai_mahasiswa' => $nilai_mahasiswa['nmid'],
						'indeks'=>$row['B'], // Insert data nama dari kolom B di excel
						'presensi'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
						'tahun_ajaran'=>$row['D'], // Insert data jenis kelamin dari kolom C di excel
						'semester'=>$row['E'], // Insert data jenis kelamin dari kolom C di excel
						'id_pengampu'=>$row['F'], // Insert data jenis kelamin dari kolom C di excel
					);
					$nilai_mata_kuliah = $this->db->get_where('nilai_mata_kuliah', ['id_nilai_mahasiswa' => $nilai_mahasiswa['nmid'], 'id_pengampu' => $row['F']])->row_array();
					if (!$nilai_mata_kuliah) {
						$this->db->insert('nilai_mata_kuliah', $data);
					} else{
						$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
						$this->db->where('id_pengampu', $row['F']);
						$this->db->update('nilai_mata_kuliah', $data);
					}

					$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
					$this->db->from('nilai_mata_kuliah');
					$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
					$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
					$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
					$this->db->join('user', 'mahasiswa.id_user=user.id');
					$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
					$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
					$nilai_mata_kuliah = $this->db->get()->result_array();
					$total_sks = 0;
					$total_nilai_mutu = 0;
					foreach ($nilai_mata_kuliah as $key) {
						$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
						$total_sks += $key['sks'];
						$total_nilai_mutu += $nilai_mutu;
					}
					$ipk = $total_nilai_mutu/$total_sks;
					$data = [
						'ipk' => $ipk
					];
					$this->db->where('id', $nilai_mahasiswa['nmid']);
					$this->db->update('nilai_mahasiswa', $data);
					$smt = 1;
					while ($smt <= 6) {
						$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
						$this->db->from('nilai_mata_kuliah');
						$this->db->where('nilai_mata_kuliah.semester', $smt);
						$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
						$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
						$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
						$this->db->join('user', 'mahasiswa.id_user=user.id');
						$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
						$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
						$ip_semester = $this->db->get()->result_array();
						if ($ip_semester) {
							$total_sks = 0;
							$total_nilai_mutu = 0;
							foreach ($ip_semester as $key) {
								$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
								$total_sks += $key['sks'];
								$total_nilai_mutu += $nilai_mutu;
							}
							$ip = $total_nilai_mutu/$total_sks;
							$data = [
								'ip' => $ip
							];
							$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
							$this->db->where('semester', $smt);
							$this->db->update('ip_semester', $data);
						}
						
						$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
						$this->db->from('nilai_mata_kuliah');
						$this->db->where('nilai_mata_kuliah.semester <=', $smt);
						$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
						$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
						$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
						$this->db->join('user', 'mahasiswa.id_user=user.id');
						$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
						$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
						$ipk_semester = $this->db->get()->result_array();
						if ($ipk_semester) {
							$total_sks = 0;
							$total_nilai_mutu = 0;
							foreach ($ipk_semester as $key) {
								$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
								$total_sks += $key['sks'];
								$total_nilai_mutu += $nilai_mutu;
							}
							$ipk = $total_nilai_mutu/$total_sks;
							$data = [
								'ipk' => $ipk
							];
							$this->db->where('id_nilai_mahasiswa', $nilai_mahasiswa['nmid']);
							$this->db->where('semester', $smt);
							$this->db->update('ip_semester', $data);
						}
						$smt++;
					}
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						New Course Score Added!
						</div>');
				}

			}
			
			$numrow++; // Tambah 1 setiap kali looping
		}
		redirect('Dosen/nilaiMataKuliah');
	}


	public function uploadNilaiMahasiswa()
	{

		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/import_nilai_mahasiswa.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				$mahasiswa = $this->db->get_where('mahasiswa', ['nim' => $row['A']])->row_array();
				if (!$mahasiswa) {
					break;
					// $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					// 	Student NIM is not registered!
					// 	</div>');
				} else{
					$data = array(
						'id_mahasiswa' => $mahasiswa['id'],
						'ipk'=>$row['B'], // Insert data nama dari kolom B di excel
						'tak'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
					);
					$nilai_mahasiswa = $this->db->get_where('nilai_mahasiswa', ['id_mahasiswa' => $mahasiswa['id']])->row_array();
					if (!$nilai_mahasiswa) {
						$this->db->insert('nilai_mahasiswa', $data);
					} else{
						$this->db->where('id_mahasiswa', $mahasiswa['id']);
						$this->db->update('nilai_mahasiswa', $data);
					}

					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						New Course Score Added!
						</div>');
				}

			}
			
			$numrow++; // Tambah 1 setiap kali looping
		}
		redirect('Dosen/nilaiMahasiswa');
	}


	public function deleteNilaiMahasiswa($id)
	{
		$this->db->delete('nilai_mahasiswa', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Student Score Deleted!
			</div>');
		redirect("Dosen/nilaiMahasiswa/");
	}

	public function deleteNilaiMataKuliah($id, $id_nilai_mahasiswa)
	{
		$this->db->delete('nilai_mata_kuliah', ['id' => $id]);
		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$nilai_mata_kuliah = $this->db->get()->result_array();
		$total_sks = 0;
		$total_nilai_mutu = 0;
		foreach ($nilai_mata_kuliah as $key) {
			$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
			$total_sks += $key['sks'];
			$total_nilai_mutu += $nilai_mutu;
		}
		$ipk = $total_nilai_mutu/$total_sks;
		$data = [
			'ipk' => $ipk
		];
		$this->db->where('id', $id_nilai_mahasiswa);
		$this->db->update('nilai_mahasiswa', $data);
		$smt = 1;
		while ($smt <= 6) {
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $smt);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();
			if ($ip_semester) {
				$total_sks = 0;
				$total_nilai_mutu = 0;
				foreach ($ip_semester as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ip = $total_nilai_mutu/$total_sks;
				$data = [
					'ip' => $ip
				];
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->where('semester', $smt);
				$this->db->update('ip_semester', $data);				
			}

			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $smt);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();
			if ($ipk_semester) {
				$total_sks = 0;
				$total_nilai_mutu = 0;
				foreach ($ipk_semester as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ipk = $total_nilai_mutu/$total_sks;
				$data = [
					'ipk' => $ipk
				];
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->where('semester', $smt);
				$this->db->update('ip_semester', $data);
			}

			$smt++;
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Course Score Deleted!
			</div>');
		redirect("Dosen/nilaiMataKuliah/");
	}

	public function deleteSubNilaiMataKuliah($id, $id_nilai_mata_kuliah, $page = 'data')
	{
		$this->db->delete('sub_nilai_mata_kuliah', ['id' => $id]);
		$this->db->select('*, (nilai*bobot) AS hasil');
		$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
		$this->db->from('sub_nilai_mata_kuliah');
		$this->db->where('id_nilai_mata_kuliah', $id_nilai_mata_kuliah);
		$nilai_sub_mata_kuliah = $this->db->get()->result_array();
		$hasil = 0;
		$id_nilai_mahasiswa = 0;
		foreach ($nilai_sub_mata_kuliah as $key) {
			$hasil += $key['hasil'];
			$id_nilai_mahasiswa = $key['id_nilai_mahasiswa'];
		}
		$indeks = hasilIndeks($hasil);
		$this->db->where('id', $id_nilai_mata_kuliah);
		$this->db->update('nilai_mata_kuliah', ['indeks' => $indeks]);

		$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$nilai_mata_kuliah = $this->db->get()->result_array();
		$total_sks = 0;
		$total_nilai_mutu = 0;
		foreach ($nilai_mata_kuliah as $key) {
			$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
			$total_sks += $key['sks'];
			$total_nilai_mutu += $nilai_mutu;
		}
		$ipk = $total_nilai_mutu/$total_sks;
		$data = [
			'ipk' => $ipk
		];
		$this->db->where('id', $id_nilai_mahasiswa);
		$this->db->update('nilai_mahasiswa', $data);
		$smt = 1;
		while ($smt <= 6) {
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester', $smt);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ip_semester = $this->db->get()->result_array();
			if ($ip_semester) {
				$total_sks = 0;
				$total_nilai_mutu = 0;
				foreach ($ip_semester as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ip = $total_nilai_mutu/$total_sks;
				$data = [
					'ip' => $ip
				];
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->where('semester', $smt);
				$this->db->update('ip_semester', $data);
			}

			
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('nilai_mata_kuliah.semester <=', $smt);
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$ipk_semester = $this->db->get()->result_array();
			if ($ipk_semester) {
				$total_sks = 0;
				$total_nilai_mutu = 0;
				foreach ($ipk_semester as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ipk = $total_nilai_mutu/$total_sks;
				$data = [
					'ipk' => $ipk
				];
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->where('semester', $smt);
				$this->db->update('ip_semester', $data);
			}

			$smt++;
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			New Sub Course Score Deleted!
			</div>');
		if ($page == 'data') {
			redirect("Dosen/subNilaiMataKuliah/");
		} elseif ($page == 'detail') {
			redirect("Dosen/detailSubNilaiMataKuliah/$id_nilai_mata_kuliah");
		}
	}

	public function updateNilaiMahasiswa()
	{
		$this->form_validation->set_rules('id_mahasiswa', 'Student Name', 'required');
		$this->form_validation->set_rules('ipk', 'GPA', 'required');
		$this->form_validation->set_rules('tak', 'TAK', 'required');
		if ($this->form_validation->run() == false) {
			redirect('Dosen/nilaiMahasiswa');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('nilai_mahasiswa', [
				'id_mahasiswa' => $this->input->post('id_mahasiswa'),
				'ipk' => $this->input->post('ipk'),
				'tak' => $this->input->post('tak')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Student Score Updated!
				</div>');
			redirect('Dosen/nilaiMahasiswa');
		}
	}

	public function updateNilaiMataKuliah()
	{
		$this->form_validation->set_rules('id_nilai_mahasiswa', 'Student', 'required');
		$this->form_validation->set_rules('indeks', 'Index', 'required');
		$this->form_validation->set_rules('tahun_ajaran', 'Academic Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');
		$this->form_validation->set_rules('id_pengampu', 'Lecturer Course', 'required');
		if ($this->form_validation->run() == false) {
			redirect('Dosen/nilaiMataKuliah');
		} else{
			if (!empty($this->input->post('presensi1')) || !empty($this->input->post('presensi2'))) {
				$presensi1 = $this->input->post('presensi1');
				$presensi2 = $this->input->post('presensi2');
				$presensi = $presensi2/$presensi1;
			} else{
				$presensi = $this->input->post('presensi');
			}
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('nilai_mata_kuliah', [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'indeks' => $this->input->post('indeks'),
				'presensi' => $presensi,
				'tahun_ajaran' => $this->input->post('tahun_ajaran'),
				'semester' => $this->input->post('semester'),
				'id_pengampu' => $this->input->post('id_pengampu')
			]);
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id', $this->input->post('id_nilai_mahasiswa'));
			$this->db->update('nilai_mahasiswa', $data);
			$smt = 1;
			while ($smt <= 6) {
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('nilai_mata_kuliah.semester', $smt);
				$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$ip_semester = $this->db->get()->result_array();

				if ($ip_semester) {
					$total_sks = 0;
					$total_nilai_mutu = 0;
					foreach ($ip_semester as $key) {
						$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
						$total_sks += $key['sks'];
						$total_nilai_mutu += $nilai_mutu;
					}
					$ip = $total_nilai_mutu/$total_sks;
					$data = [
						'ip' => $ip
					];
					$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
					$this->db->where('semester', $smt);
					$this->db->update('ip_semester', $data);
				}
				
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('nilai_mata_kuliah.semester <=', $smt);
				$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$ipk_semester = $this->db->get()->result_array();

				if ($ipk_semester) {
					$total_sks = 0;
					$total_nilai_mutu = 0;
					foreach ($ipk_semester as $key) {
						$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
						$total_sks += $key['sks'];
						$total_nilai_mutu += $nilai_mutu;
					}
					$ipk = $total_nilai_mutu/$total_sks;
					$data = [
						'ipk' => $ipk
					];
					$this->db->where('id_nilai_mahasiswa', $this->input->post('id_nilai_mahasiswa'));
					$this->db->where('semester', $smt);
					$this->db->update('ip_semester', $data);
				}
				$smt++;
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Course Score Updated!
				</div>');
			redirect('Dosen/nilaiMataKuliah');
		}
	}

	public function updateSubNilaiMataKuliah($id_nilai_mata_kuliah, $page = 'data')
	{
		$this->form_validation->set_rules('id_nilai_mata_kuliah', 'Component Score', 'required');
		$this->form_validation->set_rules('nama_penilaian', 'Score Name', 'required');
		$this->form_validation->set_rules('bobot', 'Value', 'required');
		$this->form_validation->set_rules('nilai', 'Score', 'required');
		if ($this->form_validation->run() == false) {
			redirect('Dosen/subNilaiMataKuliah');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('sub_nilai_mata_kuliah', [
				'nama_penilaian' => $this->input->post('nama_penilaian'),
				'bobot' => $this->input->post('bobot'),
				'nilai' => $this->input->post('nilai'),
				'id_nilai_mata_kuliah' => $this->input->post('id_nilai_mata_kuliah')
			]);
			$this->db->select('*, (nilai*bobot) AS hasil, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->join('nilai_mata_kuliah', 'sub_nilai_mata_kuliah.id_nilai_mata_kuliah=nilai_mata_kuliah.id');
			$this->db->from('sub_nilai_mata_kuliah');
			$this->db->where('id_nilai_mata_kuliah', $id_nilai_mata_kuliah);
			$nilai_sub_mata_kuliah = $this->db->get()->result_array();
			$hasil = 0;
			$id_nilai_mahasiswa = 0;
			foreach ($nilai_sub_mata_kuliah as $key) {
				$hasil += $key['hasil'];
				$id_nilai_mahasiswa = $key['id_nilai_mahasiswa'];
			}
			$indeks = hasilIndeks($hasil);
			$this->db->where('id', $id_nilai_mata_kuliah);
			$this->db->update('nilai_mata_kuliah', ['indeks' => $indeks]);

			$this->db->select('*, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			foreach ($nilai_mata_kuliah as $key) {
				$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
				$total_sks += $key['sks'];
				$total_nilai_mutu += $nilai_mutu;
			}
			$ipk = $total_nilai_mutu/$total_sks;
			$data = [
				'ipk' => $ipk
			];
			$this->db->where('id', $id_nilai_mahasiswa);
			$this->db->update('nilai_mahasiswa', $data);
			$smt = 1;
			while ($smt <= 6) {
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('nilai_mata_kuliah.semester', $smt);
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$ip_semester = $this->db->get()->result_array();
				if ($ip_semester) {
					$total_sks = 0;
					$total_nilai_mutu = 0;
					foreach ($ip_semester as $key) {
						$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
						$total_sks += $key['sks'];
						$total_nilai_mutu += $nilai_mutu;
					}
					$ip = $total_nilai_mutu/$total_sks;
					$data = [
						'ip' => $ip
					];
					$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
					$this->db->where('semester', $smt);
					$this->db->update('ip_semester', $data);
				}
				
				$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
				$this->db->from('nilai_mata_kuliah');
				$this->db->where('nilai_mata_kuliah.semester <=', $smt);
				$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
				$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
				$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
				$this->db->join('user', 'mahasiswa.id_user=user.id');
				$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
				$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
				$ipk_semester = $this->db->get()->result_array();
				if ($ipk_semester) {
					$total_sks = 0;
					$total_nilai_mutu = 0;
					foreach ($ipk_semester as $key) {
						$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
						$total_sks += $key['sks'];
						$total_nilai_mutu += $nilai_mutu;
					}
					$ipk = $total_nilai_mutu/$total_sks;
					$data = [
						'ipk' => $ipk
					];
					$this->db->where('id_nilai_mahasiswa', $id_nilai_mahasiswa);
					$this->db->where('semester', $smt);
					$this->db->update('ip_semester', $data);
				}

				$smt++;
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Sub Course Score Deleted!
				</div>');
			if ($page == 'data') {
				redirect("Dosen/subNilaiMataKuliah/");
			} elseif ($page == 'detail') {
				redirect("Dosen/detailSubNilaiMataKuliah/$id_nilai_mata_kuliah");
			}
		}
	}

	public function print($id_mahasiswa)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";
		$this->db->select('*, mahasiswa.id AS mid');
		$this->db->from('user');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$data['mahasiswa'] = $this->db->get()->row_array();

		$data['nilai_mahasiswa'] = $this->db->get_where('nilai_mahasiswa', ['id_mahasiswa' => $id_mahasiswa])->row_array();
		
		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$data['presensi'] = $this->db->get()->row_array();

		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$this->db->group_by('nilai_mata_kuliah.semester');
		$data['presensi_semester'] = $this->db->get()->result_array();

		$this->db->select('SUM(sks) AS sum_sks');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['sum_sks'] = $this->db->get()->row_array();


		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, mahasiswa.id AS mid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['nilai_mata_kuliah'] = $this->db->get()->result_array();

		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ip[$i] = 0;
			} else{
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ip[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$this->db->select('MAX(nilai_mata_kuliah.semester) AS max_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_mahasiswa', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$max_semester = $this->db->get()->row_array();
		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester <=', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ipk[$i] = 0;
			} elseif ($i+1 > $max_semester['max_semester']) {
				$ipk[$i] = 0;
			} else {
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ipk[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$data['ip'] = $ip;
		$data['ipk'] = $ipk;
		$this->load->view('templates/header', $data);
		$this->load->view('dosen/print-performa', $data);
		$this->load->view('templates/footer');
	}

	public function export_pdf($id_mahasiswa)
	{
		$this->load->library('dompdf_gen');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Mahasiswa";
		$this->db->select('*, mahasiswa.id AS mid');
		$this->db->from('user');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
		$data['mahasiswa'] = $this->db->get()->row_array();

		$data['nilai_mahasiswa'] = $this->db->get_where('nilai_mahasiswa', ['id_mahasiswa' => $id_mahasiswa])->row_array();
		
		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$data['presensi'] = $this->db->get()->row_array();

		$this->db->select('SUM(presensi) AS sum_presensi, COUNT(presensi) AS count_presensi');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_nilai_mahasiswa', $data['nilai_mahasiswa']['id']);
		$this->db->group_by('nilai_mata_kuliah.semester');
		$data['presensi_semester'] = $this->db->get()->result_array();

		$this->db->select('SUM(sks) AS sum_sks');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['sum_sks'] = $this->db->get()->row_array();


		$this->db->select('*, nilai_mata_kuliah.id AS nmkid, mahasiswa.id AS mid, nilai_mata_kuliah.semester AS nmk_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('mahasiswa.id', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mata_kuliah.id_nilai_mahasiswa=nilai_mahasiswa.id');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('pengampu', 'nilai_mata_kuliah.id_pengampu=pengampu.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['nilai_mata_kuliah'] = $this->db->get()->result_array();

		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ip[$i] = 0;
			} else{
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ip[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$this->db->select('MAX(nilai_mata_kuliah.semester) AS max_semester');
		$this->db->from('nilai_mata_kuliah');
		$this->db->where('id_mahasiswa', $id_mahasiswa);
		$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
		$this->db->join('user', 'mahasiswa.id_user=user.id');
		$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
		$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
		$max_semester = $this->db->get()->row_array();
		for ($i=0; $i < 6; $i++) { 
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
			$this->db->from('nilai_mata_kuliah');
			$this->db->where('id_mahasiswa', $id_mahasiswa);
			$this->db->where('nilai_mata_kuliah.semester <=', ($i+1));
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa=mahasiswa.id');
			$this->db->join('user', 'mahasiswa.id_user=user.id');
			$this->db->join('pengampu', 'pengampu.id=nilai_mata_kuliah.id_pengampu');
			$this->db->join('mata_kuliah', 'mata_kuliah.id=pengampu.id_mata_kuliah');
			$nilai_mata_kuliah = $this->db->get()->result_array();
			$total_sks = 0;
			$total_nilai_mutu = 0;
			if (!$nilai_mata_kuliah) {
				$ipk[$i] = 0;
			} elseif ($i+1 > $max_semester['max_semester']) {
				$ipk[$i] = 0;
			} else {
				foreach ($nilai_mata_kuliah as $key) {
					$nilai_mutu = nilaiMutuIndeks($key['indeks'], $key['sks']);
					$total_sks += $key['sks'];
					$total_nilai_mutu += $nilai_mutu;
				}
				$ipk[$i] = $total_nilai_mutu/$total_sks;
			}
		}

		$data['ip'] = $ip;
		$data['ipk'] = $ipk;
		$this->load->view('dosen/pdf-performa', $data);
		$paper_size = 'A4';
		$orientation = 'landscape';
		$html = $this->output->get_output();
		$this->dompdf->set_paper($paper_size, $orientation);
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("laporan_mahasiswa.pdf", array('Attachment' => 0));
	}

	public function downloadDataPengampu()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Data Pengampu Mata Kuliah";
		$this->db->select('*, dosen.id AS did');
		$this->db->from('dosen');
		$this->db->join('user', 'dosen.id_user=user.id');
		$data['dosen'] = $this->db->get()->result_array();
		$data['mata_kuliah'] = $this->db->get('mata_kuliah')->result_array();
		$this->db->select('*, pengampu.id AS pid');
		$this->db->from('pengampu');
		$this->db->join('dosen', 'pengampu.id_dosen=dosen.id');
		$this->db->join('user', 'dosen.id_user=user.id');
		$this->db->join('mata_kuliah', 'pengampu.id_mata_kuliah=mata_kuliah.id');
		$data['pengampu'] = $this->db->get()->result_array();
		$this->form_validation->set_rules('id_dosen', 'Lecturer Name', 'required');
		$this->form_validation->set_rules('id_mata_kuliah', 'Course Name', 'required');
		
		$this->load->view('templates/header', $data);
		$this->load->view('dosen/download-data-pengampu', $data);
		$this->load->view('templates/footer');
	}

	public function getUpdateNilaiMahasiswa(){
		echo json_encode($this->Dosen_model->getNilaiMahasiswaById($this->input->post('id')));
	}

	public function getUpdateNilaiMataKuliah(){
		echo json_encode($this->Dosen_model->getNilaiMataKuliahById($this->input->post('id')));
	}

	public function getUpdateSubNilaiMataKuliah(){
		echo json_encode($this->Dosen_model->getSubNilaiMataKuliahById($this->input->post('id')));
	}
	
}