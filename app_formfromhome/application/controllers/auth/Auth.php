<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
	}

	public function register_admin(){
		$this->data['page_title'] = 'form from home admin registration';
		$post = $this->input->post();
		$this->form_validation->set_rules('loginid', 'login id', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('pwd', 'password', 'trim|required|max_length[10]|alpha_numeric');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('auth/registration', $this->data);
		} else {
			//CHECKING IF ADMIN ALREADY REGISTRED
			$admin_count= $this->db->get_where('user_auth_detail',array('role_id'=>1))->num_rows();
			if($admin_count > 0){
				$this->session->set_flashdata('notification','admin already registered.');
				redirect(base_url('login-auth'));
			}else{
				$hashed_pwd = password_hash($post['pwd'], PASSWORD_DEFAULT);
				$payload = array(
							'last_login' => time(),
							'iss'=> 'localhost',
							'expiry' => time() + (60),
							'user_name' => $post['loginid']
						);

				$expiry = date("Y-m-d H:i:s",time());
				$last_login = date("Y-m-d H:i:s",time());

				$token = $this->encode($payload);
				$user_dtail = array(
							'user_name' => $post['loginid'],
							'user_auth_pwd' => $hashed_pwd,
							'role_id' => 1,
							'token' => $token,
							'expiry' => $this->expiry,
							'last_login' => $this->current_time,
							'status'=> 0,
							'iss'=> 'localhost'
						);

				$response = $this->db->insert('user_auth_detail', $user_dtail);
				if($response === TRUE){
					$html = "
	                    <div style='background:#ddd;height:300px;padding:50px;'>Thank you for registering.</br> Click the link below to verfiy you account.
	                        <a href='".BASE_URL."verify/?user=".$post['loginid']."&tokenkey=".$token."' target='_blank' shape='rect' rel='nofollow' style='color:#333'>Verify here.</a>
													</br>
													</br>
													<p>Thank You.</p>
	                    </div>
	                ";

	        $subject = "Complete Registration Process";

					$response = $this->sendEmail($html, $subject,$post['loginid']);
					if($response === TRUE){
						$this->session->set_flashdata('notification', 'you are registered. check you email.');
						redirect(base_url());
					}
					elseif($response === FALSE){
						$this->session->set_flashdata('notification', 'something Went Wrong. try again.');
					}
				}
				$this->load->view('auth/registration', $this->data);
			}
		}
	}

	public function secure_user_verification(){
		$get = $this->input->get();
		$getuser = $get['user'];
		$gettoken = $get['tokenkey'];

		$token = $this->decode($gettoken);
		$actual_user_name = $token->user_name;

		if($getuser == $actual_user_name){
			$this->db->set('status', 1);
			$this->db->where('user_name', $actual_user_name);
			$this->db->update('user_auth_detail');
			redirect('login-auth');
		}
		else{
			echo "invalid user";
		}
	}


	public function secure_user_login_authorization(){
		$this->data['page_title'] = 'login panel';
		$post = $this->input->post();
		$this->form_validation->set_rules('loginid', 'login id', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('pwd', 'password', 'trim|required|max_length[10]|alpha_numeric');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login', $this->data);
		} elseif($this->form_validation->run() == TRUE) {
			$response = $this->auth_m->authenticate_user($post['loginid'], $post['pwd']);

			if($response === FALSE){
				$this->session->set_flashdata('notification', 'username and password do not match.');
				$this->load->view('auth/login', $this->data);
			}
			if($response === 403){
				$this->session->set_flashdata('notification', 'account verification pending. please verify your account.');
				$this->load->view('auth/login', $this->data);
			}
			if($response === TRUE){
				$cookie = array(
                        'name'   => 'remember_me',
                        'value'  => 'test',
                        'expire' => '300',
                        'secure' => TRUE
                        );
        $this->input->set_cookie($cookie);
				redirect('f3-dashboard');
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('login-auth');
	}

	public function reset_password(){
			if($this->input->post('submit1')){
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$pt = $this->input->post();
					$this->form_validation->set_rules('pass', 'new password','required|max_length[10]');
					// $this->form_validation->set_rules($this->auth_m->rules1);
					if($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('notification', 'new password required.');
						$this->data['page_title']	=	'reset password';
						$this->view('auth/resetpassword', $this->data);
					}
					else{
						$hashedPwd = password_hash($pt['pass'], PASSWORD_DEFAULT);
						$this->db->set('user_auth_pwd', $hashedPwd);
						$this->db->where('user_name', $this->user_name);
						$this->db->update('user_auth_detail');
						$date = date('d/m/Y');
						$currentMonth = date('F');
						$currentYear = date('Y');
						$time = date('H:i:s');
						$log	=	array(
											'date' => $date,
											'time'=>	$time,
											'month'	=>	$currentMonth,
											'year'	=>	$currentYear,
											'user_id' => $this->user_id,
											'title' => 'password updated.',
											'description' => 'A password is updated.'
										);
						$logdata = $this->toLowerCase($log);
						$this->db->insert('logs',$logdata);
						$this->session->set_flashdata('notification', 'password changed successfully.');
						redirect('reset-password');
					}
				}
			}
			else{
					$this->data['page_title']	=	'reset password';
					$this->view('auth/resetpassword', $this->data);
			}
	}

		public function passwordedit($id){

			if($this->input->post('submit1')){
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$pt = $this->input->post();
					$this->form_validation->set_rules($this->auth_m->rules1);
					if($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('notification', 'new password required.');
						$this->data['id'] = $id;
						$this->data['page_title']	=	'reset password (executive)';
						$this->view('auth/admin-resetpassword-executive', $this->data);
					}
					else{
						$exeId = $this->outh_model->Encryptor('decrypt', $id);
						$this->data['id'] = $id;
						$hashedPwd = password_hash($pt['pass'], PASSWORD_DEFAULT);
						$this->db->set('user_auth_pwd', $hashedPwd);
						$this->db->where('user_auth_id', $exeId);
						$this->db->update('user_auth_detail');
						$date = date('d/m/Y');
						$currentMonth = date('F');
						$currentYear = date('Y');
						$time = date('H:i:s');
						$log	=	array(
											'date' => $date,
											'time'=>	$time,
											'month'	=>	$currentMonth,
											'year'	=>	$currentYear,
											'user_id' => $this->user_id,
											'title' => 'executive password updated.',
											'description' => 'A executive password is updated.'
										);
						$logdata = $this->toLowerCase($log);
						$this->db->insert('logs',$logdata);
						$this->session->set_flashdata('notification', 'password changed successfully.');
						redirect('executive-listing');
					}
				}
			}
			else{
				$this->data['id'] = $id;
				$this->data['page_title']	=	'reset password (executive)';
				$this->view('auth/admin-resetpassword-executive', $this->data);
			}
		}

		public function forgot_password(){
			if($this->input->post('submit1')){
				$this->form_validation->set_rules('loginid', 'email', 'trim|required');
				if($this->form_validation->run() == FALSE){
					$this->data['page_title'] = 'forget';
					$this->load->view('auth/forget', $this->data);
				}
				else{
					$email = $this->input->post('loginid');
					$user_obj = $this->get_an_obj_by_id('user_auth_detail', 'user_name', $email);
					$role_id = $user_obj->role_id;
					$user_auth_id = $user_obj->user_auth_id;
					if($role_id != 1){
						$this->session->set_flashdata('notification', 'only admin can reset password here.');
						$this->data['page_title'] = 'forget';
						$this->load->view('auth/forget', $this->data);
					}
					else{
						$payload = array(
							'expiry' => $this->expiry,
							'user_name' => $email
						);
						$token = $this->encode($payload);
						$data = array(
							'token'=> $token,
							'expiry'=> $this->expiry
						);
						$response = $this->auth_m->add($data, $user_auth_id);
						if($response === true){
							$email_template = "
													<div style='background:#ddd;height:300px'>Click the link below to reset your account.
															<a href='".BASE_URL."verify-user/".$email."/".$token."'>Reset Link.</a>
													</div>
											";
							$subject = "Reset Your Form From Home Account Password.";
							$response = $this->sendEmail($email_template, $subject, $email);
							if($response === true){
								$this->session->set_flashdata('notification', 'A reset link is sent to your email account. please verify.');
								$this->data['page_title'] = 'forget';
								$this->load->view('auth/forget', $this->data);
							}
							else{
								$this->session->set_flashdata('notification', 'something went wrong.');
								$this->data['page_title'] = 'forget';
								$this->load->view('auth/forget', $this->data);
							}
						}
						else{
							$this->session->set_flashdata('notification', 'something went wrong.');
							$this->data['page_title'] = 'forget';
							$this->load->view('auth/forget', $this->data);
						}
					}
				}
			}
			else{
				$this->data['page_title'] = 'forget';
				$this->load->view('auth/forget', $this->data);
			}
		}

		public function verify_user(){
			$email = $this->uri->segment(2);
			$token = $this->uri->segment(3);
			$user_obj = $this->get_an_obj_by_id('user_auth_detail', 'user_name', $email);
			if(!is_object($user_obj)){
				redirect('login-auth');
			}
			else{
				$token = $user_obj->token;
				$user_auth_id = $user_obj->user_auth_id;
				$data = $this->decode($token);
				$user_name = $data->user_name;
				$expiry = $data->expiry;

				if($this->input->post('submit1')){
					$this->form_validation->set_rules('pass', 'new password', 'trim|required');
					if($this->form_validation->run() == FALSE){
						$this->data['email'] = $email;
						$this->data['token'] = $token;
						$this->data['page_title'] = 'enter new password below';
						$this->load->view('auth/verify', $this->data);
					}
					else {
						if($email === $user_name){
							$newPwd = $this->input->post('pass');
							$hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);
							$data = array('user_auth_pwd'=> $hashedPwd);
							$this->auth_m->add($data, $user_auth_id);
							$this->session->set_flashdata('notification', 'password reset successfully.');
							redirect('login-auth');
						}
						else{
							$this->session->set_flashdata('notification', 'something went wrong.');
							redirect('login-auth');
						}
					}
				}
				else{
					if($email === $user_name){
						$this->data['email'] = $email;
						$this->data['token'] = $token;
						$this->data['page_title'] = "enter new password below";
						$this->load->view('auth/verify', $this->data);
					}
					else{
						redirect('login-auth');
					}
				}
			}
		}



//CLASS ENDS
}
