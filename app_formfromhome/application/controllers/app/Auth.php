<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function app_login(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$pt = $this->input->post();
			if($pt['submit1'] == 'Login'){
				$this->form_validation->set_rules($this->app_auth_m->rules);
				if($this->form_validation->run() == FALSE){
					$this->data['page_title'] = 'Student Login';
					$this->load->view('app/login/login', $this->data);
					$this->session->set_flashdata('notification', 'username & password required.');
				}
				else{
					// CHECK IF USER EXITS
					$userObj = $this->db->get_where('user_auth_detail', array('user_name'=> $pt['loginid']))->row();
					if($userObj->status == 0){
						$this->session->set_flashdata('notification', 'your are not registered. Register First.');
						redirect('app-login');
					}
					else{
						$hashed_pwd = $userObj->user_auth_pwd;
						$checked = password_verify($pt['pass'], $hashed_pwd);
						if($checked === true){
							$session = array(
								'verify_user_auth_id' => $userObj->user_auth_id,
								'verify_name' => $userObj->name,
								'verify_mobile' => $userObj->mobile,
								'verify_username' => $userObj->user_name,
								'verify_role_id' => $userObj->role_id,
								'verify_status' => $userObj->status
							);

							$this->session->set_userdata($session);
							redirect('app-root');
						}
						else{
							$this->session->set_flashdata('notification', 'username & password do not match');
							redirect('app-login');
						}
					}
				}
			}
			else{
				$this->session->set_flashdata('notification', 'action not allowed.');
				$this->data['page_title'] = 'Student Login';
				$this->load->view('app/login/login', $this->data);
			}
		}
		else{
			$this->data['page_title'] = 'Student Login';
			$this->load->view('app/login/login', $this->data);
		}
	}

	public function app_registration(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$pt = $this->input->post();
			if($pt['submit1'] == 'Register'){
				$this->form_validation->set_rules($this->app_auth_m->rules);
				if($this->form_validation->run() == FALSE){
					$this->data['page_title'] = 'Student Registration';
					$this->load->view('app/login/registration', $this->data);
				}
				else{
					// CHECK IF USER ALREADY EXISTS
					$mobile_count = $this->db->get_where('user_auth_detail', array('mobile'=>$pt['pass']))->num_rows();
					$user_name = $this->db->get_where('user_auth_detail', array('user_name'=>$pt['loginid']))->num_rows();
					if($mobile_count > 0 && $user_name > 0){
						$this->session->set_flashdata('notification', 'mobile no. & user name already taken.');
						redirect('register');
						exit();
					}
					elseif($mobile_count > 0){
						$this->session->set_flashdata('notification', 'mobile no. taken.');
						redirect('register');
						exit();
					}
					elseif($user_name > 0){
						$this->session->set_flashdata('notification', 'username already taken.');
						redirect('register');
						exit();
					}
					else{
						$hashed_pwd = password_hash($pt['pass'], PASSWORD_DEFAULT);
						$payload = array(
							'last_login' => time(),
							'iss'=> 'localhost',
							'expiry' => time() + (60),
							'user_name' => $pt['loginid']
						);

						$expiry = date("Y-m-d H:i:s",time());
						$last_login = date("Y-m-d H:i:s",time());

						$token = $this->encode($payload);
						$user_dtail = array(
									'user_name' => $pt['loginid'],
									'user_auth_pwd' => $hashed_pwd,
									'role_id' => 3,
									'token' => $token,
									'expiry' => $this->expiry,
									'last_login' => $this->current_time,
									'status'=> 0,
									'iss'=> 'localhost'
								);

						$response = $this->db->insert('user_auth_detail', $user_dtail);
						if($response === TRUE){
							$html = "
			                    <div style='background:#ddd;height:300px'>Thank you for registering. Click the link below to verfiy you account.
			                        <a href='".BASE_URL."verify-app/".$pt['loginid']."/".$token."'>Verify here.</a>
			                    </div>
			                ";

							$subject = "Complete your registration process.";

							$response = $this->sendEmail($html, $subject, $pt['loginid']);
							if($response === TRUE){
								$this->session->set_flashdata('notification', 'you are registered. check you email.');
								redirect('app-login');
							}
							elseif($response === FALSE){
								$this->session->set_flashdata('notification', 'something Went Wrong. try again.');
							}
							else {
								$this->session->set_flashdata('notification', 'something Went Wrong. try again.');
							}
						}
					}
				}
			}
			else{
				$this->data['page_title'] = 'Student Registration';
				$this->load->view('app/login/registration', $this->data);
			}
		}
		else{
			$this->data['page_title'] = 'Student Registration';
			$this->load->view('app/login/registration', $this->data);
		}
	}

	public function app_verification(){
		$email = $this->uri->segment(2);
		$token = $this->uri->segment(3);
		$user_obj = $this->get_an_obj_by_id('user_auth_detail', 'user_name', $email);
		if(!is_object($user_obj)){
			$this->session->set_flashdata('notification', 'something Went Wrong. try again.');
			$this->data['page_title'] = 'reset password';
			$this->load->view('app/login/verify', $this->data);
		}
		else{
			$token = $user_obj->token;
			$user_auth_id = $user_obj->user_auth_id;
			$data = $this->decode($token);
			$user_name = $data->user_name;
			$expiry = $data->expiry;
			if($email === $user_name){
				$data = array('status'=>1);
				$this->app_auth_m->add($data, $user_auth_id);
				$this->session->set_flashdata('notification', 'your account is verified.');
				$this->data['page_title'] = 'Form From Home';
				$this->load->view('app/login/verify', $this->data);
			}
			else{
				$this->session->set_flashdata('notification', 'something Went Wrong. try again.');
				$this->data['page_title'] = 'Form From Home';
				$this->load->view('app/login/verify', $this->data);
			}




		}
	}
	public function forget_password(){
		$this->data['page_title'] = 'Forget Password';
		$this->load->view('app/login/forget', $this->data);
	}

	public function reset_password(){
		if($this->input->post()){
			$mobileno = $this->input->post('mobileno');
			$this->form_validation->set_rules('mobileno', 'mobile', 'trim|required|numeric');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notification', 'Enter Correct Mobile No.');
				redirect('forget-password');
			}
			else{
				$student_count = $this->db->get_obj('user_auth_detail','mobile',array('mobile'=>$mobileno))->num_rows();
				if($student_count < 1){
					$this->session->set_flashdata('notification', 'You are not registered with FormFromHome. Kindly Register To Login.');
					redirect('register');
				}
				else{
					// GENERATING AND SENDING OTP TO THE USER.
					$otp = rand(100000, 999999);
			        $message = "Your one time OTP is: $otp. Do not share it to anyone.";
			        $this->smsalert->send($mobileno, $message);

			        // SAVING HASH OTP TO THE DATABASE.
			        $otp_hash = password_hash($otp, PASSWORD_DEFAULT);
			        $this->db->set('otp_hash',$otp_hash)
							 ->where('mobile',$mobileno)
					         ->update('user_auth_detail');
					$this->data['mobileno'] = $mobileno;
					$this->data['page_title'] = 'Enter Details';
					$this->load->view('app/login/reset',$this->data);
				}
			}
		}
		else{
			$this->session->set_flashdata('notification', 'Something went wrong');
			redirect('forget-password');
		}
	}

	public function confirm_password(){
		if($this->input->post()){
			$this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric');
			$this->form_validation->set_rules('newpass', 'newpass', 'trim|required');
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notification', 'Enter Correct Details.');
				$this->data['mobileno'] = $this->input->post('mobileno');
				$this->data['page_title'] = 'Enter Details';
				$this->load->view('app/login/reset',$this->data);
			}
			else{
				$mobileno = $this->input->post('mobileno');
				$newpass = $this->input->post('newpass');
				$hashed_otp = $this->db->get_obj('user_auth_detail','otp_hash',array('mobile'=>$mobileno))->row()->otp_hash;
				$otp = $this->input->post('otp');
				if(password_verify($otp, $hashed_otp)){
					$new_hash_pass = password_hash($newpass, PASSWORD_DEFAULT);
			        $this->db->set('user_auth_pwd',$new_hash_pass)
							 ->where('mobile',$mobileno)
					         ->update('user_auth_detail');
					$this->session->set_flashdata('notification', 'Password is reset now.');
					redirect('app-login');
				}
				else{
					$this->session->set_flashdata('notification', 'You have enter wrong OTP.');
					$this->data['mobileno'] = $this->input->post('mobileno');
					$this->data['page_title'] = 'Enter Details';
					$this->load->view('app/login/reset',$this->data);
				}
			}
		}
		else{
			$this->session->set_flashdata('notification', 'Something went wrong');
			redirect('reset-password');
		}
	}

	public function app_logout(){
		$this->session->sess_destroy();
		redirect('app-login');
	}

//CLASS ENDS
}
