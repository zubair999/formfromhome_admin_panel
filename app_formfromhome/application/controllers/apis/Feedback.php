<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Feedback extends REST_Controller {
    
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

	public function saveFeedback_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->form_validation->set_rules('feedback', 'Feedback', 'trim|required|alpha_numeric_space');
                if($this->form_validation->run() === FALSE){
                    $res = ['status'=>200, 'code'=>101 ,'message'=>'Specials charactor are not allowed.'];
                }
                else{
                    $data = array(
                        'student_id'=>$this->head()['Student-Id'],
                        'feedback'=>$this->input->post('feedback')
                    );

                    $response = $this->db->insert('feedback', $data);
                    if($response === true){
                        $res = ['status'=>200, 'code'=>102, 'message'=>'Feedback sent successfully.'];                   
                    }
                    else{
                        $res = ['status'=>200, 'code'=>103, 'message'=>'Something went wrong. try Again'];   
                    }

                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }


    
    
      
    	
}