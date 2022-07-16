<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admitcard extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'admitcardListing';
        $data['pageTitle'] = 'admit card list';
        $data['pl'] = 'add-admit-card';
        $data['drawTable'] = $this->admitCardTableHead();
        $this->parsed('admin/admitcard/index', $data);
	}

	public function admitCardTableHead(){
      	$tableHead = array(
					0 => 'sr. no.',
					1 => 'admit card name',
					2 => 'link',
					4 => 'action'
  		);
      return $tableHead;
    }

  public function showAdmitcard(){
      $json_data = $this->admitcard_m->showAdmitcard();
      echo json_encode($json_data);
  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->admitcard_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add admit card';
				$this->view('admin/admitcard/add', $this->data);
			} else {
				$data = array(
							'admit_card_name' => $post['admit_card'],
							'link' => $post['link']
						);

				$data = $this->toLowerCase($data);
				$this->admitcard_m->add($data, null);
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
									'title' => 'Admit Card.',
									'description' => 'A new admit card is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->send_push_notification($post['admit_card']);
				$this->session->set_flashdata('notification', 'admit card is added.');
				redirect('view-admit-card');
		}
		}
		else{
			$this->data['page_title'] = 'add admit card';
			$this->view('admin/admitcard/add', $this->data);
		}
	}

	public function edit($admitCardId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->admitcard_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['admitCardId'] = $admitCardId;
				$admitCardId = $this->outh_model->Encryptor('decrypt', $admitCardId);
				$this->data['admit_card'] = $this->get_an_obj_by_id('admitcard', 'admit_card_id', $admitCardId);
				$this->data['page_title'] = 'edit admit card';
				$this->view('admin/admitcard/edit', $this->data);
			} else {
				$admitCardId = $this->outh_model->Encryptor('decrypt', $admitCardId);
				$data = array(
							'admit_card_name' => $post['admit_card'],
							'link' => $post['link']
						);
				
				$data = $this->toLowerCase($data);
				$this->admitcard_m->add($data, $admitCardId);
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
							'title' => 'admit card updated.',
							'description' => 'A admit card is updated.'
						);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'admit card is updated.');
				redirect('view-admit-card');
		}
		}
		else{
			$this->data['admitCardId'] = $admitCardId;
			$admitCardId = $this->outh_model->Encryptor('decrypt', $admitCardId);
			$this->data['admit_card'] = $this->get_an_obj_by_id('admitcard', 'admit_card_id', $admitCardId);
			$this->data['page_title'] = 'edit admit card';
			$this->view('admin/admitcard/edit', $this->data);
		}
	}

	public function delete($admitCardId){
		$admitCardId = $this->outh_model->Encryptor('decrypt', $admitCardId);
		$this->db->where('admit_card_id', $admitCardId);
		$this->db->delete('admitcard');
		$this->session->set_flashdata('notification', 'admit card is deleted successfully.');
		redirect('view-admit-card');
	}


	public function send_push_notification($name_of_admit_card){
		$content = $name_of_admit_card.'. Check if that is yours.';


		$content = array(
			"en" => $content
		);
		$headings = array(
			"en" => 'A new admit card is available.'
		);
	
		$one_signal_app_id = get_settings('onesignal_app_id');

		$fields = array(
			'app_id' => $one_signal_app_id,
			'headings' => $headings,
			'contents' => $content,
  			"included_segments" => ["Subscribed Users"]
		);
	
		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic ODE0YzcyZjUtZDcwYS00MDEzLTgxNWQtZGJhMTczZTNlZjkz'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
	
		$response = curl_exec($ch);
		curl_close($ch);
	
		// print_r($response);
		return $response;
	}

//CLASS ENDS
}
