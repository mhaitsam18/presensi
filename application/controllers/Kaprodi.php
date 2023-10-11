<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaprodi extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Kaprodi_model');
	}

	public function index($tahun_ajaran = '', $semester = '', $angkatan = '')
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Dashboard Kaprodi";

		$data['konten3'] = $this->db->get_where('content', ['id' => 3])->row_array();
		$data['konten4'] = $this->db->get_where('content', ['id' => 4])->row_array();

		$data['cur_tahun_ajaran'] = str_replace('_', ' / ', $tahun_ajaran);
		$data['cur_semester'] = $semester;

		// $this->db->select("COUNT(DISTINCT(nilai_mahasiswa.id)) AS jml_mhs, AVG(tak) AS avg_tak, semester_kelas");
		// $this->db->from('nilai_mahasiswa');
		// $this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
		// $this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
		// $this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
		// $this->db->where('semester_kelas <=', 6);
		// $this->db->group_by('kelas.semester_kelas');
		// $data['hitung_tak'] = $this->db->get()->result_array();

		$this->db->select("COUNT(DISTINCT(id_nilai_mahasiswa)) AS jml_mhs, AVG(poin) AS avg_tak, semester AS semester_kelas");
		$this->db->group_by('semester');
		$data['hitung_tak'] = $this->db->get('tak')->result_array();

		if ($angkatan != '') {
			$data['arr_angkatan'] = explode("-", $angkatan);
		} else{
			$data['arr_angkatan'] = [];
		}

		if ($tahun_ajaran != '') {
			$tahun = str_replace('_', '/', $tahun_ajaran);
			$this->db->select("COUNT(nilai_mahasiswa.id) AS jml_mhs, AVG(ipk) AS avg_ipk, AVG(tak) AS avg_tak, AVG(presensi) AS avg_presensi");
			$this->db->from('nilai_mahasiswa');
			$this->db->where('tahun_ajaran', $tahun);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("MOD(semester, 2) =", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("MOD(semester, 2) =", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}

			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->group_by('semester');
			$data['value_mahasiswa_semester'] = $this->db->get()->result_array();

			$this->db->distinct();
			$this->db->select("angkatan");
			$this->db->where('tahun_ajaran', $tahun);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("MOD(semester, 2) =", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("MOD(semester, 2) =", 1);
			}
			$this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$data['angkatan'] = $this->db->get('mahasiswa')->result_array();

			$this->db->distinct();
			$this->db->select("semester");
			$this->db->from('nilai_mahasiswa');
			$this->db->where('tahun_ajaran', $tahun);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("MOD(semester, 2) =", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("MOD(semester, 2) =", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->group_by('semester');
			$data['distinct_semester'] = $this->db->get()->result_array();

			$this->db->select("AVG(ip_semester.ipk) AS avg_ipk, AVG(ip) AS avg_ip");
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			
			$this->db->where('tahun_ajaran', $tahun);
			$this->db->where('ip !=', 0);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("MOD(ip_semester.semester, 2) =", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("MOD(ip_semester.semester, 2) =", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->group_by('nilai_mata_kuliah.semester');
			$data['ip_ipk_mahasiswa_semester'] = $this->db->get('ip_semester')->result_array();

			$this->db->distinct();
			$this->db->select("nilai_mata_kuliah.semester AS smt");
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			
			$this->db->where('tahun_ajaran', $tahun);
			$this->db->where('ip !=', 0);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("MOD(ip_semester.semester, 2) =", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("MOD(ip_semester.semester, 2) =", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->group_by('nilai_mata_kuliah.semester');
			$data['distinct_semester_ip_ipk'] = $this->db->get('ip_semester')->result_array();

		} else{
			$this->db->select("COUNT(nilai_mahasiswa.id) AS jml_mhs, AVG(ipk) AS avg_ipk, AVG(tak) AS avg_tak, AVG(presensi) AS avg_presensi");
			$this->db->from('nilai_mahasiswa');
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("semester % 2", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("semester % 2", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->group_by('semester');
			$data['value_mahasiswa_semester'] = $this->db->get()->result_array();

			$this->db->distinct();
			$this->db->select("semester");
			$this->db->from('nilai_mahasiswa');
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("semester % 2", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("semester % 2", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->group_by('semester');
			$data['distinct_semester'] = $this->db->get()->result_array();

			$this->db->select("AVG(ip_semester.ipk) AS avg_ipk, AVG(ip) AS avg_ip");
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->where('ip !=', 0);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("ip_semester.semester % 2", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("ip_semester.semester % 2", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->group_by('nilai_mata_kuliah.semester');
			$data['ip_ipk_mahasiswa_semester'] = $this->db->get('ip_semester')->result_array();	

			$this->db->distinct();
			$this->db->select("nilai_mata_kuliah.semester AS smt");
			$this->db->join('nilai_mahasiswa', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
			$this->db->join('mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
			$this->db->join('kelas', 'kelas.id=mahasiswa.id_kelas');
			$this->db->join('nilai_mata_kuliah', 'nilai_mahasiswa.id=nilai_mata_kuliah.id_nilai_mahasiswa');
			$this->db->where('ip !=', 0);
			if ($semester != '' && $semester == 'Genap') {
				$this->db->where("ip_semester.semester % 2", 0);
			} elseif ($semester != '' && $semester == 'Ganjil') {
				$this->db->where("ip_semester.semester % 2", 1);
			}
			$perulangan = 1;
			$isi = array();
			foreach ($data['arr_angkatan'] as $key => $value) {
				array_push($isi, $value);
				// if ($perulangan > 1) {
				// 	$this->db->or_where("angkatan", $value);
				// } else{
				// 	$this->db->where("angkatan", $value);
				// }
				// $perulangan++;
			}
			if (!empty($isi)) {
				$this->db->where_in("angkatan", $isi);
			}
			$this->db->group_by('nilai_mata_kuliah.semester');
			$data['distinct_semester_ip_ipk'] = $this->db->get('ip_semester')->result_array();	
					
		}
		$this->db->select("COUNT(mahasiswa.id) AS jml_mhs");
		$this->db->from('mahasiswa');
		$data['value_mahasiswa'] = $this->db->get()->row_array();
		$this->db->select("AVG(ipk) AS avg_ipk, AVG(tak) AS avg_tak");
		$this->db->from('nilai_mahasiswa');
		$data['value_mahasiswa2'] = $this->db->get()->row_array();
		$this->db->select("AVG(presensi) AS avg_presensi");
		$this->db->from('nilai_mata_kuliah');
		$data['value_mahasiswa3'] = $this->db->get()->row_array();
		$this->db->select("pekerjaan_wali, COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$this->db->group_by('pekerjaan_wali');
		$data['pekerjaan_wali'] = $this->db->get()->result_array();
		$this->db->select("asal_daerah, COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$this->db->group_by('asal_daerah');
		$data['asal_daerah'] = $this->db->get()->result_array();
		$this->db->select("pendidikan.id AS pid, pendidikan, COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$this->db->join('pendidikan', 'pendidikan.id=mahasiswa.pendidikan_wali', 'right');
		$this->db->group_by('pendidikan_wali');
		$this->db->order_by('pendidikan.id', 'ASC');
		$data['pendidikan_wali'] = $this->db->get()->result_array();
		$this->db->select("COUNT(pendidikan_wali) AS count_pendidikan");
		$this->db->from('mahasiswa');
		$data['count_pendidikan'] = $this->db->get()->row_array();
		$this->db->select("COUNT(pekerjaan_wali) AS count_pekerjaan");
		$this->db->from('mahasiswa');
		$data['count_pekerjaan'] = $this->db->get()->row_array();
		$this->db->select("COUNT(asal_daerah) AS count_asal");
		$this->db->from('mahasiswa');
		$data['count_asal'] = $this->db->get()->row_array();
		$this->db->select("COUNT(id_status) AS count_status");
		$this->db->from('mahasiswa');
		$data['count_status'] = $this->db->get()->row_array();

		$this->db->select("tahun_ajaran");
		$this->db->from('nilai_mata_kuliah');
		$this->db->order_by('tahun_ajaran', 'DESC');
		$this->db->group_by('tahun_ajaran');
		$data['tahun_ajaran'] = $this->db->get()->result_array();

		

		$this->db->select("status_mahasiswa.id AS sid, status, COUNT(id_status) AS count_status");
		$this->db->from('mahasiswa');
		$this->db->join('status_mahasiswa', 'status_mahasiswa.id=mahasiswa.id_status');
		$this->db->group_by('id_status');
		$this->db->order_by('status_mahasiswa.id', 'ASC');
		$data['status'] = $this->db->get()->result_array();


		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaprodi/index', $data);
		$this->load->view('templates/footer');
	}

	public function performaKelas()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Performa Kelas";
		if ($data['user']['role_id']==1 || $data['user']['role_id']==5) {
			$this->db->select('*, mahasiswa.id AS mid, kelas.id AS kid, COUNT(mahasiswa.id) AS count_mahasiswa');
			$this->db->join('dosen', 'kelas.id_dosen_wali = dosen.id');
			$this->db->join('user', 'dosen.id_user = user.id');
			$this->db->join('mahasiswa', 'mahasiswa.id_kelas = kelas.id', 'left');
			$this->db->group_by('kelas.id');
			$data['kelas'] = $this->db->get('kelas')->result_array();
		} elseif ($data['user']['role_id']==4) {
			$dosen = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$this->db->select('*, mahasiswa.id AS mid, kelas.id AS kid, COUNT(mahasiswa.id) AS count_mahasiswa');
			$this->db->join('dosen', 'kelas.id_dosen_wali = dosen.id');
			$this->db->join('user', 'dosen.id_user = user.id');
			$this->db->join('mahasiswa', 'mahasiswa.id_kelas = kelas.id', 'left');
			$this->db->group_by('kelas.id');
			$data['kelas'] = $this->db->get_where('kelas', ['id_dosen_wali' => $dosen['id']])->result_array();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaprodi/performa-kelas', $data);
		$this->load->view('templates/footer');
	}

	public function pengampu()
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
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('kaprodi/data-pengampu', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('pengampu', [
				'id_dosen' => $this->input->post('id_dosen'),
				'id_mata_kuliah' => $this->input->post('id_mata_kuliah')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Lecturer'."'".'s Course Added!
				</div>');
			redirect('Kaprodi/pengampu');
		}
	}
	
	public function deletePengampu($id)
	{
		$this->db->delete('pengampu', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Lecturer Course Score Deleted!
			</div>');
		redirect("Kaprodi/pengampu/");
	}

	public function getUpdatePengampu(){
		echo json_encode($this->Kaprodi_model->getPengampuById($this->input->post('id')));
	}

	public function updatePengampu()
	{
		$this->form_validation->set_rules('id_dosen', 'Lecturer Name', 'required');
		$this->form_validation->set_rules('id_mata_kuliah', 'Course Name', 'required');
		if ($this->form_validation->run() == false) {
			redirect('Kaprodi/pengampu');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('pengampu', [
				'id_dosen' => $this->input->post('id_dosen'),
				'id_mata_kuliah' => $this->input->post('id_mata_kuliah')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Lecturer course Updated!
				</div>');
			redirect('Kaprodi/pengampu');
		}
	}

	public function top($angkatan= null, $sort_by = null, $sort = null)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Top Gainer & Top Looser";
		$this->db->select('angkatan');
		$this->db->distinct();
		$data['angkatan'] = $this->db->get('mahasiswa')->result_array();
		$data['cur_angkatan'] = $angkatan;
		if ($angkatan) {
			$this->db->like('kelas', $angkatan);
			$data['kelas'] = $this->db->get('kelas')->row_array();
			$data['total_semester'] = $data['kelas']['semester_kelas'];
			$semester_sebelum = $data['kelas']['semester_kelas']-1;

			$this->db->like('kelas', $angkatan);
			$data['kelas'] = $this->db->get('kelas')->row_array();
			// $data['cur_semester'] = $semester;
			$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum)) AS selisih");
			$this->db->from('user u1');
			$this->db->where('m1.angkatan', $angkatan);
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
			
			$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum)) AS selisih");
			$this->db->from('user u1');
			$this->db->where('m1.angkatan', $angkatan);
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
		} else{
			$data['total_semester'] = null;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kaprodi/top', $data);
		$this->load->view('templates/footer');
	}


	public function topSemester($angkatan = null, $semester = null, $sort_by = null, $sort = null)
	{
		$this->db->like('kelas', $angkatan);
		$data['kelas'] = $this->db->get('kelas')->row_array();
		$data['cur_semester'] = $semester;
		$semester_sebelum = $semester-1;
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.angkatan', $angkatan);
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
		
		$this->db->select("*, u1.id AS uid, m1.id AS mid, n1.id AS nmid, (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum) AS ip_sebelum, (i1.ip - (SELECT ip FROM user u2 JOIN mahasiswa m2 ON u2.id=m2.id_user JOIN nilai_mahasiswa n2 ON m2.id=n2.id_mahasiswa JOIN ip_semester i2 ON n2.id=i2.id_nilai_mahasiswa WHERE u2.id = uid AND i2.semester = $semester_sebelum)) AS selisih");
		$this->db->from('user u1');
		$this->db->where('m1.angkatan', $angkatan);
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

	// public function topAngkatan($angkatan= null)
	// {
	// 	$this->db->like('kelas', $angkatan);
	// 	$data['kelas'] = $this->db->get('kelas')->row_array();
	// 	$semester_kemarin = $data['kelas']['semester_kelas'] - 1;
	// 	$this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
	// 	$this->db->from('user');
	// 	$this->db->where('angkatan', $angkatan);
	// 	$this->db->where('ip_semester.semester', $semester_kemarin);
	// 	$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
	// 	$this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
	// 	$this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
	// 	$this->db->order_by('ip', 'DESC');
	// 	$this->db->limit(5);
	// 	$data['mahasiswa_ip_tertinggi'] = $this->db->get()->result_array();
		
	// 	$this->db->select('*, user.id AS uid, mahasiswa.id AS mid, nilai_mahasiswa.id AS nmid');
	// 	$this->db->from('user');
	// 	$this->db->where('angkatan', $angkatan);
	// 	$this->db->where('ip_semester.semester', $semester_kemarin);
	// 	$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
	// 	$this->db->join('nilai_mahasiswa', 'mahasiswa.id=nilai_mahasiswa.id_mahasiswa');
	// 	$this->db->join('ip_semester', 'nilai_mahasiswa.id=ip_semester.id_nilai_mahasiswa');
	// 	$this->db->order_by('ip', 'ASC');
	// 	$this->db->limit(5);
	// 	$data['mahasiswa_ip_terendah'] = $this->db->get()->result_array();
	// 	$this->load->view('kaprodi/top-angkatan', $data);
	// }
}