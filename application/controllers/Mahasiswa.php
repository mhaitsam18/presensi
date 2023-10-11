<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('Mahasiswa_model');
	}

	public function index()
	{
		$data['title'] = "Performaku";

		$this->db->select('*, mahasiswa.id AS mid');
		$this->db->join('mahasiswa', 'user.id=mahasiswa.id_user');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$id_mahasiswa = $data['user']['mid'];
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
		$this->db->group_by('semester');
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
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid, nilai_mata_kuliah.semester AS nmk_semester');
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
			$this->db->select('*, nilai_mata_kuliah.id AS nmkid');
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
		$this->load->view('mahasiswa/index', $data);
		$this->load->view('templates/footer');
	}

	public function detail($id_nilai_mata_kuliah)
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Data Sub Nilai Mata Kuliah";
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
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('mahasiswa/detail', $data);
		$this->load->view('templates/footer');
	}

	public function tak()
	{
		$data['title'] = "Data TAK";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->db->select('*, nilai_mahasiswa.id AS nmid');
		$this->db->from('nilai_mahasiswa');
		$this->db->where('id_user', $data['user']['id']);
		$this->db->join('mahasiswa', 'mahasiswa.id = nilai_mahasiswa.id_mahasiswa');
		$data['nilai_mahasiswa'] = $this->db->get()->row_array();

		$data['tak'] = $this->db->get_where('tak', ['id_nilai_mahasiswa' => $data['nilai_mahasiswa']['nmid']])->result_array();

		$this->form_validation->set_rules('aktivitas', 'Class Leader', 'trim|required');
		$this->form_validation->set_rules('deskripsi', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('semester', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('tahun_ajaran', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('poin', 'Class Phone Number', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('mahasiswa/data-tak', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('tak', [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'aktivitas' => $this->input->post('aktivitas'),
				'deskripsi' => $this->input->post('deskripsi'),
				'semester' => $this->input->post('semester'),
				'tahun_ajaran' => $this->input->post('tahun_ajaran'),
				'poin' => $this->input->post('poin'),
				'date_create' => time(),
				'date_update' => time()
			]);
			$this->db->select('SUM(poin) AS sum_poin');
			$sum_poin = $this->db->get_where('tak', ['id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa')])->row_array();
			$this->db->where('id', $this->input->post('id_nilai_mahasiswa'));
			$this->db->update('nilai_mahasiswa', ['tak' => $sum_poin['sum_poin']]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New TAK Added!
				</div>');
			redirect('Mahasiswa/tak');
		}
	}

	public function deleteTak($id)
	{
		$id_nilai_mahasiswa = $this->db->get_where('tak', ['id' => $id])->row_array();
		$this->db->delete('tak', ['id' => $id]);
		$this->db->select('SUM(poin) AS sum_poin');
		$sum_poin = $this->db->get_where('tak', ['id_nilai_mahasiswa' => $id_nilai_mahasiswa['id_nilai_mahasiswa']])->row_array();
		$this->db->where('id', $id_nilai_mahasiswa['id_nilai_mahasiswa']);
		$this->db->update('nilai_mahasiswa', ['tak' => $sum_poin['sum_poin']]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			TAK Deleted!
			</div>');
		redirect('mahasiswa/tak');
	}

	public function updateTak()
	{
		$data['title'] = "Data TAK";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->db->select('*, nilai_mahasiswa.id AS nmid');
		$this->db->from('nilai_mahasiswa');
		$this->db->where('id_user', $data['user']['id']);
		$this->db->join('mahasiswa', 'mahasiswa.id = nilai_mahasiswa.id_mahasiswa');
		$data['nilai_mahasiswa'] = $this->db->get()->row_array();

		$data['tak'] = $this->db->get_where('tak', ['id_nilai_mahasiswa' => $data['nilai_mahasiswa']['nmid']])->result_array();

		$this->form_validation->set_rules('aktivitas', 'Class Leader', 'trim|required');
		$this->form_validation->set_rules('deskripsi', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('semester', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('tahun_ajaran', 'Class Phone Number', 'trim|required');
		$this->form_validation->set_rules('poin', 'Class Phone Number', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('Mahasiswa/tak');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('tak', [
				'id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa'),
				'aktivitas' => $this->input->post('aktivitas'),
				'deskripsi' => $this->input->post('deskripsi'),
				'semester' => $this->input->post('semester'),
				'tahun_ajaran' => $this->input->post('tahun_ajaran'),
				'poin' => $this->input->post('poin'),
				'date_update' => time()
			]);
			$this->db->select('SUM(poin) AS sum_poin');
			$sum_poin = $this->db->get_where('tak', ['id_nilai_mahasiswa' => $this->input->post('id_nilai_mahasiswa')])->row_array();
			$this->db->where('id', $this->input->post('id_nilai_mahasiswa'));
			$this->db->update('nilai_mahasiswa', ['tak' => $sum_poin['sum_poin']]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New TAK Added!
				</div>');
			redirect('Mahasiswa/tak');
		}
	}

	public function getUpdateTak(){
		echo json_encode($this->Mahasiswa_model->getTakById($this->input->post('id')));
	}

}