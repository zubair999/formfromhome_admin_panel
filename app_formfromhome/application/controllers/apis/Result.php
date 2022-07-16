<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Result extends REST_Controller {

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

	public function getresult_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $result = $this->db->get_obj('result', 'result_id,result_name,link')->result_array();
                $response = ['status'=> 200, 'message'=> 'success', 'description'=>'Result fetched successfully.', 'data'=>$result];
                $this->response($response, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }



// CLASS ENDS
}
