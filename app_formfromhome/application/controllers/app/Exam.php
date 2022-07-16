<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Exam extends MY_Controller{
  public function __construct(){
    parent::__construct();
  }

  public function get_all_exam(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if($this->student_username){
        // CHECK IF STUDENT FILLED THE PROFILE OR NOT.
        $user_status = $this->get_an_obj('student_info', '*', array('student_id'=> $this->student_auth_id), 'row');
        if(is_object($user_status)){
          if($user_status->profile_status == 1 && $user_status->academic_status == 1){
            $today_data = $this->today_date;
            $exam_array = $this->get_an_obj('exam', 'exam_id, name_of_post', array('last_date >=' =>$this->todayDate), 'array');
            $res = $this->app_exam_m->change_keys_to_hashed_key_of_arr($exam_array, 'exam_id');
            $res = ['status'=>200, 'message'=>$res];
            echo json_encode($res);
          }
          if($user_status->academic_status == 0){
            $res = ['status'=>102, 'message'=>'now fill your all your academic details.', 'alink'=>'add-academic', 'page_title'=>'Academic Details.'];
            echo json_encode($res);
          }
        }
        else{
          $res = ['status'=>101, 'message'=>'fill your personal details first.', 'alink'=>'student-profile', 'page_title'=>'Personal Details.'];
          echo json_encode($res);
        }
      }
    }
    else{
      $res = ['status'=>400, 'message'=>'bad request.'];
      echo json_encode($res);
    }
  }

  public function get_exam_detail(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $exam_id = $this->outh_model->Encryptor('decrypt', $this->input->post('exam_id'));
      if($exam_id == false){
        $res = ['status'=>422, 'message'=>'invalid action.'];
        echo json_encode($res);
      }
      else{
        // GETTING EXAM INFO
        $exam_obj = $this->get_an_obj('exam', 'exam_id, name_of_post,post_date,last_date,short_info,content', array('exam_id'=>$exam_id), 'array');
        $res = $this->app_exam_m->change_keys_to_hashed_key_of_arr($exam_obj, 'exam_id');

        // GETTING STUDENT CATEGORY
        $student_obj = $this->get_an_obj('student_info','category_id', array('student_id'=>$this->student_auth_id), 'row');

        // GETTING CATEGORY NAME
        $category_name = $this->get_an_obj('category','category_name', array('category_id'=>$student_obj->category_id), 'row')->category_name;
        // GETTING EXAM PRICE
        $fee_obj = $this->get_an_obj('exam_fee', 'exam_fee', array('exam_id'=>$exam_obj[0]['exam_id'], 'category_id'=>$student_obj->category_id), 'row');
        $service_charge_obj = $this->get_an_obj('service_charges', 'amount', null, 'row');
        $res = ['status'=>422, 'message'=>'ok', 'content'=>$res, 'exam_charge'=>$fee_obj, 'service_charge'=>$service_charge_obj->amount, 'category'=>strtoupper($category_name)];
        echo json_encode($res);
      }
    }
    else{
      $res = ['status'=>400, 'message'=>'bad request.'];
      echo json_encode($res);
    }
  }

// CLASS ENDS
}
