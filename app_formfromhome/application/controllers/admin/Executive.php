<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Executive extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'executiveListing';
        $data['pageTitle'] = 'executive list';
        $data['pl'] = 'add-user-executive';
        $data['drawTable'] = $this->executiveTableHead();
        $this->parsed('admin/executive/index', $data);
	}

	public function executiveTableHead()
    {
      	$tableHead = array(
					'srno' => 'sr. no.',
					'executive name' => 'executive name',
					'mobile no' => 'mobile no',
					'email' => 'email',
					'action' => 'action'
  		);
      return $tableHead;
    }

    public function showExecutive(){
        $json_data = $this->executive_m->getAllExecutive();
        echo json_encode($json_data);
    }


	public function add()
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->executive_m->rules);
			$this->form_validation->set_message('alpha_numeric_space', 'only alphanumeric values are allowed.');
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add executive';
				$this->view('admin/executive/add', $this->data);
			} else {
				$hashedPwd = password_hash($post['mobile'], PASSWORD_DEFAULT);
				$data = array(
							'name' => strtolower($post['executive_name']),
							'user_name' => $post['email'],
							'role_id' => 2,
							'mobile' => $post['mobile'],
							'user_auth_pwd' => $hashedPwd,
							'status' => 1,
						);
				$this->executive_m->add($data, null);
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
									'title' => 'executive added.',
									'description' => 'A new executive is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'Executive is added.');
				redirect('add-user-executive');
			}
		}
		else{
			$this->data['page_title'] = 'add executive';
			$this->view('admin/executive/add', $this->data);
		}
	}

	public function edit($exe)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->executive_m->rules);
			$this->form_validation->set_message('alpha_numeric_space', 'only alphanumeric values are allowed.');
			if ($this->form_validation->run() == FALSE) {
				$this->data['exe'] = $exe;
				$exeId = $this->outh_model->Encryptor('decrypt', $exe);
				$this->data['exeObj'] = $this->get_an_obj_by_id('user_auth_detail', 'user_auth_id', $exeId);
				$this->data['page_title'] = 'edit executive';
				$this->view('admin/executive/edit', $this->data);
			} else {
				$data = array(
							'name' => strtolower($post['executive_name']),
							'user_name' => $post['email'],
							'mobile' => $post['mobile']
						);
				$exeId = $this->outh_model->Encryptor('decrypt', $exe);
				$this->executive_m->add($data, $exeId);
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
									'title' => 'executive updated.',
									'description' => 'An executive is updated.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);

				$this->session->set_flashdata('notification', 'Executive is Updated.');
				redirect('executive-listing');
			}
		}
		else{
			$this->data['exe'] = $exe;
			$exeId = $this->outh_model->Encryptor('decrypt', $exe);
			$this->data['exeObj'] = $this->get_an_obj_by_id('user_auth_detail', 'user_auth_id', $exeId);
			$this->data['page_title'] = 'edit executive';
			$this->view('admin/executive/edit', $this->data);
		}
	}

	public function active($executive_id){
		$decrypted_id = $this->outh_model->Encryptor('decrypt', $executive_id);
        $this->executive_m->active($decrypted_id);
        redirect('executive-listing');
    }

    public function inactive($executive_id){
    	$decrypted_id = $this->outh_model->Encryptor('decrypt', $executive_id);
        $this->executive_m->inactive($decrypted_id);
        redirect('executive-listing');
    }

}

/* End of file Executive.php */
/* Location: ./application/controllers/admin/Executive.php */
