<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Answerkey extends REST_Controller {

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

	public function getanswerkey_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $answer_key = $this->db->get_obj('answer_key', 'answer_key_id, answer_key_name, link')->result_array();
                $response = ['status'=> 200, 'message'=> 'success', 'description'=>'Answer key fetched successfully.', 'data'=>$answer_key];
                $this->response($response, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }



// CLASS ENDS
}
