<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'studentListing';
		$data['pageTitle'] = 'student list';
		$data['pl'] = 'add-student';
		$data['drawTable'] = $this->studentTableHead();
		$this->parsed('admin/student/index', $data);
	}

	public function studentTableHead(){
					$tableHead = array(
					'srno' => 'sr. no.',
					'executive name' => 'student name',
					'mobile no' => 'mobile no',
					'email' => 'email',
					'registered by'=> 'registered by',
					'registration date'=> 'registration date',
					'action' => 'action'
			);
			return $tableHead;
	}

	public function showstudent(){

		$json_data = $this->student_m->getAllStudents();
		echo json_encode($json_data);
	}

	public function showprofile(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$student_id = $this->outh_model->Encryptor('decrypt',$this->input->post('student'));

			if($student_id === FALSE) {
				$response = ['status'=>422 , 'message'=> 'action not valid'];
				echo json_encode($response);
			}
			else{
				$response = $this->student_m->showprofile($student_id);
				$response = ['status'=>200 , 'message'=> $response];
				echo json_encode($response);
			}
		}

	}



	public function send_email_to_student($id){
		if($this->input->post('submit1')){
			$app_id = $this->outh_model->Encryptor('decrypt',$id);
			$stu_id	=	$this->get_an_obj_by_id('application','application_id',$app_id)->student_id;
			$student_obj = $this->get_an_obj_by_id('user_auth_detail','user_auth_id',$stu_id);
			$exam_id =	$this->get_an_obj_by_id('application','application_id',$app_id)->exam_id;
			$exam_name=	$this->get_an_obj_by_id('exam','exam_id',$exam_id)->name_of_post;

			$upload_url = 'uploads/form/';
			$ext = pathinfo($_FILES['form']['name'], PATHINFO_EXTENSION);
			$_FILES['form']['name'] = md5(date('Y-m-d H:i:s:u')) . time() . '.' . $ext;
			$config['upload_path']          = $upload_url;
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 15000;
            $config['max_width']            = 4000;
            $config['max_height']           = 4000;
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('form')) {
                $error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('notification', 'Only PDF file are allowed.');
				$this->data['page_title']	= 'send form to student';
				$this->view('admin/student/sendmail' , $this->data);
				$app_id = $this->outh_model->Encryptor('encrypt',$app_id);
				redirect('send-email/'.$app_id);
            }
            else {
				$receiver_mail = $student_obj->user_name;
				$receiver_name = $student_obj->name;
				$one_signal_player_id = $student_obj->onesignal_player_id;
				$response = $this->send_my_email($receiver_mail, $receiver_name, $upload_url, $_FILES, $one_signal_player_id);
				if($response === true){
					$data = array('email_status'=>1,'email_sent_by'=>$this->user_id,'filled_form_img'=>$_FILES['form']['name']);
					$this->application_m->add($data,$app_id);
					$this->session->set_flashdata('notification', 'Email sent successfully.');
					$this->data['page_title']	= 'send form to student';
					redirect('application-view', $this->data);
				}
				else{
					$this->session->set_flashdata('notification', 'Something went wrong. Email not sent.');
					$this->data['page_title']	= 'send form to student';
					redirect('application-view', $this->data);
				}
   			}
		}
		else{
			$this->data['id'] = $id;
			$this->data['page_title']	= 'send form to student';
			$this->view('admin/student/sendmail' , $this->data);
		}
	}

	public function send_my_email($recepient, $recepient_name, $upload_url, $file, $oneSignalPlayId){

		$length = 32;    
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("nayar999@gmail.com", "Form From Home");
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo($recepient, $recepient_name);
        $email->setTemplateId(get_settings('twilio_mail_template_id'));

        $file_encoded = base64_encode(file_get_contents(base_url($upload_url.$file['form']['name'])));
        $newFileName = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
		
		$email->addAttachment(
        $file_encoded,
            "application/pdf",
            $newFileName.".pdf",
            "attachment"
        );

        $sendgrid = new \SendGrid(get_settings('twilio_sendgrid_mail_api'));
        try {
            $response = $sendgrid->send($email);


            $i = $response->statusCode();

			if($i == 202){
				$this->send_push_notification($recepient_name, $oneSignalPlayId);
				return true;
			}
			else{
				return false;
			}
        } catch (Exception $e) {

            return false;
        }
    }

	public function send_push_notification($recepient_name, $oneSignalPlayId){
		$content = array(
			"en" => 'Your form has been filled kindly check your email and app.'
		);
		$headings = array(
			"en" => 'Hello '.$recepient_name
		);

		$pid = $oneSignalPlayId;
	
		$one_signal_app_id = get_settings('onesignal_app_id');

		$fields = array(
			'app_id' => $one_signal_app_id,
			'headings' => $headings,
			'contents' => $content,
			'large_icon' => "https://i0.wp.com/www.azoncode.com/wp-content/uploads/2017/03/fb-icom-1.png?fit=512%2C512&ssl=1",
  			"include_player_ids" => [$pid]
		);
	
		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
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

	public function student_info(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$stuId = $this->outh_model->Encryptor('decrypt',$this->input->post('stu_id'));
			if($stuId === FALSE){
				$response = ['status'=>422 , 'message'=>'action not valid'];
				echo json_encode($response);
			}else{
				$stuobj = $this->student_m->student_info($stuId);
				$academic = $this->student_m->get_student_academic_info($stuId);
				$certificate = $this->student_m->get_student_certificate_info($stuId);
                $document = $this->download($stuId);
				$response = ['status'=>200, 'message'=>'ok','academic' => $academic,'info'=>$stuobj,'certificate'=>$certificate, 'document'=>$document];
				echo json_encode($response);
			}
		}
		else{
			$response = ['status'=>400,'message'=>'bad request.'];
		}
	}





