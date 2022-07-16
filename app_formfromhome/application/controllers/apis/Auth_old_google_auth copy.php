<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller {

	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
        parent::__construct();
    }

    

    public function google_auth_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules('mobile','Mobile','trim|required|exact_length[10]|is_natural');
                if($this->form_validation->run() === FALSE){
                    $res = ['status' => 200, 'code'=>101, 'message' => 'invalid details.'];
                }
                else{
                    $student_count = $this->db->get_obj('user_auth_detail','user_auth_id',array('mobile'=>$this->input->post('mobile')))->num_rows();
                    if($student_count > 0){
                        $profile_count = $this->db->get_obj('student_info','category_id',array('mobile'=>$this->input->post('mobile')))->num_rows();
                        if($profile_count > 0){
                            $category_id = $this->db->get_obj('student_info','category_id',array('mobile'=>$this->input->post('mobile')))->row()->category_id;
                            $academic_status = $this->db->get_obj('student_info','academic_status',array('mobile'=>$this->input->post('mobile')))->row()->academic_status;
                        }
                        else{
                            $category_id = null;
                            $academic_status = null;
                        }
                        
                        $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('mobile'=>$this->input->post('mobile')))->row();
                        $studentObj->student_id = $studentObj->user_auth_id;
                        $studentObj->email = $studentObj->user_name;
                        $studentObj->category = $category_id;
                        $studentObj->academic_status = $academic_status;
                        unset($studentObj->user_auth_id);
                        unset($studentObj->user_name);
                        $res = ['status'=> 200, 'code'=>102, 'message'=> 'success', 'student'=>$studentObj, 'request'=>'login'];
                    }
                    else{
                        $payload = array(
                            'last_login' => time(),
                            'iss'=> 'localhost',
                            'expiry' => time() + (60),
                            'mobile' => $this->input->post('mobile'),
                            'role_id' => 3
                        );
                        $token = $this->encode($payload);
                        $user_dtail = array(
                            'role_id' => 3,
                            'mobile' => $this->input->post('mobile'),
                            'user_auth_pwd' => password_hash($this->input->post('mobile'),PASSWORD_DEFAULT),
                            'token' => $token,
                            'expiry' => $this->expiry,
                            'last_login' => $this->current_time,
                            'status'=> 1,
                            'iss'=> 'localhost',
                            'create_date' => $this->current_time,
                            'registered_by' => 'Self'
                        );
                        $response = $this->db->insert('user_auth_detail', $user_dtail);
                        $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('mobile'=>$this->input->post('mobile')))->row();
                        $studentObj->name = '';
                        $studentObj->email = '';
                        $studentObj->mobile = $this->input->post('mobile');
                        $studentObj->student_id = $studentObj->user_auth_id;
                        if($response === true){
                            $res = ['status' => 200, 'code'=>105, 'message' => 'success', 'student'=>$studentObj, 'request'=>'registration'];
                        }
                        else{
                            $res = ['status' => 200, 'code'=>104, 'message' => 'error'];
                        }
                    }
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }


    public function google_auth_test_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules('mobile','Mobile','trim|required|exact_length[10]|is_natural');
                if($this->form_validation->run() === FALSE){
                    $res = ['status' => 200, 'code'=>101, 'message' => 'invalid details.'];
                }
                else{
                    $student_count = $this->db->get_obj('user_auth_detail','user_auth_id',array('mobile'=>$this->input->post('mobile')))->num_rows();
                    if($student_count > 0){
                        $profile_count = $this->db->get_obj('student_info','category_id',array('mobile'=>$this->input->post('mobile')))->num_rows();
                        if($profile_count > 0){
                            $category_id = $this->db->get_obj('student_info','category_id',array('mobile'=>$this->input->post('mobile')))->row()->category_id;
                            $academic_status = $this->db->get_obj('student_info','academic_status',array('mobile'=>$this->input->post('mobile')))->row()->academic_status;
                        }
                        else{
                            $category_id = null;
                            $academic_status = null;
                        }
                        
                        $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('mobile'=>$this->input->post('mobile')))->row();
                        $studentObj->student_id = $studentObj->user_auth_id;
                        $studentObj->email = $studentObj->user_name;
                        $studentObj->category = $category_id;
                        $studentObj->academic_status = $academic_status;
                        unset($studentObj->user_auth_id);
                        unset($studentObj->user_name);
                        $res = ['status'=> 200, 'code'=>102, 'message'=> 'success', 'student'=>$studentObj, 'request'=>'login'];
                    }
                    else{
                        $payload = array(
                            'last_login' => time(),
                            'iss'=> 'localhost',
                            'expiry' => time() + (60),
                            'mobile' => $this->input->post('mobile'),
                            'role_id' => 3
                        );
                        $token = $this->encode($payload);
                        $user_dtail = array(
                            'role_id' => 3,
                            'mobile' => $this->input->post('mobile'),
                            'user_auth_pwd' => password_hash($this->input->post('mobile'),PASSWORD_DEFAULT),
                            'token' => $token,
                            'expiry' => $this->expiry,
                            'last_login' => $this->current_time,
                            'status'=> 1,
                            'iss'=> 'localhost',
                            'create_date' => $this->current_time,
                            'registered_by' => 'Self'
                        );
                        $response = $this->db->insert('user_auth_detail', $user_dtail);
                        $studentObj = $this->db->get_obj('user_auth_detail','name,user_auth_id,mobile,user_name,token',array('mobile'=>$this->input->post('mobile')))->row();
                        $studentObj->name = '';
                        $studentObj->email = '';
                        $studentObj->mobile = $this->input->post('mobile');
                        $studentObj->student_id = $studentObj->user_auth_id;
                        if($response === true){
                            $res = ['status' => 200, 'code'=>105, 'message' => 'success', 'student'=>$studentObj, 'request'=>'registration'];
                        }
                        else{
                            $res = ['status' => 200, 'code'=>104, 'message' => 'error'];
                        }
                    }
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }





//CLASS ENDS
}
