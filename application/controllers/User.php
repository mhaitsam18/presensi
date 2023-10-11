<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		is_logged_in();
		$this->load->library('form_validation');
		$this->load->model('User_model');
	}

	public function index()
	{
		$data['title'] = "My Profile";
		$this->db->select('*, user.id AS uid');
		$this->db->join('agama', 'user.religion_id=agama.id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($data['user']['role_id']==3) {
			$data['mahasiswa'] = $this->db->get_where('mahasiswa', ['id_user' => $data['user']['uid']])->row_array();
		} elseif ($data['user']['role_id']==4 || $data['user']['role_id']==5) {
			$data['dosen'] = $this->db->get_where('dosen', ['id_user' => $data['user']['uid']])->row_array();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');
	}


	public function edit()
	{
		$data['title'] = "Edit Profile";
		$this->db->join('agama', 'agama.id = user.religion_id');
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		$data['agama'] = $this->db->get('agama')->result_array();
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		} else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			//jika ada gambar
			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png|svg';
				$config['upload_path'] = './assets/img/profile';
				$config['max_size']     = '2048';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ($old_image !='default.jpg') {
						unlink(FCPATH.'assets/img/profile/'.$old_image);
					} 
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('user');
				}
			}

			$data = [
				'name' => $this->input->post('name'),
				'gender' => $this->input->post('gender'),
				'place_of_birth' => $this->input->post('place_of_birth'),
				'birthday' => $this->input->post('birthday'),
				'phone_number' => $this->input->post('phone_number'),
				'religion_id' => $this->input->post('religion_id'),
				'address' => $this->input->post('address')
			];
			$this->db->where('email', $email);
			$this->db->update('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulation! Your profile has been updated!
				</div>');
			redirect('user');
		}
	}

	public function profilPerkuliahan()
	{
		$data['title'] = "Profil Perkuliahan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		if ($data['user']['role_id']==3) {
			$this->db->select('*, mahasiswa.id AS mid, user.name AS nama_dosen');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('pendidikan', 'mahasiswa.pendidikan_wali=pendidikan.id');
			$this->db->join('dosen', 'kelas.id_dosen_wali=dosen.id');
			$this->db->join('user', 'dosen.id_user=user.id');
			$data['mahasiswa'] = $this->db->get_where('mahasiswa', ['mahasiswa.id_user' => $data['user']['id']])->row_array();
			$data['kelas'] = $this->db->get('kelas')->result_array();
			$data['pendidikan'] = $this->db->get('pendidikan')->result_array();
			$akses = "profil-mahasiswa";
		} elseif ($data['user']['role_id']==4 || $data['user']['role_id']==5) {
			$data['dosen'] = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$akses = "profil-dosen";
		} elseif ($data['user']['role_id']==1) {
			$this->db->select('*, mahasiswa.id AS mid, user.name AS nama_dosen');
			$this->db->join('kelas', 'mahasiswa.id_kelas=kelas.id');
			$this->db->join('pendidikan', 'mahasiswa.pendidikan_wali=pendidikan.id');
			$this->db->join('dosen', 'kelas.id_dosen_wali=dosen.id');
			$this->db->join('user', 'dosen.id_user=user.id');
			$data['mahasiswa'] = $this->db->get_where('mahasiswa', ['mahasiswa.id_user' => $data['user']['id']])->row_array();
			$data['kelas'] = $this->db->get('kelas')->result_array();
			$data['pendidikan'] = $this->db->get('pendidikan')->result_array();
			$data['dosen'] = $this->db->get_where('dosen', ['id_user' => $data['user']['id']])->row_array();
			$akses = "profil-admin";
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view("user/$akses", $data);
		$this->load->view('templates/footer');
	}

	public function updateMahasiswa()
	{
		$this->form_validation->set_rules('nim', 'NIM', 'trim|required');
		$this->form_validation->set_rules('id_kelas', 'Class', 'trim|required');
		$this->form_validation->set_rules('angkatan', 'Generation', 'trim|required');
		$this->form_validation->set_rules('nama_wali', 'Guardian Parent', 'trim|required');
		$this->form_validation->set_rules('pekerjaan_wali', 'Guardian Job'."'".'s', 'trim|required');
		$this->form_validation->set_rules('pendidikan_wali', 'Parent'."'".'s Education', 'trim|required');
		$this->form_validation->set_rules('asal_daerah', 'Place of Origin', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			redirect('user/profilPerkuliahan');
		}
		$data = [
			'nim' => $this->input->post('nim'),
			'id_kelas' => $this->input->post('id_kelas'),
			'angkatan' => $this->input->post('angkatan'),
			'nama_wali' => $this->input->post('nama_wali'),
			'pekerjaan_wali' => $this->input->post('pekerjaan_wali'),
			'pendidikan_wali' => $this->input->post('pendidikan_wali'),
			'asal_daerah' => $this->input->post('asal_daerah')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('mahasiswa', $data);
		$this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">
			Congratulation! Your profile has been updated!
			</div>');
		redirect('user/profilPerkuliahan');
	}

	public function updateDosen()
	{
		$this->form_validation->set_rules('kode_dosen', 'Lecturer Code', 'trim|required');
		$this->form_validation->set_rules('nidn', 'NIDN', 'trim|required');
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			redirect('user/profilPerkuliahan');
		}
		$data = [
			'kode_dosen' => $this->input->post('kode_dosen'),
			'nidn' => $this->input->post('nidn'),
			'nip' => $this->input->post('nip')
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('dosen', $data);
		$this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">
			Congratulation! Your profile has been updated!
			</div>');
		redirect('user/profilPerkuliahan');
	}

	public function delete()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				The Password is required.
				</div>');
			redirect('user/edit');
		} else{
			$email = $this->session->userdata('email');
			$password = $this->input->post('password');

			$user = $this->db->get_where('user', ['email' => $email])->row_array();
			$id = $user['id'];

			if (password_verify($password, $user['password'])) {
				$this->db->delete('user', ['id' => $id]);
				redirect('auth/logout');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Wrong Password!
					</div>');
				redirect('user/edit');
			}
		}
	}

	public function changePassword()
	{
		$data['title'] = "Change Password";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('new_password2', 'Repeat New Password', 'trim|required|matches[new_password1]');
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/change_password', $data);
			$this->load->view('templates/footer');
		} else{
			$current_password = $this->input->post('current_password');
			$new_password1 = $this->input->post('new_password1');
			$new_password2 = $this->input->post('new_password2');
			if (!password_verify($current_password, $data['user']['password'])) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
			redirect('user/changePassword');
			} else{
				if ($current_password == $new_password1) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
					redirect('user/changePassword');
				} else{
					$password_hash = password_hash($new_password1, PASSWORD_DEFAULT);

					$this->db->set('password', $password_hash);
					$this->db->where('email', $this->session->userdata('email'));
					$this->db->update('user');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">password changed!</div>');
					redirect('user/changePassword');
				}
			}
		}
	}

	public function keamanan()
	{
		$data['title'] = "Keamanan";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['pertanyaan_keamanan'] = $this->db->get_where('pertanyaan_keamanan', ['id_user' => $data['user']['id']]);
		$data['pertanyaan_1'] = $this->db->get('pertanyaan_1')->result_array();
		$data['pertanyaan_2'] = $this->db->get('pertanyaan_2')->result_array();
		$this->form_validation->set_rules('id_pertanyaan_1', 'Question 1', 'trim|required');
		$this->form_validation->set_rules('id_pertanyaan_2', 'Question 2', 'trim|required');
		$this->form_validation->set_rules('jawaban_1', 'Answer 1', 'trim|required');
		$this->form_validation->set_rules('jawaban_2', 'Answer 2', 'trim|required');
		if ($this->form_validation->run() ==  false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view("user/keamanan", $data);
			$this->load->view('templates/footer');
		} else{
			$num_pertanyaan = $this->db->get_where('pertanyaan_keamanan', ['id_user' => $data['user']['id']])->num_rows();
			if ($num_pertanyaan > 0) {
				$value = [
					'id_pertanyaan_1' => $this->input->post('id_pertanyaan_1'),
					'jawaban_1' => $this->input->post('jawaban_1'),
					'id_pertanyaan_2' => $this->input->post('id_pertanyaan_2'),
					'jawaban_2' => $this->input->post('jawaban_2')
				];
				$this->db->where('id_user', $data['user']['id']);
				$this->db->update('pertanyaan_keamanan', $value);
			} else{
				$value = [
					'id_user' => $data['user']['id'],
					'id_pertanyaan_1' => $this->input->post('id_pertanyaan_1'),
					'jawaban_1' => $this->input->post('jawaban_1'),
					'id_pertanyaan_2' => $this->input->post('id_pertanyaan_2'),
					'jawaban_2' => $this->input->post('jawaban_2')
				];
				$this->db->insert('pertanyaan_keamanan', $value);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Security Updated!</div>');
			redirect('user/keamanan');
		}
	}

}