<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends MY_Controller{

  public function __construct(){
    parent::__construct();
  }

  public function feedback(){

    if($this->input->post('submit1')){
      $data = array(
        'student_id'=>$this->student_auth_id,
        'feedback'=>$this->input->post('feedback')
      );
      $this->db->insert('feedback',$data);
      $this->session->set_flashdata('notification','Your feedback sent successfully.');
      redirect('app-root');
    }
    else{
      $this->data['page_title'] = 'Give your feedback';
      $this->app_view('app/feedback/givefeedback',$this->data);
    }


  }

// CLASS ENDS
}
