<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class State extends REST_Controller {

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

    public function getState_get(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $this->db->order_by('state_name','asc');
                $categoryArr = $this->db->get_obj('state')->result_array();

                foreach ($categoryArr as $key => $value) {
                    $categoryArr[$key]['value'] = $value['state_id'];
                    $categoryArr[$key]['label'] = ucwords($value['state_name']);
                    unset($categoryArr[$key]['state_id']);
                    unset($categoryArr[$key]['state_name']);
                }
                $this->response($categoryArr, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }




// CLASS ENDS
}
