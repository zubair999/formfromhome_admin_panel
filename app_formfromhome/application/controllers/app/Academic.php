<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academic extends MY_Controller{

  public function __construct(){
    parent::__construct();
  }

  public function add(){
    if($this->input->post('submit1')){
      $this->form_validation->set_rules($this->app_academic_m->rules);
      if($this->form_validation->run() == FALSE){
        $this->session->set_flashdata('notification', 'Fill the form correctly.');
        $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
        $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
        $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
        $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
        $this->data['page_title'] = 'Fill your academic details.';
        $this->app_view('app/academic/add', $this->data);
      }
      else{
        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $i++;
        }
        // CHECK IF DOCUMENT FILES ARE OK TO BE SAVED.
        foreach ($_FILES as $key1 => $img) {
          $file_type = pathinfo($img['name'], PATHINFO_EXTENSION);
          if($file_type != 'jpg' && $file_type !='jpeg' && $file_type !='png' && $file_type !='pdf'){
            $this->session->set_flashdata('notification', 'Only JPG, JPEG, PNG allowed');
            redirect('add-academic');
          }
          else if($img['size'] > 12500000){
            $this->session->set_flashdata('notification', 'Only 6Mb file size allowed.');
            redirect('add-academic');
          }
        }

        $data = array(
          'qualification_id'=> $this->input->post('qualification'),
          'passing_year'=> $this->input->post('year'),
          'total_marks'=> $this->input->post('total_marks'),
          'marks_obtained'=> $this->input->post('marks_obtained'),
          'percentage'=> $this->input->post('percentage'),
          'board_id'=> $this->input->post('board'),
          'medium_id'=> $this->input->post('medium'),
          'stream_id'=> $this->input->post('stream'),
          'student_id'=> $this->student_auth_id,
          'extra_info'=> $this->input->post('extra_info')
        );

        $res = $this->app_academic_m->add($data, null);
        $last_academic_id = $this->db->insert_id();
        $this->db->set('academic_status',1);
        $this->db->where('student_id',$this->student_auth_id);
        $this->db->update('student_info');

        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $upload_url = 'uploads/marksheet';
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $config['upload_path']          = $upload_url;
          $config['allowed_types']        = 'jpg|jpeg|png|pdf';
          $config['max_size']             = 10120;
          $config['max_width']            = 4000;
          $config['max_height']           = 4000;
          $this->load->library('upload', $config);
          if ( ! $this->upload->do_upload($key1)) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('notification', 'Max File Size:200, Format: JPG, PNG, JPEG, PDF');
            $this->data['page_title']	= 'send form to student';
            $this->view('app/academic/add' , $this->data);
          }
          else {
            array('upload_data' => $this->upload->data());
            $marksheet = array(
              'academic_id'=>$last_academic_id,
              'marksheet_img'=>$_FILES[$key1]['name'],
              'student_id'=>$this->student_auth_id
            );
            $this->db->insert('marksheet', $marksheet);
          }
          $i++;
        }
        $this->session->set_flashdata('notification', 'Academic details are saved.');
        redirect('add-academic');
      }
    }
    else{
      $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
      $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
      $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
      $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
      $this->data['page_title'] = 'Fill your academic details.';
      $this->app_view('app/academic/add', $this->data);
    }
  }
}
