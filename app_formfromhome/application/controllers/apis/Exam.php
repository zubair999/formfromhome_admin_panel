<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Exam extends REST_Controller {

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

	public function getexam_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $res = $this->db->get_obj('exam', 'exam_id,name_of_post,post_date,last_date', array('last_date >=' =>$this->todayDate, 'post_date <' =>$this->todayDate))->result_array();
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function getupcomingexam_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $res = $this->db->get_obj('exam', 'exam_id,name_of_post,post_date,last_date', array('post_date >' =>$this->todayDate))->result_array();
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function exam_detail_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
            exit();
        }
        else{

            $exam_obj = $this->db->get_obj('exam', 'content', array('exam_id'=>$this->input->post('exam_id')))->row();
            $exam_fee = $this->db->get_obj('exam_fee','*',array('exam_id'=>$this->input->post('exam_id')))->result_array();

            foreach ($exam_fee as $key => $value) {
                $exam_fee[$key]['value'] = $value['category_id'];
                $exam_fee[$key]['label'] = $value['category_name'];
                unset($exam_fee['category_id']);
                unset($exam_fee['category_name']);
            }


            $res = ['status'=>200, 'content'=>$exam_obj->content, 'exam_fee'=>$exam_fee];
            $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
    }



// CLASS ENDS
}
