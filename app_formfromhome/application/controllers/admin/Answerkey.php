<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answerkey extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'answerkeyListing';
        $data['pageTitle'] = 'answer key list';
        $data['pl'] = 'add-answer-key';
        $data['drawTable'] = $this->answerkeyTableHead();
        $this->parsed('admin/answerkey/index', $data);
	}

	public function answerkeyTableHead(){
      	$tableHead = array(
					0 => 'sr. no.',
					1 => 'answer key name',
					2 => 'link',
					4 => 'action'
  		);
      return $tableHead;
    }

  public function showAnswerkey(){
      $json_data = $this->answerkey_m->showAnswerkey();
      echo json_encode($json_data);
  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->answerkey_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add answer key';
				$this->view('admin/answerkey/add', $this->data);
			} else {
				$data = array(
							'answer_key_name' => $post['answer_key'],
							'link' => $post['link']
						);

				$data = $this->toLowerCase($data);
				$this->answerkey_m->add($data, null);
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
								'title' => 'Answer Key.',
								'description' => 'A new answer key is created.'
							);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'answer key is added.');
				redirect('view-answer-key');
			}
		}
		else{
			$this->data['page_title'] = 'add answer key';
			$this->view('admin/answerkey/add', $this->data);
		}
	}

	public function edit($answerKeyId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->answerkey_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['answerKeyId'] = $answerKeyId;
				$answerKeyId = $this->outh_model->Encryptor('decrypt', $answerKeyId);
				$this->data['answer_key'] = $this->get_an_obj_by_id('answer_key', 'answer_key_id', $answerKeyId);
				$this->data['page_title'] = 'edit answer key';
				$this->view('admin/answerkey/edit', $this->data);
			} else {
				$answerKeyId = $this->outh_model->Encryptor('decrypt', $answerKeyId);
				$data = array(
							'answer_key_name' => $post['answer_key'],
							'link' => $post['link']
						);
				
				$data = $this->toLowerCase($data);
				$this->answerkey_m->add($data, $answerKeyId);
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
							'title' => 'answer key updated.',
							'description' => 'An answer key is updated.'
						);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'answer key is updated.');
				redirect('view-answer-key');
		}
		}
		else{
			$this->data['answerKeyId'] = $answerKeyId;
			$answerKeyId = $this->outh_model->Encryptor('decrypt', $answerKeyId);
			$this->data['answer_key'] = $this->get_an_obj_by_id('answer_key', 'answer_key_id', $answerKeyId);
			$this->data['page_title'] = 'edit answer key';
			$this->view('admin/answerkey/edit', $this->data);
		}
	}

	public function delete($answerKeyId){
		$answerKeyId = $this->outh_model->Encryptor('decrypt', $answerKeyId);
		$this->db->where('answer_key_id', $answerKeyId);
		$this->db->delete('answer_key');
		$this->session->set_flashdata('notification', 'answer key is deleted successfully.');
		redirect('view-answer-key');
	}



//CLASS ENDS
}
