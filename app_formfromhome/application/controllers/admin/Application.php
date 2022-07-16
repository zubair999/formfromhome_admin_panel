<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function application_list(){
		$data['tableId'] = 'applicationListing';
		$data['pageTitle'] = 'application list';
		$data['pl'] = null;
		$data['drawTable'] = $this->applicationTableHead();
		$this->parsed('admin/application/index', $data);
	}

	public function applicationTableHead(){
				$tableHead = array(
					'srno' => 'sr. no.',
					'exam id' => 'exam',
					'student id' => 'student',
					'status'	=> 'status',
					'action' => 'action'

			);
			return $tableHead;
	}
	public function showapplication(){
		$json_data = $this->application_m->getAllApplication();
		echo json_encode($json_data);
	}
	public function application_status()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$application_id = $this->outh_model->Encryptor('decrypt',$this->input->post('ap_id'));
			if($application_id === FALSE){
				$response = ['status'=>422 , 'message'=>'action not valid.'];
				echo json_encode($response);
			}else{
				$data = array('application_status'=>1, 'form_filled_by'=>$this->user_id);
				$response = $this->application_m->add($data, $application_id);
				echo json_encode($response);
			}
		}
	}
	public function get_app_info(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$app_id = $this->outh_model->Encryptor('decrypt',$this->input->post('a_id'));
			if($app_id === FALSE){
				$response = ['status'=>422 , 'message'=>'action not valid'];
				echo json_encode($response);
			}else{
				$appObj = $this->application_m->get_app_info($app_id);
				$response = ['status'=>200, 'message'=>'ok', 'content'=>$appObj];
				echo json_encode($response);
			}
		}
		else{
			$response = ['status'=>400,'message'=>'bad request.'];
		}
	}



// CLASS ENDS
}

/* End of file Executive.php */
/* Location: ./application/controllers/admin/Executive.php */
