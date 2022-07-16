<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class ServiceCharge extends REST_Controller {

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

    public function getServiceCharge_get(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $serviceCharge = $this->db->get_obj('service_charges','amount',array('is_active'=>1))->row();
                $this->response($serviceCharge, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }




// CLASS ENDS
}
