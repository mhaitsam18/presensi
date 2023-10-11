<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataMaster extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('DataMaster_model');
	}

	public function index()
	{
		$data['title'] = "Data Master";
		$data['dataMaster'] = $this->db->get_where('user_sub_menu',['menu_id' => 7])->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('data-master/index', $data);
		$this->load->view('templates/footer');
	}

	public function agama()
	{
		$data['title'] = "Data Agama";
		$data['agama'] = $this->db->get('agama')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('agama', 'Religion Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-agama', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('agama', [
				'agama' => $this->input->post('agama')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Religion Added!
				</div>');
			redirect('DataMaster/agama');
		}
	}

	public function pendidikan()
	{
		$data['title'] = "Data Pendidikan";
		$data['pendidikan'] = $this->db->get('pendidikan')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('pendidikan', 'Education Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-pendidikan', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('pendidikan', [
				'pendidikan' => $this->input->post('pendidikan')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Education Added!
				</div>');
			redirect('DataMaster/pendidikan');
		}
	}

	public function pertanyaan($pertanyaan = null)
	{
		$data['title'] = "Data Pertanyaan";
		$data['pertanyaan_1'] = $this->db->get('pertanyaan_1')->result_array();
		$data['pertanyaan_2'] = $this->db->get('pertanyaan_2')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-pertanyaan', $data);
			$this->load->view('templates/footer');
		} else{
			if ($pertanyaan == 1) {
				$this->db->insert('pertanyaan_1', [
					'pertanyaan' => $this->input->post('pertanyaan')
				]);
			} elseif ($pertanyaan == 2) {
				$this->db->insert('pertanyaan_2', [
					'pertanyaan' => $this->input->post('pertanyaan')
				]);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Question Added!
				</div>');
			redirect('DataMaster/pertanyaan');
		}
	}

	public function konten()
	{
		$data['title'] = "Data Konten";
		$data['content'] = $this->db->get('content')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('header', 'Header', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-konten', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('content', [
				'header' => $this->input->post('header'),
				'content' => $this->input->post('content'),
				'footer' => $this->input->post('footer'),
				'last_updated' => date("Y-m-d h:i:sa")
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Content Added!
				</div>');
			redirect('DataMaster/konten');
		}
	}

	public function tahunAjaran()
	{
		$data['title'] = "Data Tahun Ajaran";
		$data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('tahun_ajaran', 'School Years', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-tahun-ajaran', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('tahun_ajaran', [
				'tahun_ajaran' => $this->input->post('tahun_ajaran')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Education Added!
				</div>');
			redirect('DataMaster/tahunAjaran');
		}
	}

	public function statusMahasiswa()
	{
		$data['title'] = "Data Status Mahasiswa";
		$data['status_mahasiswa'] = $this->db->get('status_mahasiswa')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('status_mahasiswa', 'Students Status Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-status-mahasiswa', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('status_mahasiswa', [
				'status' => $this->input->post('status')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Status Added!
				</div>');
			redirect('DataMaster/statusMahasiswa');
		}
	}

	public function fakultas()
	{
		$data['title'] = "Data Fakultas";
		$data['fakultas'] = $this->db->get('fakultas')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('kode_fakultas', 'Faculty Code', 'trim|required');
		$this->form_validation->set_rules('nama_fakultas', 'Faculty Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-fakultas', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('fakultas', [
				'kode_fakultas' => $this->input->post('kode_fakultas'),
				'nama_fakultas' => $this->input->post('nama_fakultas')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Faculty Added!
				</div>');
			redirect('DataMaster/fakultas');
		}
	}

	public function prodi()
	{
		$data['title'] = "Data Prodi";
		$data['fakultas'] = $this->db->get('fakultas')->result_array();
		$data['dosen'] = $this->db->get('dosen')->result_array();
		$this->db->select('*, fakultas.id AS fid, dosen.id AS did, user.id AS uid, prodi.id AS pid');
		$this->db->join('fakultas', 'fakultas.id=prodi.id_fakultas');
		$this->db->join('dosen', 'dosen.id=prodi.id_kaprodi');
		$this->db->join('user', 'user.id=dosen.id_user');
		$data['prodi'] = $this->db->get('prodi')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('kode_prodi', 'Prodi code', 'trim|required');
		$this->form_validation->set_rules('nama_prodi', 'Prodi Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-prodi', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('prodi', [
				'kode_prodi' => $this->input->post('kode_prodi'),
				'nama_prodi' => $this->input->post('nama_prodi'),
				'id_fakultas' => $this->input->post('id_fakultas'),
				'id_kaprodi' => $this->input->post('id_kaprodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Prodi Added!
				</div>');
			redirect('DataMaster/prodi');
		}
	}

	public function kelas()
	{
		$data['title'] = "Data Kelas";
		$data['prodi'] = $this->db->get('prodi')->result_array();
		$data['dosen'] = $this->db->get('dosen')->result_array();
		$this->db->select('*, kelas.id AS kid, dosen.id AS did, user.id AS uid, prodi.id AS pid');
		$this->db->join('prodi', 'prodi.id=kelas.id_prodi');
		$this->db->join('dosen', 'dosen.id=kelas.id_dosen_wali');
		$this->db->join('user', 'user.id=dosen.id_user');
		$this->db->order_by('kelas', 'DESC');
		$data['kelas'] = $this->db->get('kelas')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('kelas', 'Class', 'trim|required');
		$this->form_validation->set_rules('nama_ketua_kelas', 'Class Leader', 'trim|required');
		$this->form_validation->set_rules('nomor_ketua_kelas', 'Class Phone Number', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-kelas', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('kelas', [
				'kelas' => $this->input->post('kelas'),
				'semester_kelas' => $this->input->post('semester_kelas'),
				'nama_ketua_kelas' => $this->input->post('nama_ketua_kelas'),
				'nomor_ketua_kelas' => $this->input->post('nomor_ketua_kelas'),
				'id_dosen_wali' => $this->input->post('id_dosen_wali'),
				'id_prodi' => $this->input->post('id_prodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Class Added!
				</div>');
			redirect('DataMaster/kelas');
		}
	}

	public function mataKuliah()
	{
		$data['title'] = "Data Mata Kuliah";
		$data['prodi'] = $this->db->get('prodi')->result_array();
		$this->db->select('*, mata_kuliah.id AS mid, prodi.id AS pid');
		$this->db->join('prodi', 'prodi.id=mata_kuliah.id_prodi');
		$data['mataKuliah'] = $this->db->get('mata_kuliah')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('kode_mata_kuliah', 'Courses Code', 'trim|required');
		$this->form_validation->set_rules('nama_mata_kuliah', 'Courses Name', 'trim|required');
		$this->form_validation->set_rules('sks', 'SKS', 'trim|required');
		$this->form_validation->set_rules('semester', 'Semester', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-mata-kuliah', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->insert('mata_kuliah', [
				'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah'),
				'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah'),
				'sks' => $this->input->post('sks'),
				'semester' => $this->input->post('semester'),
				'id_prodi' => $this->input->post('id_prodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				New Courses Added!
				</div>');
			redirect('DataMaster/mataKuliah');
		}
	}

	public function deleteAgama($id)
	{
		$this->db->delete('agama', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Religion Deleted!
			</div>');
		redirect('DataMaster/agama');
	}

	public function deletePendidikan($id)
	{
		$this->db->delete('pendidikan', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Education Deleted!
			</div>');
		redirect('DataMaster/pendidikan');
	}

	public function deletePertanyaan($pertanyaan = null ,$id)
	{
		if ($pertanyaan == 1) {
			$this->db->delete('pertanyaan_1', ['id' => $id]);
		} elseif ($pertanyaan == 2) {
			$this->db->delete('pertanyaan_2', ['id' => $id]);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Question Deleted!
			</div>');
		redirect('DataMaster/pertanyaan');
	}

	public function deleteTahunAjaran($id)
	{
		$this->db->delete('tahun_ajaran', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			School Years Deleted!
			</div>');
		redirect('DataMaster/tahunAjaran');
	}

	public function deleteKonten($id)
	{
		$this->db->delete('content', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Content Deleted!
			</div>');
		redirect('DataMaster/konten');
	}

	public function deleteStatusMahasiswa($id)
	{
		$this->db->delete('status_mahasiswa', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Status Deleted!
			</div>');
		redirect('DataMaster/statusMahasiswa');
	}

	public function deleteFakultas($id)
	{
		$this->db->delete('fakultas', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Faculty Deleted!
			</div>');
		redirect('DataMaster/fakultas');
	}

	public function deleteProdi($id)
	{
		$this->db->delete('prodi', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Prodi Deleted!
			</div>');
		redirect('DataMaster/prodi');
	}

	public function deleteKelas($id)
	{
		$this->db->delete('kelas', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Class Deleted!
			</div>');
		redirect('DataMaster/kelas');
	}

	public function deleteMataKuliah($id)
	{
		$this->db->delete('MataKuliah', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Course Deleted!
			</div>');
		redirect('DataMaster/mataKuliah');
	}

	public function updateFakultas()
	{
		$this->form_validation->set_rules('kode_fakultas', 'Faculty Code', 'trim|required');
		$this->form_validation->set_rules('nama_fakultas', 'Faculty Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/fakultas');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('fakultas', [
				'kode_fakultas' => $this->input->post('kode_fakultas'),
				'nama_fakultas' => $this->input->post('nama_fakultas')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Faculty Updated!
				</div>');
			redirect('DataMaster/fakultas');
		}
	}
	
	public function updateAgama()
	{
		$this->form_validation->set_rules('agama', 'Religion Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/agama');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('agama', [
				'agama' => $this->input->post('agama')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Religion Updated!
				</div>');
			redirect('DataMaster/agama');
		}
	}
	
	public function updatePendidikan()
	{
		$this->form_validation->set_rules('pendidikan', 'Education Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/pendidikan');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('pendidikan', [
				'pendidikan' => $this->input->post('pendidikan')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Education Updated!
				</div>');
			redirect('DataMaster/pendidikan');
		}
	}
	
	public function updatePertanyaan($pertanyaan=null)
	{
		$this->form_validation->set_rules('pertanyaan', 'Education Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/pertanyaan');
		} else{
			$this->db->where('id', $this->input->post('id'));
			if ($pertanyaan == 1) {
				$this->db->update('pertanyaan_1', [
					'pertanyaan' => $this->input->post('pertanyaan')
				]);
			} elseif ($pertanyaan == 2) {
				$this->db->update('pertanyaan_2', [
					'pertanyaan' => $this->input->post('pertanyaan')
				]);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Question Updated!
				</div>');
			redirect('DataMaster/pertanyaan');
		}
	}
	
	public function updateKonten()
	{
		$this->form_validation->set_rules('header', 'Header', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/konten');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('content', [
				'header' => $this->input->post('header'),
				'content' => $this->input->post('content'),
				'footer' => $this->input->post('footer'),
				'last_updated' => date("Y-m-d h:i:sa")
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Content Updated!
				</div>');
			redirect('DataMaster/konten');
		}
	}
	
	public function updateTahunAjaran()
	{
		$this->form_validation->set_rules('tahun_ajaran', 'School year', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/tahunAjaran');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('tahun_ajaran', [
				'tahun_ajaran' => $this->input->post('tahun_ajaran')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				School Year Updated!
				</div>');
			redirect('DataMaster/tahunAjaran');
		}
	}
	
	public function updateStatusMahasiswa()
	{
		$this->form_validation->set_rules('status', 'Education Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/statusMahasiswa');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('status_mahasiswa', [
				'status' => $this->input->post('status')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Status Updated!
				</div>');
			redirect('DataMaster/statusMahasiswa');
		}
	}
	
	public function updateProdi()
	{
		$this->form_validation->set_rules('kode_prodi', 'Prodi code', 'trim|required');
		$this->form_validation->set_rules('nama_prodi', 'Prodi Name', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/prodi');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('prodi', [
				'kode_prodi' => $this->input->post('kode_prodi'),
				'nama_prodi' => $this->input->post('nama_prodi'),
				'id_fakultas' => $this->input->post('id_fakultas'),
				'id_kaprodi' => $this->input->post('id_kaprodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Prodi Updated!
				</div>');
			redirect('DataMaster/prodi');
		}
	}
	
	public function updateKelas()
	{
		$this->form_validation->set_rules('kelas', 'Class', 'trim|required');
		$this->form_validation->set_rules('nama_ketua_kelas', 'Class Leader', 'trim|required');
		$this->form_validation->set_rules('nomor_ketua_kelas', 'Class Phone Number', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/kelas');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('kelas', [
				'kelas' => $this->input->post('kelas'),
				'nama_ketua_kelas' => $this->input->post('nama_ketua_kelas'),
				'semester_kelas' => $this->input->post('semester_kelas'),
				'nomor_ketua_kelas' => $this->input->post('nomor_ketua_kelas'),
				'id_dosen_wali' => $this->input->post('id_dosen_wali'),
				'id_prodi' => $this->input->post('id_prodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Class Updated!
				</div>');
			redirect('DataMaster/kelas');
		}
	}
	
	public function updateMataKuliah()
	{
		$this->form_validation->set_rules('kode_mata_kuliah', 'Courses Code', 'trim|required');
		$this->form_validation->set_rules('nama_mata_kuliah', 'Courses Name', 'trim|required');
		$this->form_validation->set_rules('sks', 'SKS', 'trim|required');
		$this->form_validation->set_rules('semester', 'Semester', 'trim|required');
		if ($this->form_validation->run() == false) {
			redirect('DataMaster/mataKuliah');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('mata_kuliah', [
				'kode_mata_kuliah' => $this->input->post('kode_mata_kuliah'),
				'nama_mata_kuliah' => $this->input->post('nama_mata_kuliah'),
				'sks' => $this->input->post('sks'),
				'semester' => $this->input->post('semester'),
				'id_prodi' => $this->input->post('id_prodi')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Courses Updated!
				</div>');
			redirect('DataMaster/mataKuliah');
		}
	}

	public function dashboard()
	{
		$data['title'] = "Data Dashboard";
		$data['dashboard'] = $this->db->get('dashboard')->row_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('header', 'Header', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('footer', 'Footer', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('data-master/data-dashboard', $data);
			$this->load->view('templates/footer');
		} else{
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('dashboard', [
				'header' => $this->input->post('header'),
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'footer' => $this->input->post('footer'),
				'icon' => $this->input->post('icon')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Content Updated!
				</div>');
			redirect('DataMaster/dashboard');
		}
	}
	
	public function getUpdateAgama(){
		echo json_encode($this->DataMaster_model->getAgamaById($this->input->post('id')));
	}
	public function getUpdateFakultas(){
		echo json_encode($this->DataMaster_model->getFakultasById($this->input->post('id')));
	}
	public function getUpdateProdi(){
		echo json_encode($this->DataMaster_model->getProdiById($this->input->post('id')));
	}
	public function getUpdateKelas(){
		echo json_encode($this->DataMaster_model->getKelasById($this->input->post('id')));
	}
	public function getUpdateMataKuliah(){
		echo json_encode($this->DataMaster_model->getMataKuliahById($this->input->post('id')));
	}
	public function getUpdatePendidikan(){
		echo json_encode($this->DataMaster_model->getPendidikanById($this->input->post('id')));
	}
	public function getUpdateTahunAjaran(){
		echo json_encode($this->DataMaster_model->getTahunAjaranById($this->input->post('id')));
	}
	public function getUpdateKonten(){
		echo json_encode($this->DataMaster_model->getKontenById($this->input->post('id')));
	}
	public function getUpdateStatusMahasiswa(){
		echo json_encode($this->DataMaster_model->getStatusMahasiswaById($this->input->post('id')));
	}
	public function getUpdatePertanyaan1(){
		echo json_encode($this->DataMaster_model->getPertanyaan1ById($this->input->post('id')));
	}
	public function getUpdatePertanyaan2(){
		echo json_encode($this->DataMaster_model->getPertanyaan2ById($this->input->post('id')));
	}
	
	
}