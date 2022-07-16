<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'resultListing';
        $data['pageTitle'] = 'result list';
        $data['pl'] = 'add-result';
        $data['drawTable'] = $this->resultTableHead();
        $this->parsed('admin/result/index', $data);
	}

	public function resultTableHead(){
      	$tableHead = array(
					'srno' => 'sr. no.',
					'result name' => 'result name',
					'link' => 'link',
					'action' => 'action'
  		);
      return $tableHead;
    }

  public function showResult(){
      $json_data = $this->result_m->getAllResult();
      echo json_encode($json_data);
  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->result_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add result';
				$this->view('admin/result/add', $this->data);
			} else {
				$data = array(
							'result_name' => $post['result_name'],
							'link' => $post['link']

						);
				$data = $this->toLowerCase($data);
				$this->result_m->add($data, null);
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
				'title' => 'Result Added.',
				'description' => 'A new result is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'result is added.');
				redirect('view-result');
		}
		}
		else{
			$this->data['page_title'] = 'add result';
			$this->view('admin/result/add', $this->data);
		}
	}

	public function edit($resultId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->result_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['resultId'] = $resultId;
				$resultId = $this->outh_model->Encryptor('decrypt', $resultId);
				$this->data['result'] = $this->get_an_obj_by_id('result', 'result_id', $resultId);
				$this->data['page_title'] = 'edit state';
				$this->view('admin/result/edit', $this->data);
			} else {
				$resultId = $this->outh_model->Encryptor('decrypt', $resultId);
				$data = array(
							'result_name' => $post['result_name'],
							'link' => $post['link']
						);
				
				$data = $this->toLowerCase($data);
				$this->result_m->add($data, $resultId);
				$date = date('d/m/Y');
				$currentMonth = date('F');
				$currentYear = date('Y');
				$time = date('H:i:s');
				$log =	array(
							'date' => $date,
							'time'=>	$time,
							'month'	=>	$currentMonth,
							'year'	=>	$currentYear,
							'user_id' => $this->user_id,
							'title' => 'result updated.',
							'description' => 'A result is updated.'
						);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'result is updated.');
				redirect('view-result');
		}
		}
		else{
			$this->data['resultId'] = $resultId;
			$resultId = $this->outh_model->Encryptor('decrypt', $resultId);
			$this->data['result'] = $this->get_an_obj_by_id('result', 'result_id', $resultId);
			$this->data['page_title'] = 'edit result';
			$this->view('admin/result/edit', $this->data);
		}
	}

	public function delete($resultId){
		$resultId = $this->outh_model->Encryptor('decrypt', $resultId);
		$this->db->where('result_id', $resultId);
		$this->db->delete('result');
		$this->session->set_flashdata('notification', 'result is deleted successfully.');
		redirect('view-result');
	}



//CLASS ENDS
}
