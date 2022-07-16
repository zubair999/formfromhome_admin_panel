<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		// $this->load->helper('app_helper');
	}

	public function index(){
		$data['tableId'] = 'stateListing';
        $data['pageTitle'] = 'state list';
        $data['pl'] = 'add-state';
        $data['drawTable'] = $this->stateTableHead();
        $this->parsed('admin/state/index', $data);
	}

	public function stateTableHead()
    {
      	$tableHead = array(
					'srno' => 'sr. no.',
					'state name' => 'state name',
					'action' => 'action'
  		);
      return $tableHead;
    }

  public function showState(){
      $json_data = $this->state_m->getAllState();
      echo json_encode($json_data);
  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->state_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add state';
				$this->view('admin/state/add', $this->data);
			} else {
				$data = array(
							'state_name' => $post['state_name']
						);
				$data = $this->toLowerCase($data);
				$state_count	=	$this->state_m->duplicate('state',array('state_name'=>$post['state_name']));
				if($state_count > 0){
					$this->session->set_flashdata('notification', 'state is already added.');
					redirect('add-state');
				}else{
				$this->state_m->add($data, null);
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
                  'title' => 'state Added.',
                  'description' => 'A new state is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'state is added.');
				redirect('view-state');
			}
		}
		}
		else{
			$this->data['page_title'] = 'add state';
			$this->view('admin/state/add', $this->data);
		}
	}

	public function edit($stateId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->state_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['stateId'] = $stateId;
				$stateId = $this->outh_model->Encryptor('decrypt', $stateId);
				$this->data['state_name'] = $this->get_an_obj_by_id('state', 'state_id', $stateId)->state_name;
				$this->data['page_title'] = 'edit state';
				$this->view('admin/state/edit', $this->data);
			} else {
				$stateId = $this->outh_model->Encryptor('decrypt', $stateId);
				$data = array(
							'state_name' => $post['state_name']
						);
				$state_count	=	$this->state_m->duplicate('state',array('state_name'=>$post['state_name']));
				if($state_count > 0){
					$this->session->set_flashdata('notification', 'state is already added.');
					redirect('add-state');
				}else{
				$data = $this->toLowerCase($data);
				$this->state_m->add($data, $stateId);
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
									'title' => 'state updated.',
									'description' => 'A state is updated.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'state is updated.');
				redirect('view-state');
			}
		}
		}
		else{
			$this->data['stateId'] = $stateId;
			$stateId = $this->outh_model->Encryptor('decrypt', $stateId);
			$this->data['state_name'] = $this->get_an_obj_by_id('state', 'state_id', $stateId)->state_name;
			$this->data['page_title'] = 'edit state';
			$this->view('admin/state/edit', $this->data);
		}
	}


//CLASS ENDS
}

/* End of file Form.php */
/* Location: ./application/controllers/admin/Form.php */
