<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicecharges extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		// $this->load->helper('app_helper');
	}

	public function index(){
		$data['tableId'] = 'servicechargesListing';
        $data['pageTitle'] = 'service charges list';
        $data['pl'] = 'add-service-charges';
        $data['drawTable'] = $this->servicechargesTableHead();
        $this->parsed('admin/charges/index', $data);
	}

	public function servicechargesTableHead()
    {
      	$tableHead = array(
					'srno' => 'sr. no.',
					'service amount' => 'amount',
					'action' => 'action'
  		);
      return $tableHead;
    }

	  public function showservicecharges(){
	  	  $json_data = $this->charges_m->getAllservicecharges();
	      echo json_encode($json_data);
	  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->charges_m->rules);
			$this->form_validation->set_message('is_negative_numeric', 'only positive values allowed.');
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add service charges';
				$this->view('admin/charges/add', $this->data);
			} else {
				$data = array(
							'amount' => $post['amount']
						);
				$data = $this->toLowerCase($data);
				$this->charges_m->add($data, null);
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
									'title' => 'service charges Added.',
									'description' => 'A new service charges is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'service charges is added.');
				redirect('view-service-charges');
			}
		}
		else{
			$this->data['page_title'] = 'add service charges';
			$this->view('admin/charges/add', $this->data);
		}
	}

	public function edit($scId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->charges_m->rules);
			$this->form_validation->set_message('is_negative_numeric', 'only positive values allowed.');
			if ($this->form_validation->run() == FALSE) {
				$this->data['scId'] = $scId;
				$scId = $this->outh_model->Encryptor('decrypt', $scId);
				$this->data['amount'] = $this->get_an_obj_by_id('service_charges', 'service_charges_id', $scId)->amount;
				$this->data['page_title'] = 'edit service charges';
				$this->view('admin/charges/edit', $this->data);
			} else {
				$scId = $this->outh_model->Encryptor('decrypt', $scId);
				$data = array(
							'amount' => $post['amount']
						);
				$this->charges_m->add($data, $scId);
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
									'title' => 'service charges updated.',
									'description' => 'A service charges is updated.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'service charges is updated.');
				redirect('view-service-charges');
			}
		}
		else{
			$this->data['scId'] = $scId;
			$scId = $this->outh_model->Encryptor('decrypt', $scId);
			$this->data['amount'] = $this->get_an_obj_by_id('service_charges', 'service_charges_id', $scId)->amount;
			$this->data['page_title'] = 'edit service charges';
			$this->view('admin/charges/edit', $this->data);
		}
	}


//CLASS ENDS
}

/* End of file Form.php */
/* Location: ./application/controllers/admin/Form.php */
