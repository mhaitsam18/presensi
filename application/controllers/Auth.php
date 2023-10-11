<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		} elseif ($this->session->userdata('form')) {
			if ($this->session->userdata('role') == 'mahasiswa') {
				redirect('auth/formMahasiswa');
			} elseif ($this->session->userdata('role') == 'dosen') {
				redirect('auth/formDosen');
			}
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'WPU User Log In';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else{
			$this->_login();
		}
	}
	
	public function activated($id, $is_active)
	{
		$this->db->where('id', $id);
		$this->db->update('user', ['is_active' => $is_active]);
		if ($is_active == 1) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Akun telah diaktifkan
				</div>');
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Akun telah dinonaktifkan
				</div>');
		}
		redirect('Admin/dataUser');
	}

	public function registration()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		} elseif ($this->session->userdata('form')) {
			if ($this->session->userdata('role') == 'mahasiswa') {
				redirect('auth/formMahasiswa');
			} elseif ($this->session->userdata('role') == 'dosen') {
				redirect('auth/formDosen');
			}
		}
		$this->db->where_not_in('id', 1);
		$data['user_role'] = $this->db->get('user_role')->result_array();
		$this->form_validation->set_rules('name','Name', 'required|trim');
		$this->form_validation->set_rules('email','Email', 'required|trim|valid_email|is_unique[user.email]',[
			'is_unique' => 'this email has already registered!'
		]);
		$this->form_validation->set_rules('password1','Password', 'required|trim|min_length[3]', [
			'matches' => 'password dont match!',
			'min_length' => 'password too short!'
		]);
		$this->form_validation->set_rules('role_id','Role', 'required|trim');
		$this->form_validation->set_rules('gender','Gander', 'required|trim');
		$this->form_validation->set_rules('place_of_birth','Place of Birth', 'required|trim');
		$this->form_validation->set_rules('birthday','Birth Day', 'required|trim');
		$this->form_validation->set_rules('phone_number','Phone Number', 'required|trim');
		$this->form_validation->set_rules('address','Address', 'required|trim');
		$this->form_validation->set_rules('religion_id','Religion', 'required|trim');
		// 
		$this->form_validation->set_rules('password2','Confrim Password', 'required|trim|matches[password1]');
		$data['agama'] = $this->db->get('agama')->result_array();
		if ($this->form_validation->run() == false) {
			$data['title'] = 'WPU User Registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration', $data);
			$this->load->view('templates/auth_footer');
		} else{
			$data =[
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'gender' => htmlspecialchars($this->input->post('gender', true)),
				'place_of_birth' => htmlspecialchars($this->input->post('place_of_birth', true)),
				'birthday' => htmlspecialchars($this->input->post('birthday', true)),
				'phone_number' => htmlspecialchars($this->input->post('phone_number', true)),
				'address' => htmlspecialchars($this->input->post('address', true)),
				'religion_id' => htmlspecialchars($this->input->post('religion_id', true)),
				'image' => 'default.svg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => htmlspecialchars($this->input->post('role_id', true)),
				'is_active' => 1,
				'date_created' => time(),
			];

			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $this->input->post('email', true),
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);

			// $this->_sendEmail($token, 'verify');

			$user = $this->db->get_where('user', ['email' => $this->input->post('email', true)])->row_array();
			if ($this->input->post('role_id') == 3) {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! Your account has been created, please complete your profile!
					</div>');
				$data = [
					'form' => $user['id'],
					'role' => 'mahasiswa'
				];
				$this->session->set_userdata($data);
				redirect('auth/formMahasiswa');
			} elseif ($this->input->post('role_id') == 4 || $this->input->post('role_id') == 5) {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! Your account has been created, please complete your profile!
					</div>');
				$data = [
					'form' => $user['id'],
					'role' => 'dosen'
				];
				$this->session->set_userdata($data);
				redirect('auth/formDosen');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! Your account has been created, check your email! please activate!
					</div>');
				redirect('auth');
			}
		}
	}

	public function formMahasiswa()
	{
		if (!$this->session->userdata('form')) {
			redirect('auth');
		} elseif ($this->session->userdata('role') == 'dosen') {
			redirect('auth/formDosen');
		}
		$this->form_validation->set_rules('nim','NIM', 'required|trim');
		$this->form_validation->set_rules('id_kelas','id_kelas', 'required|trim');
		$this->form_validation->set_rules('angkatan','Generation', 'required|trim');
		$this->form_validation->set_rules('nama_wali','Generation', 'required|trim');
		$this->form_validation->set_rules('pekerjaan_wali','Generation', 'required|trim');
		$this->form_validation->set_rules('asal_daerah','Generation', 'required|trim');
		$data['kelas'] = $this->db->get('kelas')->result_array();
		$data['pendidikan'] = $this->db->get('pendidikan')->result_array();
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Student Registration Page';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/form-mahasiswa', $data);
			$this->load->view('templates/auth_footer');
		} else{
			$data =[
				'id_user' => htmlspecialchars($this->input->post('id_user', true)),
				'nim' => htmlspecialchars($this->input->post('nim', true)),
				'id_kelas' => htmlspecialchars($this->input->post('id_kelas', true)),
				'angkatan' => htmlspecialchars($this->input->post('angkatan', true)),
				'nama_wali' => htmlspecialchars($this->input->post('nama_wali', true)),
				'pekerjaan_wali' => htmlspecialchars($this->input->post('pekerjaan_wali', true)),
				'pendidikan_wali' => htmlspecialchars($this->input->post('pendidikan_wali', true)),
				'asal_daerah' => htmlspecialchars($this->input->post('asal_daerah', true)),
				'id_status' => 1
			];
			$this->db->insert('mahasiswa', $data);
			$mahasiswa = $this->db->get_where('mahasiswa', ['id_user' => $this->input->post('id_user', true)])->row_array();
			$data2 = [
				'id_mahasiswa' => $mahasiswa['id'],
				'ipk' => 0,
				'tak' => 0,
			];
			$this->db->insert('nilai_mahasiswa', $data2);
			$this->db->order_by('id', 'DESC');
			$nilai_mahasiswa = $this->db->get('nilai_mahasiswa', 1)->row_array();
			$id_nilai_mahasiswa = $nilai_mahasiswa['id']; 

			$smt = 1;
			while ($smt <= 6) {
				$data3 = [
					'id_nilai_mahasiswa' => $id_nilai_mahasiswa,
					'semester' => $smt,
					'ip' => 0,
					'ipk' => 0
				];
				$this->db->insert('ip_semester', $data3);
				$smt++;
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulation! Your account has been created, check your email! please activate!
				</div>');
			$this->session->unset_userdata('form');
			$this->session->unset_userdata('role');
			redirect('auth');
		}
	}

	public function formDosen()
	{
		if (!$this->session->userdata('form')) {
			redirect('auth');
		} elseif ($this->session->userdata('role') == 'mahasiswa') {
			redirect('auth/formMahasiswa');
		}
		$this->form_validation->set_rules('kode_dosen','Lecturer Code', 'required|trim');
		$this->form_validation->set_rules('nidn','NIDN', 'required|trim');
		$this->form_validation->set_rules('nip','NIP', 'required|trim');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Lecturer Registration Page';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/form-dosen', $data);
			$this->load->view('templates/auth_footer');
		} else{
			$data =[
				'id_user' => htmlspecialchars($this->input->post('id_user', true)),
				'kode_dosen' => htmlspecialchars($this->input->post('kode_dosen', true)),
				'nidn' => htmlspecialchars($this->input->post('nidn', true)),
				'nip' => htmlspecialchars($this->input->post('nip', true))
			];
			$this->db->insert('dosen', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Congratulation! Your account has been created, check your email! please activate!
				</div>');
			$this->session->unset_userdata('form');
			$this->session->unset_userdata('role');
			redirect('auth');
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'obamaresidenci65@gmail.com',
			'smtp_pass' => 'F1rm@n01',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'chatset' => 'utf-8',
			'newline' => "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config); 
		$this->email->from('obamaresidenci65@gmail.com', 'Obama Residence');
		$this->email->to($this->input->post('email'));
		if ($type== 'verify') {
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="'.base_url('auth/verify?email=').$this->input->post('email').'&token='.urlencode($token).'">Activate</a>');
		} elseif($type== 'forgot'){
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password : <a href="'.base_url('auth/resetPassword?email=').$this->input->post('email').'&token='.urlencode($token).'">Reset Password</a>');
		}
		if ($this->email->send()) {
			return true;
		} else{
			echo $this->email->print_debugger();
			die;
		}

	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			if ($user['is_active']!=1) {
				$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
				if ($user_token) {
					if (time() - $user_token['date_created'] < (60*60*24)) {
						$this->db->set('is_active', 1);
						$this->db->where('email', $email);
						$this->db->update('user');
						$this->db->delete('user_token',['email' => $email]);
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
						'.$email.' has been activated. Please Login!
						</div>');
						redirect('auth');
					} else{
						$this->db->delete('user',['email' => $email]);
						$this->db->delete('user_token',['email' => $email]);
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						Account activation failed: Token Expired!
						</div>');
						redirect('auth');
					}
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Account activation failed: Invalid Token!
					</div>');
					redirect('auth');
				}
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
				Your account has been activated!
				</div>');
				redirect('auth');
			}
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Account activation failed: Wrong Email!
			</div>');
			redirect('auth');
		}
	}

	private function _login()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		} elseif ($this->session->userdata('form')) {
			if ($this->session->userdata('role') == 'mahasiswa') {
				redirect('auth/formMahasiswa');
			} elseif ($this->session->userdata('role') == 'dosen') {
				redirect('auth/formDosen');
			}
		}
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			if ($user['is_active'] ==  1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];
					$this->session->set_userdata($data);
					if ($user['role_id'==1]) {
						redirect('admin');
					} else{
						redirect('user');
					}
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						Wrong password!
						</div>');
					redirect('auth');

				}
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					This email has not been activated!
					</div>');
				redirect('auth');
			}
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Email is not registered!
				</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			You have been log out
			</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}

	public function notFound()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title'] = "Error 404 Page not Found";
		$this->load->view('auth/page-not-found', $data);
	}

	public function forgotPassword()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		} elseif ($this->session->userdata('form')) {
			if ($this->session->userdata('role') == 'mahasiswa') {
				redirect('auth/formMahasiswa');
			} elseif ($this->session->userdata('role') == 'dosen') {
				redirect('auth/formDosen');
			}
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'forgotPassword';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		} else{
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Please check your email to reset password!
					</div>');
					redirect('auth/forgotPassword');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Email is not registered!
					</div>');
					redirect('auth/forgotPassword');
			}
		}
	}

	public function forgotPassword2()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		} elseif ($this->session->userdata('form')) {
			if ($this->session->userdata('role') == 'mahasiswa') {
				redirect('auth/formMahasiswa');
			} elseif ($this->session->userdata('role') == 'dosen') {
				redirect('auth/formDosen');
			}
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password-2');
			$this->load->view('templates/auth_footer');
		} else{
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
			if ($user) {
				$pertanyaan_keamanan = $this->db->get_where('pertanyaan_keamanan', ['id_user' => $user['id']])->row_array();
				if ($pertanyaan_keamanan) {
					redirect('auth/question/'.$pertanyaan_keamanan['id']);
				} else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						Akun Anda tidak dilengkapi dengan pertanyaan keamanan!
						</div>');	
					redirect('auth/forgotPassword2');
				}
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Email is not registered or not verified!
					</div>');
					redirect('auth/forgotPassword2');
			}
		}
	}

	public function question($id='')
	{
		$this->db->select('*, pertanyaan_1.pertanyaan AS p1, pertanyaan_2.pertanyaan AS p2, pertanyaan_keamanan.id AS pid');
		$this->db->join('pertanyaan_1', 'pertanyaan_1.id = pertanyaan_keamanan.id_pertanyaan_1');
		$this->db->join('pertanyaan_2', 'pertanyaan_2.id = pertanyaan_keamanan.id_pertanyaan_2');
		$data['pertanyaan_keamanan'] = $this->db->get_where('pertanyaan_keamanan', ['pertanyaan_keamanan.id' => $id])->row_array();
		$data['user'] = $this->db->get_where('user', ['id' => $data['pertanyaan_keamanan']['id_user']])->row_array();
		$this->form_validation->set_rules('jawaban_1', 'Answer 1', 'trim|required');
		$this->form_validation->set_rules('jawaban_2', 'Answer 2', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/question', $data);
			$this->load->view('templates/auth_footer', $data);
		} else{
			$check_answer = $this->db->get_where('pertanyaan_keamanan', [
				'id' => $id,
				'jawaban_1' => $this->input->post('jawaban_1'),
				'jawaban_2' => $this->input->post('jawaban_2'),
			])->num_rows();
			if ($check_answer>0) {
				$this->session->set_userdata('reset_email', $data['user']['email']);
				redirect('auth/changePassword');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Maaf, Jawaban Anda tidak sesuai, silahkan Coba lagi!
					</div>');	
				redirect('auth/question/'.$id);
			}

		}

	}
	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				if (time() - $user_token['date_created'] < (60*60*24)) {
					$this->session->set_userdata('reset_email', $email);
					$this->changePassword();
				} else{
					$this->db->delete('user_token',['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Reset Password failed: Token Expired!
					</div>');
					redirect('auth');
				}
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Reset Password failed: Invalid Token!
				</div>');
				redirect('auth');
			}
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Reset Password failed: Wrong email!
			</div>');
			redirect('auth');
		}
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}
		$this->form_validation->set_rules('password1','Password', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('password2','Confrim Password', 'required|trim|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'change Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		} else{
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');
			$this->session->unset_userdata('reset_email');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Password has been change! Please login!
			</div>');
			redirect('auth');
		}
	}

	public function test($value)
	{
		echo $value;
	}
	
}
