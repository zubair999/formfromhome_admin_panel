<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Admitcard extends REST_Controller {

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

	public function getadmitcard_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $admit_card = $this->db->get_obj('admitcard', 'admit_card_id, admit_card_name, link')->result_array();
                $response = ['status'=> 200, 'message'=> 'success', 'description'=>'Admit card fetched successfully.', 'data'=>$admit_card];
                $this->response($response, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }



// CLASS ENDS
}