//add

	public function add_student(){
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->student_m->rules);
			if ($this->form_validation->run() == FALSE) {
					$this->data['page_title'] = 'add student';
		            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
		            $this->data['state'] = $this->db->get_obj('state')->result_array();
					$this->view('admin/student/add', $this->data);
			}
			else {
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }


                // CHECKING IF FILES ARE ALLOWED OR NOT
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $this->session->set_flashdata('notification', 'Invalid file format');
                        redirect('add-student');
                    }
                }

                $user_auth_data = array(
                			'user_name' => $this->input->post('user_name'),
                			'user_auth_pwd' => password_hash(123,PASSWORD_DEFAULT),
                			'role_id' => 3,
                			'mobile'=>$this->input->post('mobile'),
                			'name'=>$this->input->post('student_name'),
                			'status'=> 1,
                			'iss'=> 'localhost',
                			'registered_by'=> 'Admin',
                			'create_date'=>$this->current_time
                		);


                $this->student_m->add($user_auth_data, null);
                $last_stu_id = $this->db->insert_id();
                
                $student_info = array(
                		'student_name' => $this->input->post('student_name'), 
                		'mobile' => $this->input->post('mobile'), 
                		'father_name' => $this->input->post('father_name'), 
                		'mother_name' => $this->input->post('mother_name'),
                		'role_id' => 3, 'profile_status' => 1, 
                		'student_id' =>$last_stu_id, 
                		'dob' => $this->dmy_to_ymd($this->input->post('dob')),
                		'gender' => $this->input->post('gender'), 
                		'category_id' => $this->input->post('category_name'), 
                		'house' => $this->input->post('house'), 
                		'block' => $this->input->post('block'), 
                		'district' => $this->input->post('district'), 
                		'state' => $this->input->post('state'), 
                		'pincode' => $this->input->post('pincode'), 
                		'address' => $this->input->post('address'), 
                		'student_img' => $_FILES['student_img']['name'], 
                		'signature_img' => $_FILES['student_sign']['name'], 
                		'thumb_img' => $_FILES['thumb_img']['name']
                	);

                              
               
                

                $res = $this->db->insert('student_info', $student_info);
                $data = array('status' => 1);


                $this->session->set_flashdata('notification', 'Profile is set now.');
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $config['upload_path'] = 'uploads/student';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 10000000;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Something went wrong.');
                        $this->data['page_title'] = 'send form to student';
                        $this->view('admin/student/add', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                    }
                    $i++;
                }

                
				redirect('student-listing');
			}
		}
		else{
			$this->data['page_title'] = 'add student';
            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
            $this->data['state'] = $this->db->get_obj('state')->result_array();
			$this->view('admin/student/add', $this->data);
		}
	}
}




	public function edit_student($id){
	if ($this->input->post('submit1')) {
            $this->form_validation->set_rules($this->student_m->rules);
            $this->form_validation->set_message('alpha_numeric_space', 'Only alphanumeric values allowed. No special Charactor allowed.');
            if ($this->form_validation->run() == FALSE) {
                $this->data['id'] = $id;
	            $student_id = $this->outh_model->Encryptor('decrypt', $id);
	            $this->data['stu_data'] = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();
	            $stu_id = $this->data['stu_data']->student_id;
	            $this->data['user_data'] = $this->db->get_obj('user_auth_detail', 'user_name', array('user_auth_id' => $stu_id))->row();
	            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
	            $this->data['state'] = $this->db->get_obj('state')->result_array();
	            $this->data['page_title'] = 'edit student details.';
	            $this->view('admin/student/edit', $this->data);
            } else {

            	// CHECKING IF FILES ARE ALLOWED OR NOT
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $this->session->set_flashdata('notification', 'Invalid file format');
                        redirect('edit-student/'.$id);
                    }
                }

                // GETTING STUDENT ID.
                $student_id = $this->outh_model->Encryptor('decrypt', $id);
                // DELETING OLD FILES SAVED IN DATABASE.
                $student_info_obj = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();

                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }


                if(!empty($_FILES['student_img']['name'])){
                	unlink("uploads/student/$student_info_obj->student_img");
                	$student_img = $_FILES['student_img']['name'];
                }
                else{
                	$student_img = $student_info_obj->student_img;
                }
                if(!empty($_FILES['student_sign']['name'])){
                	unlink("uploads/student/$student_info_obj->signature_img");
                	$student_sign = $_FILES['student_sign']['name'];
                }
                else{
                	$student_sign = $student_info_obj->signature_img;
                }
                if(!empty($_FILES['thumb_img']['name'])){
                	unlink("uploads/student/$student_info_obj->thumb_img");
                	$thumb_img = $_FILES['thumb_img']['name'];
                }
                else{
                	$thumb_img = $student_info_obj->thumb_img;
                }
                

                $data = array(
                			'student_name' => $this->input->post('student_name'), 
                			'mobile' => $this->input->post('mobile'), 
                			'father_name' => $this->input->post('father_name'), 
                			'mother_name' => $this->input->post('mother_name'),
                			'dob' => $this->dmy_to_ymd($this->input->post('dob')), 
                			'gender' => $this->input->post('gender'), 
                			'category_id' => $this->input->post('category_name'), 
                			'house' => $this->input->post('house'), 
                			'block' => $this->input->post('block'), 
                			'district' => $this->input->post('district'), 
                			'state' => $this->input->post('state'), 
                			'pincode' => $this->input->post('pincode'), 
                			'address' => $this->input->post('address'), 
                			'student_img' => $student_img, 
                			'signature_img' => $student_sign, 
                			'thumb_img' => $thumb_img
                		);


                $this->db->set($data);
                $this->db->where('student_id', $student_id);
                $this->db->update('student_info');
                $this->session->set_flashdata('notification', 'Profile updated successfully.');


                $user_auth_data = array(
                			'user_name' => $this->input->post('user_name'),
                			'mobile'=>$this->input->post('mobile'),
                			'name'=>$this->input->post('student_name'),
                		);

                $this->db->set($user_auth_data);
                $this->db->where('user_auth_id', $student_id);
                $this->db->update('user_auth_detail');

                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/student';
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 100000;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Max File Size:200, Format: JPG, PNG, JPEG');
                        $this->data['page_title'] = 'send form to student';
                        $this->view('admin/student/edit', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                    }
                    $i++;
                }

                $this->db->set('mobile',$this->input->post('mobile'));
                $this->db->where('user_auth_id',$id);
                $this->db->update('user_auth_detail');

                redirect('student-listing');
            }
        } else {
            $this->data['id'] = $id;
            $student_id = $this->outh_model->Encryptor('decrypt', $id);
            $this->data['stu_data'] = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();
            $stu_id = $this->data['stu_data']->student_id;
            
            $this->data['user_data'] = $this->db->get_obj('user_auth_detail', 'user_name', array('user_auth_id' => $stu_id))->row();
            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
            $this->data['state'] = $this->db->get_obj('state')->result_array();
            $this->data['page_title'] = 'view student details.';
            $this->view('admin/student/edit', $this->data);
        }

	}


