<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Certificate extends REST_Controller {
    
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

	public function add_certificate_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules('certificate_name','Certificate', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    $res = ['status'=>404,'message'=>'Enter detail correctly.'];
                }
                else{
                    $allowed_file = $this->allowedFilesAcademic($_FILES);
                    if($allowed_file == false){
                        $res = ['status'=>404,'message'=>'Invalid file format.'];
                    }
                    else{
                        
                        $this->doUpload($_FILES,'uploads/certificates');
                        $data = array(
                            'certificate_name' => $this->input->post('certificate_name'),
                            'certificate_img' => $_FILES['certificate_img']['name'],
                            'student_id' => $this->head()['Student-Id']
                        );



                        $res = $this->app_certificate_m->add($data, null);
                    }   
                    $res = ['status'=>200,'message'=>'Certificate Uploaded Successfully.', 'res'=>$_FILES];

                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }


    public function view_certificate_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $certificate_count = $this->db->get_obj('student_certificate','stu_certificate_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                if($certificate_count > 0){
                    $res = $this->db->get_obj('student_certificate','*',array('student_id'=>$this->head()['Student-Id']))->result_array();
                }
                else{
                    $res = ['status'=>200, 'message'=>'no certificate uploaded.'];
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function delete_certificate_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $certificate_img = $this->db->get_obj('student_certificate','certificate_img',array('stu_certificate_id'=>$this->input->post('certificate_id')))->row()->certificate_img;
                $this->db->where('stu_certificate_id',$this->input->post('certificate_id'));
                if($this->db->delete('student_certificate')){
                    unlink("uploads/certificates/$certificate_img");
                    $res = ['status'=>200,'message'=>'Certificate deleted succesfully.'];
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
}