<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Notification extends REST_Controller {

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

    // public function getNotification_get(){
    //     $method = $this->_detect_method();
    //     if (!$method == 'GET') {
    //         $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
    //     }
    //     else{
    //         $check_auth_client = $this->auth_model->check_auth_client($this->head());
    //         if($check_auth_client === true){
    //             $application_count = $this->db->get_obj('application','application_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
    //             if($application_count > 0){
    //                 $this->db->select('application.application_id,
    //                                     application.exam_fee,
    //                                     application.service_charge,
    //                                     application.date,
    //                                     application.application_status,
    //                                     exam.name_of_post');
    //                 $this->db->from('application');
    //                 $this->db->where('application.student_id',$this->head()['Student-Id']);
    //                 $this->db->where('application.email_status',1);
    //                 $this->db->where('application.application_status',1);
    //                 $this->db->join('exam','exam.exam_id=application.exam_id');
    //                 $res = $this->db->get()->result_array();
    //             }
    //             else{
    //                 $res = ['status'=>200,'message'=>'No application found.'];
    //             }
    //             $this->response($res, REST_Controller::HTTP_OK);
    //         }
    //         $this->response($check_auth_client, REST_Controller::HTTP_OK);
    //     }
    // }


    public function getNotification_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $application_count = $this->db->get_obj('application','application_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                if($application_count > 0){
                    $this->db->select('application.application_id,
                                        exam.name_of_post,
                                        application.viewed_by_student');
                    $this->db->from('application');
                    $this->db->where('application.student_id',$this->head()['Student-Id']);
                    $this->db->where('application.email_status',1);
                    $this->db->where('application.application_status',1);
                    $this->db->where('application.viewed_by_student',0);
                    $this->db->join('exam','exam.exam_id=application.exam_id');
                    $application = $this->db->get();
                    $completedApplicationCount = $application->num_rows();
                    if($completedApplicationCount > 0){
                        $res = $application->result_array();
                        foreach ($res as $key => $value) {
                          $this->db->set('viewed_by_student',1);
                          $this->db->where('application_id',$value['application_id']);
                          $this->db->update('application');
                        }
                    }
                    else{
                        $res = ['status'=>200,'message'=>'No more pending application.'];
                    }
                }
                else{
                    $res = ['status'=>200,'message'=>'No application found.'];
                }
                $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }




// CLASS ENDS
}
