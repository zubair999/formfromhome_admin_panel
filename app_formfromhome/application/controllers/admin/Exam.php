<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'examListing';
    $data['pageTitle'] = 'exam list';
    $data['pl'] = 'exam-add';
    $data['drawTable'] = $this->examTableHead();
    $this->parsed('admin/exam/index', $data);
	}

	public function examTableHead()
    {
      $tableHead = array(
				'srno' => 'sr. no.',
				'exam name' => 'exam name',
				'post date' => 'post date',
				'last date' => 'last date',
				'month' => 'month',
				'year' => 'year',
				'action' => 'action'
  		);
      return $tableHead;
    }

  public function showExam(){
      $json_data = $this->exam_m->getAllExam();
      echo json_encode($json_data);
  }


	public function add(){
		$pt = $this->input->post();
		if($this->input->post('submit1')){
			$this->form_validation->set_rules($this->exam_m->rules);
			$this->form_validation->set_message('alpha_numeric_space', 'only alpha numeric values are allowed.');
			if($this->form_validation->run() == FALSE){
				$this->data['category_arr']	= $this->get_arr_of_obj('category');
				$this->data['category_arr']	= $this->exam_m->change_keys_to_hashed_key_of_arr($this->data['category_arr'] , 'category_id');
				$this->data['state_arr'] = $this->get_arr_of_obj('state');
				$this->data['page_title'] = 'add exam';
				$this->view('admin/exam/add', $this->data);
			}
			else{
				$post_date = $this->dmy_to_ymd($pt['post_date']);
				$last_date = $this->dmy_to_ymd($pt['last_date']);

				$month = date('F',strtotime($last_date));
				$year = date('Y',strtotime($last_date));

				$data = array(
					'state_id' => $pt['state_name'],
					'name_of_post' => $pt['name_of_post'],
					'post_date' => $post_date,
					'last_date' => $last_date,
					'short_info' => $pt['short_info'],
					'short_info' => $pt['short_info'],
					'content' => $pt['content'],
					'month' => strtolower($month),
					'year' => $year
				);

				$this->exam_m->add($data, null);
				$last_insert_id = $this->db->insert_id();
				$category_arr = $pt['category_id'];
				$category_arr = $this->exam_m->change_indexed_hashed_keys_to_primary_key($category_arr);
				$fee_arr = $pt['exam_fee'];

				$category_arr_count = count($category_arr);
				$fee_arr_count = count($fee_arr);
				$combine_arr = array_combine($category_arr, $fee_arr);



				foreach ($combine_arr as $key => $value) {
					$arrayName = array(
						'category_id' => $key,
						'exam_fee' => $value,
						'exam_id' => $last_insert_id
					);
					$this->db->insert('exam_fee', $arrayName);
				}


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
										'title' => 'exam Added.',
										'description' => 'A new exam is created.'
									);
					$logdata = $this->toLowerCase($log);
					$this->db->insert('logs',$logdata);
					$this->send_push_notification($pt['name_of_post']);
					$this->session->set_flashdata('notification', 'exam added successfully.');
					redirect('exam-view');
			}
		}
		else{
			// CHECK IF SERVICE CHARGE IS SET.
			$service_charge_count = $this->db->get('service_charges')->num_rows();
			if($service_charge_count >0){
				$this->data['category_arr']	= $this->get_arr_of_obj('category');
				$this->data['category_arr']	= $this->exam_m->change_keys_to_hashed_key_of_arr($this->data['category_arr'] , 'category_id');
				$this->data['state_arr'] = $this->get_arr_of_obj('state');
				$this->data['page_title'] = 'add exam';
				$this->view('admin/exam/add', $this->data);
			}
			else{
				$this->session->set_flashdata('notification', 'Add service Charges First');
				redirect('add-service-charges');
			}
		}
	}

	public function edit($exam_id){
		$pt = $this->input->post();
		if($this->input->post('submit1')){
			$this->form_validation->set_rules($this->exam_m->rules);
			$this->form_validation->set_message('alpha_numeric_space', 'only alphabets allowed.');
			if($this->form_validation->run() == FALSE){
				$this->data['state_arr'] = $this->get_arr_of_obj('state');
				$this->data['exam_id'] = $exam_id;
				$exam_id = $this->outh_model->Encryptor('decrypt', $exam_id);
				$this->data['exam_obj'] = $this->get_an_obj_by_id('exam', 'exam_id', $exam_id);
				$this->data['exam_obj']->post_date = $this->ymd_to_dmy($this->data['exam_obj']->post_date);
				$this->data['exam_obj']->last_date = $this->ymd_to_dmy($this->data['exam_obj']->last_date);
				$this->data['state_arr'] = $this->get_arr_of_obj('state');
				$this->data['page_title'] = 'edit exam';
				$this->view('admin/exam/edit', $this->data);
			}
			else{
				// CHECK IF ANY FEE CATEGORY IS DELETE OR CREATED.
				$exam_id = $this->outh_model->Encryptor('decrypt', $exam_id);
				$category_arr = $pt['category_id'];
				$category_arr = $this->exam_m->change_indexed_hashed_keys_to_primary_key($category_arr);
				$this->exam_m->check_exam_fee_changes($pt['exam_fee'],$category_arr,$exam_id);

				$post_date = $this->dmy_to_ymd($pt['post_date']);
				$last_date = $this->dmy_to_ymd($pt['last_date']);	

				$month = date('F',strtotime($last_date));
				$year = date('Y',strtotime($last_date));

				$data = array(
					'state_id' => $pt['state_name'],
					'name_of_post' => $pt['name_of_post'],
					'post_date' => $post_date,
					'last_date' => $last_date,
					'short_info' => $pt['short_info'],
					'short_info' => $pt['short_info'],
					'content' => $pt['content'],
					'month' => strtolower($month),
					'year' => $year
				);

				$this->exam_m->add($data, $exam_id);

				// $fee_arr = $pt['exam_fee'];
				// $category_arr_count = count($category_arr);
				// $fee_arr_count = count($fee_arr);
				// $combine_arr = array_combine($category_arr, $fee_arr);

				// foreach ($combine_arr as $key => $value) {
				// 	$arrayName = array(
				// 		'exam_fee' => $value,
				// 	);
				// 	$this->db->set('exam_fee');
				// 	$this->db->where('category_id', $key);
				// 	$this->db->update('exam_fee',$arrayName);
				// }

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
									'title' => 'exam update.',
									'description' => 'A exam is updated.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'exam updated successfully.');
				redirect('exam-view');
			}
		}
		else{
			$this->data['exam_id'] = $exam_id;
			$this->data['category_arr']	= $this->db->get_obj('category')->result_array();
			$this->data['category_arr']	= $this->exam_m->change_keys_to_hashed_key_of_arr($this->data['category_arr'] , 'category_id');
			$exam_id = $this->outh_model->Encryptor('decrypt', $exam_id);
			$this->data['exam_obj'] = $this->db->get_obj('exam', '*', array('exam_id'=>$exam_id))->row();
			$this->data['exam_obj']->post_date = $this->ymd_to_dmy($this->data['exam_obj']->post_date);
			$this->data['exam_obj']->last_date = $this->ymd_to_dmy($this->data['exam_obj']->last_date);
			$this->data['state_arr'] = $this->db->get_obj('state')->result_array();
			$this->data['cat_id_arr'] = $this->db->get_obj('exam_fee','exam_fee.category_id,exam_fee.exam_fee,exam_fee.exam_id,category.category_name',array('exam_id'=>$exam_id),array('category'=>'exam_fee.category_id=category.category_id'))->result_array();
			$this->data['cat_id_arr']	= $this->exam_m->change_keys_to_hashed_key_of_arr($this->data['cat_id_arr'] , 'category_id');
			$this->data['cat_id_count'] = count($this->data['cat_id_arr']);

			$j=0;
			foreach ($this->data['category_arr'] as $key3 => $value3) {
				$this->data['category_arr'][$j]['checked'] = 'unchecked';
			$j++;
			}

			$i=0;
			foreach ($this->data['category_arr'] as $key1 => $value1) {
				foreach ($this->data['cat_id_arr'] as $key2 => $value2) {
					if($value1['category_idId']==$value2['category_idId']){
						$this->data['category_arr'][$i]['checked'] = 'checked';
					}
				}
			$i++;
			};

			$this->data['page_title'] = 'edit exam';
			$this->view('admin/exam/edit', $this->data);
		}
	}

	public function exam_detail(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$pt = $this->input->post();
			$exam_id = $this->outh_model->Encryptor('decrypt', $pt['exam']);
			if($exam_id == false){
				$response = ['status'=>422, 'message'=>'something went wrong.'];
				echo json_encode($response);
			}
			else{
				$response = $this->get_an_obj_by_id('exam', 'exam_id', $exam_id);
				$response = ['status'=>200, 'message'=>'ok', 'content'=>$response];
				echo json_encode($response);
			}

		}
		else{
			$response = ['status'=>400, 'message'=>'bad request.'];
			echo json_encode($response);
		}
	}


	public function send_push_notification($name_of_post){
		$content = $name_of_post.' Check this out.';


		$content = array(
			"en" => $content
		);
		$headings = array(
			"en" => 'A new jobs is available'
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

/* End of file Form.php */
/* Location: ./application/controllers/admin/Form.php */
