<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Profile extends REST_Controller {
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

	public function add_profile_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules($this->app_student_m->rules);
                if ($this->form_validation->run() == FALSE) {
                    $res = ['status'=>404,'message'=>'Enter detail correctly.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                else{
                    if(count($_FILES) < 3){
                        $res = ['status'=>200,'message'=>'Select all three images.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    $ext = pathinfo($_FILES['student_img']['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $res = ['status'=>200,'message'=>'Invalid file format.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    $ext = pathinfo($_FILES['student_sign']['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $res = ['status'=>200,'message'=>'Invalid file format.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    $ext = pathinfo($_FILES['thumb_img']['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $res = ['status'=>200,'message'=>'Invalid file format.'];
                        $this->response($res, REST_Controller::HTTP_OK);
                        exit();
                    }
                    else{
                        $student_count = $this->db->get_obj('student_info','info_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                        if($student_count > 0){
                            $res = ['status'=>200,'message'=>'Profile already set.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                        else{
                            $_FILES = $this->doUpload($_FILES,'uploads/student');
                            $data = array(
                                'student_name' => $this->input->post('student_name'),
                                'mobile' => $this->input->post('mobile'),
                                'father_name' => $this->input->post('father_name'),
                                'mother_name' => $this->input->post('mother_name'),
                                'role_id' => 3,
                                'adhar_no' => $this->input->post('adhar_no'),
                                'identification_mark' => $this->input->post('identification_mark'),
                                'profile_status' => 1,
                                'student_id' => $this->head()['Student-Id'],
                                'dob' => $this->input->post('dob'),
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
                            $this->app_student_m->add($data, null);

                            $user_auth_data = array(
                                'user_name' => $this->input->post('email'),
                                'name'=>$this->input->post('student_name')
                            );

                            $this->db->set($user_auth_data);
                            $this->db->where('user_auth_id', $this->head()['Student-Id']);
                            $this->db->update('user_auth_detail');


                            $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('user_auth_id'=>$this->head()['Student-Id']))->row();
                            $studentObj->student_id = $studentObj->user_auth_id;
                            $studentObj->category = $this->input->post('category_name');
                            $studentObj->profile = 1;
                            $studentObj->academic_status = null;
                            $studentObj->certificate_status = null;
                            $studentObj->email = $studentObj->user_name;
                            unset($studentObj->user_auth_id);
                            unset($studentObj->user_name);

                            $res = ['status'=>200,'message'=>'Profile is updated successfully.', 'student'=>$studentObj];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                    }
                }
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }


    public function edit_profile_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules($this->app_student_m->rules);
                if ($this->form_validation->run() == FALSE) {
                    $res = ['status'=>404,'message'=>'Enter detail correctly.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                else{
                    $student_obj = $this->db->get_obj('student_info','student_img,signature_img,thumb_img',array('student_id'=>$this->head()['Student-Id']))->row();
                    if(!empty($_FILES['student_img']['name'])){
                        $ext = pathinfo($_FILES['student_img']['name'], PATHINFO_EXTENSION);
                        if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                            $res = ['status'=>200,'message'=>'Invalid file format.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                    }
                    if(!empty($_FILES['student_sign']['name'])){
                        $ext = pathinfo($_FILES['student_sign']['name'], PATHINFO_EXTENSION);
                        if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                            $res = ['status'=>200,'message'=>'Invalid file format.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                    }
                    if(!empty($_FILES['thumb_img']['name'])){
                        $ext = pathinfo($_FILES['thumb_img']['name'], PATHINFO_EXTENSION);
                        if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                            $res = ['status'=>200,'message'=>'Invalid file format.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        }
                    }

                    // if(count($_FILES > 0)){
                        $i=0;
                    foreach ($_FILES as $key1 => $img) {
                        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                        $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                        $i++;
                    }
                    // }

                    if(!empty($_FILES['student_img']['name'])){
                        unlink("uploads/student/$student_obj->student_img");
                        $student_img = $_FILES['student_img']['name'];
                    }
                    else{
                        $student_img = $student_obj->student_img;
                    }

                    if(!empty($_FILES['student_sign']['name'])){
                        unlink("uploads/student/$student_obj->signature_img");
                        $student_sign = $_FILES['student_sign']['name'];
                    }
                    else{
                        $student_sign = $student_obj->signature_img;
                    }

                    if(!empty($_FILES['thumb_img']['name'])){
                        unlink("uploads/student/$student_obj->thumb_img");
                        $thumb_img = $_FILES['thumb_img']['name'];
                    }
                    else{
                        $thumb_img = $student_obj->thumb_img;
                    }

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
                            $res = ['status'=>200,'message'=>'Something went wrong. Try Again.'];
                            $this->response($res, REST_Controller::HTTP_OK);
                            exit();
                        } else {
                            array('upload_data' => $this->upload->data());
                        }
                        $i++;
                    }


                    

                    $data = array(
                            'student_name' => $this->input->post('student_name'),
                            'father_name' => $this->input->post('father_name'),
                            'mother_name' => $this->input->post('mother_name'),
                            'student_id' => $this->head()['Student-Id'],
                            'adhar_no' => $this->input->post('adhar_no'),
                            'identification_mark' => $this->input->post('identification_mark'),
                            'dob' => $this->input->post('dob'),
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

                    $this->db->where('student_id',$this->head()['Student-Id']);
                    $this->db->update('student_info',$data);

                    $user_auth_data = array(
                        'user_name' => $this->input->post('email'),
                        'name'=>$this->input->post('student_name'),
                    );

                    $this->db->set($user_auth_data);
                    $this->db->where('user_auth_id', $this->head()['Student-Id']);
                    $this->db->update('user_auth_detail');


                    $res = ['status'=>200,'message'=>'Profile is updated successfully.'];
                    $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function view_profile_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $student_count = $this->db->get_obj('student_info','student_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                if($student_count > 0){
                    $select = '
                            student_info.student_name,
                            student_info.father_name,
                            student_info.mother_name,
                            student_info.dob,
                            student_info.student_img,
                            student_info.signature_img,
                            student_info.thumb_img,
                            student_info.address,
                            student_info.house,
                            student_info.block,
                            student_info.district,
                            student_info.pincode,
                            student_info.mobile,
                            student_info.gender,
                            student_info.adhar_no,
                            student_info.identification_mark,
                            category.category_name,
                            category.category_id,
                            state.state_name,
                            state.state_id,
                            user_auth_detail.user_name
                ';
                    $join = array(
                                'category'=>'category.category_id=student_info.category_id',
                                'state'=>'state.state_id=student_info.state',
                                'user_auth_detail'=>'user_auth_detail.user_auth_id=student_info.student_id',
                            );

                    $res = $this->db->get_obj('student_info',$select,array('student_info.student_id'=>$this->head()['Student-Id']),$join)->row();
                    $res->student_img = base_url('uploads/student/'.$res->student_img);
                    $res->signature_img = base_url('uploads/student/'.$res->signature_img);
                    $res->thumb_img = base_url('uploads/student/'.$res->thumb_img);
                }
                else{
                    $res = ['status'=>200, 'message'=>'No profile is added.'];
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);

        }
    }



// CLASS ENDS
}
