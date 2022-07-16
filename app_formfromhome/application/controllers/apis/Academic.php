<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Academic extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
    }

    /**
     * Get All EXAM from this method.
     *
     * @return Response
    */

	public function add_academic_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules($this->app_academic_m->rules);
                if($this->form_validation->run() == FALSE){
                    $res = ['status'=>404,'message'=>'Enter detail correctly.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                else{
                    if(count($_FILES) < 1){
                        $res = ['status'=>200,'message'=>'Add marksheet.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    $ext = pathinfo($_FILES['marksheet']['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $res = ['status'=>200,'message'=>'Invalid file format.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    else{
                        $data = array(
                          'qualification_id'=> $this->input->post('qualification'),
                          'passing_year'=> $this->input->post('year'),
                          'total_marks'=> $this->input->post('total_marks'),
                          'marks_obtained'=> $this->input->post('marks_obtained'),
                          'percentage'=> $this->input->post('percentage'),
                          'board_id'=> $this->input->post('board'),
                          'medium_id'=> $this->input->post('medium'),
                          'stream_id'=> $this->input->post('stream'),
                          'student_id'=> $this->head()['Student-Id'],
                          'extra_info'=> $this->input->post('extra_info')
                        );

                        $this->app_academic_m->add($data, null);
                        $last_academic_id = $this->db->insert_id();

                        $i = 0;
                        foreach ($_FILES as $key1 => $img) {
                            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                            $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                            $upload_url = 'uploads/marksheet';
                            $config['upload_path'] = $upload_url;
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 100000;
                            $config['max_width'] = 4000;
                            $config['max_height'] = 4000;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload($key1)) {
                                $error = array('error' => $this->upload->display_errors());
                                $res = ['status'=>200,'message'=>'Something went wrong. Try Again.'];
                                $this->response($res, REST_Controller::HTTP_OK);
                                exit();
                            } else {
                                array('upload_data' => $this->upload->data());
                                $marksheet = array('academic_id' => $last_academic_id, 'marksheet_img' => $_FILES[$key1]['name'], 'student_id' => $this->head()['Student-Id']);
                                $this->db->insert('marksheet', $marksheet);
                            }
                            $i++;
                        }

                        $this->db->set('academic_status',1);
                        $this->db->where('student_id',$this->head()['Student-Id']);
                        if($this->db->update('student_info')){


                            $category_id = $this->db->get_obj('student_info','category_id',array('student_id'=>$this->head()['Student-Id']))->row()->category_id;

                            $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('user_auth_id'=>$this->head()['Student-Id']))->row();
                            $studentObj->student_id = $studentObj->user_auth_id;
                            $studentObj->category = $category_id;
                            $studentObj->profile = 1;
                            $studentObj->academic_status = 1;
                            $studentObj->certificate_status = null;
                            $studentObj->email = $studentObj->user_name;
                            unset($studentObj->user_auth_id);
                            unset($studentObj->user_name);

                            $res = ['status'=>200,'message'=>'Academic detail saved succesfully.','student'=>$studentObj];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                        else{
                            $res = ['status'=>200,'message'=>'Something went wrong. Try Again.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                    }
                }
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
            exit();
        }
    }


    private function doUploadAcademic($files,$upload_url,$last_academic_id,$student_id){
        $i = 1;
        foreach ($files as $key1 => $img) {
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            $filename = preg_replace("/[^a-z0-9_\s-]/", "", date('Y-m-d h:i:s'));
            $filename = preg_replace("/[\s-]+/", " ", $filename);
            $filename = preg_replace("/[\s_]/", "-", $filename);
            $_FILES[$key1]['name'] = $filename . '_'. $i . '.' . $ext;
            $config['upload_path'] = $upload_url;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 10000;
            $config['max_width'] = 4000;
            $config['max_height'] = 4000;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($key1)) {
                return array('error' => $this->upload->display_errors());
            } else {
                array('upload_data' => $this->upload->data());
                $marksheet = array(
                  'academic_id'=>$last_academic_id,
                  'marksheet_img'=>$_FILES[$key1]['name'],
                  'student_id'=>$student_id
                );
                $this->db->insert('marksheet', $marksheet);
            }
            $i++;
        }
        return $_FILES;
    }


    public function get_academic_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                    // GETTING EXAM INFO
                $exam_obj = $this->db->get_obj('exam', '*', array('exam_id'=>$this->input->post('examId')))->row();

                // GETTING STUDENT CATEGORY NAME
                $student_obj = $this->db->get_obj(
                    'student_info',
                    'student_info.student_id,
                    category.category_name,
                    category.category_id',
                    array('student_info.student_id'=>$this->input->post('studentId')),
                    array('category'=>'category.category_id=student_info.category_id'))->row();

                // GETTING EXAM PRICE
                $exam_fee = $this->db->get_obj('exam_fee', 'exam_fee', array('exam_id'=>$exam_obj->exam_id, 'category_id'=>$student_obj->category_id))->row()->exam_fee;
                $service_charge = $this->db->get_obj('service_charges', 'amount', array('is_active'=>1))->row()->amount;
                $res = [
                        'status'=>200,
                        'message'=>'ok',
                        'exam_content'=>$exam_obj,
                        'exam_charge'=>$exam_fee,
                        'service_charge'=>$service_charge,
                        'category'=>strtoupper($student_obj->category_name)
                    ];
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function edit_academic_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                    // GETTING EXAM INFO
                $exam_obj = $this->db->get_obj('exam', '*', array('exam_id'=>$this->input->post('examId')))->row();

                // GETTING STUDENT CATEGORY NAME
                $student_obj = $this->db->get_obj(
                    'student_info',
                    'student_info.student_id,
                    category.category_name,
                    category.category_id',
                    array('student_info.student_id'=>$this->input->post('studentId')),
                    array('category'=>'category.category_id=student_info.category_id'))->row();

                // GETTING EXAM PRICE
                $exam_fee = $this->db->get_obj('exam_fee', 'exam_fee', array('exam_id'=>$exam_obj->exam_id, 'category_id'=>$student_obj->category_id))->row()->exam_fee;
                $service_charge = $this->db->get_obj('service_charges', 'amount', array('is_active'=>1))->row()->amount;
                $res = [
                        'status'=>200,
                        'message'=>'ok',
                        'exam_content'=>$exam_obj,
                        'exam_charge'=>$exam_fee,
                        'service_charge'=>$service_charge,
                        'category'=>strtoupper($student_obj->category_name)
                    ];
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function get_academic_items_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){

                $qualification = $this->db->get_obj('qualification')->result_array();
                foreach ($qualification as $key => $value) {
                    $qualification[$key]['value'] = $value['qualification_id'];
                    $qualification[$key]['label'] = ucwords($value['qualification_name']);
                    unset($qualification[$key]['qualification_id']);
                    unset($qualification[$key]['qualification_name']);
                }

                $this->db->order_by('board_name','asc');
                $board = $this->db->get_obj('board')->result_array();
                foreach ($board as $key => $value) {
                    $board[$key]['value'] = $value['board_id'];
                    $board[$key]['label'] = ucwords($value['board_name']);
                    unset($board[$key]['board_id']);
                    unset($board[$key]['board_name']);
                }

                $this->db->order_by('mediam_name','asc');
                $mediam = $this->db->get_obj('mediam')->result_array();
                foreach ($mediam as $key => $value) {
                    $mediam[$key]['value'] = $value['mediam_id'];
                    $mediam[$key]['label'] = ucwords($value['mediam_name']);
                    unset($mediam[$key]['mediam_id']);
                    unset($mediam[$key]['mediam_name']);
                }

                $this->db->order_by('stream_name','asc');
                $stream = $this->db->get_obj('stream')->result_array();
                foreach ($stream as $key => $value) {
                    $stream[$key]['value'] = $value['stream_id'];
                    $stream[$key]['label'] = ucwords($value['stream_name']);
                    unset($stream[$key]['stream_id']);
                    unset($stream[$key]['stream_name']);
                }

                $res = [
                    'qualification'=>$qualification,
                    'board'=>$board,
                    'medium'=>$mediam,
                    'stream'=>$stream
                ];
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function getstudent_academic_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $academic_count = $this->db->get_obj('student_academic','academic_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                if($academic_count > 0){
                     $res = $this->db->get_obj('student_academic',
                                            'qualification.qualification_name,
                                            student_academic.academic_id
                                            '
                                            ,
                                            array('student_academic.student_id'=>$this->head()['Student-Id']),
                                            array('qualification'=>'qualification.qualification_id=student_academic.qualification_id'))->result_array();
                }
                else{
                    $res = ['status'=>200,'message'=>'no acadmic added.'];
                }

                $this->response($res, REST_Controller::HTTP_OK);

            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }


    public function getAcademicDetail_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $select = '
                            student_academic.passing_year,
                            student_academic.total_marks,
                            student_academic.marks_obtained,
                            student_academic.percentage,
                            qualification.qualification_name,
                            board.board_name,
                            mediam.mediam_name,
                            stream.stream_name
                        ';
                $join = array(
                            'qualification'=>'qualification.qualification_id=student_academic.qualification_id',
                            'board'=>'board.board_id=student_academic.board_id',
                            'mediam'=>'mediam.mediam_id=student_academic.medium_id',
                            'stream'=>'stream.stream_id=student_academic.stream_id'
                        );
                $res = $this->db->get_obj('student_academic',$select,array('student_academic.academic_id'=>$this->input->post('academic_id')),$join)->row();

                $marksheet = $this->db->get_obj('marksheet','marksheet_id,marksheet_img',array('academic_id'=>$this->input->post('academic_id')))->result_array();

                foreach ($marksheet as $key => $value) {
                    $marksheet[$key]['marksheet_img'] = base_url('uploads/marksheet/'.$value['marksheet_img']);
                }

                $res = ['academic'=>$res, 'marksheet'=>$marksheet];

                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function add_marksheet_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                if(count($_FILES) < 1){
                    $res = ['status'=>200,'message'=>'Select marksheet to upload.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                $ext = pathinfo($_FILES['marksheet_img']['name'], PATHINFO_EXTENSION);
                if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                    $res = ['status'=>200,'message'=>'Invalid file format.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $upload_url = 'uploads/marksheet';
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 100000;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $res = ['status'=>200,'message'=>'Something went wrong. Try Again.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    } else {
                        array('upload_data' => $this->upload->data());
                        $marksheet = array('academic_id' => $this->input->post('academic_id'), 'marksheet_img' => $_FILES[$key1]['name'], 'student_id' => $this->head()['Student-Id']);
                        $this->db->insert('marksheet', $marksheet);
                    }
                    $i++;
                }
                $res = ['status'=>200,'message'=>'Marksheet uploaded succesfully.'];
                $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
            exit();
        }
    }

    public function delete_marksheet_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $marksheet_img = $this->db->get_obj('marksheet','marksheet_img',array('marksheet_id'=>$this->input->post('marksheet_id')))->row()->marksheet_img;
                $this->db->where('marksheet_id',$this->input->post('marksheet_id'));
                if($this->db->delete('marksheet')){
                    unlink("uploads/marksheet/$marksheet_img");
                    $res = ['status'=>200,'message'=>'Marksheet deleted succesfully.','marksheet_id'=>$this->input->post('marksheet_id')];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                else{
                    $res = ['status'=>200,'message'=>'Something went wrong. Try again.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }

            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
            exit();
        }
    }




// CLASS ENDS
}