// delete all

	public function delete_all($id){
	 	$student_id = $this->outh_model->Encryptor('decrypt',$id);
	 	
	 //delete images from folder
	 	$student_info_obj = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();
        unlink("uploads/student/$student_info_obj->student_img");
        unlink("uploads/student/$student_info_obj->signature_img");
        unlink("uploads/student/$student_info_obj->thumb_img");
		
		$student_cer = $this->db->get_obj('student_certificate', '*', array('student_id' => $student_id))->row();
        unlink("uploads/certificates/$student_cer->certificate_img");

        $stu_marksheet = $this->db->get_obj('marksheet', '*', array('student_id' => $student_id))->row();
        unlink("uploads/marksheet/$stu_marksheet->marksheet_img");

	 	
		$tables = array('student_info', 'student_certificate','marksheet','student_academic');
		$this->db->where('student_id', $student_id);
		$this->db->delete($tables);
        $this->session->set_flashdata('notification', 'Invalid file format');

        $this->db->where('user_auth_id', $student_id);
		$this->db->delete('user_auth_detail');

		$this->session->set_flashdata('notification','delete student profile successfully');
		redirect('student-listing');

	}


    public function download_zip($id){
        $this->load->library('zip');
        $studentId = $this->db->get_obj('user_auth_detail','user_auth_id',array('user_name'=>$id))->row()->user_auth_id;
        $studentObj = $this->db->get_obj('student_info','student_img,signature_img,thumb_img',array('student_id'=>$studentId))->row();

        $studentImage = array( 
                0 => "uploads/student/$studentObj->student_img", 
                1 => "uploads/student/$studentObj->signature_img",
                2 => "uploads/student/$studentObj->thumb_img" 
            );

        $marksheetArr = $this->db->get_obj('marksheet','marksheet_img',array('student_id'=>$studentId))->result_array();
        foreach ($marksheetArr as $key => $value) {
            $marksheetArr[$key] = 'uploads/marksheet/'.$value['marksheet_img'];
        }

        $certificateArr = $this->db->get_obj('student_certificate','certificate_img',array('student_id'=>$studentId))->result_array();
        foreach ($certificateArr as $key => $value) {
            $certificateArr[$key] = 'uploads/certificates/'.$value['certificate_img'];
        }

        $studentFile = array_merge($studentImage,$marksheetArr,$certificateArr);
        
        if ($studentFile) {
            foreach ($studentFile as $image) {
                $this->zip->read_file($image);
            }
            echo $this->zip->download('' . time() . '.zip');
        }
    }


    private function download($studentId){
        $this->load->library('zip');
        $studentObj = $this->db->get_obj('student_info','student_img,signature_img,thumb_img',array('student_id'=>$studentId))->row();
        $studentImage = array( 
                0 => "uploads/student/$studentObj->student_img", 
                1 => "uploads/student/$studentObj->signature_img",
                2 => "uploads/student/$studentObj->thumb_img" 
            );

        $marksheetArr = $this->db->get_obj('marksheet','marksheet_img',array('student_id'=>$studentId))->result_array();
        foreach ($marksheetArr as $key => $value) {
            $marksheetArr[$key] = 'uploads/marksheet/'.$value['marksheet_img'];
        }

        $certificateArr = $this->db->get_obj('student_certificate','certificate_img',array('student_id'=>$studentId))->result_array();
        foreach ($certificateArr as $key => $value) {
            $certificateArr[$key] = 'uploads/certificates/'.$value['certificate_img'];
        }
        return array_merge($studentImage,$marksheetArr,$certificateArr);
    }







// CLASS ENDS
}

/* End of file Executive.php */
/* Location: ./application/controllers/admin/Executive.php */
