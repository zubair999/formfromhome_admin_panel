<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Academic extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function add($id) {
        // print_r($_FILES);
        // die;
        $stu_id = $this->outh_model->Encryptor('decrypt', $id);
        if ($this->input->post('submit1')) {
            $this->form_validation->set_rules($this->admin_academic_m->rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['id'] = $id;
                $this->session->set_flashdata('notification', 'Fill the form correctly.');
                $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
                $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
                $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
                $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
                $this->data['page_title'] = 'Fill your academic details.';
                $this->view('admin/student/academic/add', $this->data);
            } else {
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }
                // CHECK IF DOCUMENT FILES ARE OK TO BE SAVED.
                foreach ($_FILES as $key1 => $img) {
                    $file_type = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png' && $file_type != 'pdf') {
                        $this->session->set_flashdata('notification', 'Only JPG, JPEG, PNG allowed');
                        redirect('a-add-academic');
                    } else if ($img['size'] > 12500000) {
                        $this->session->set_flashdata('notification', 'Only 6Mb file size allowed.');
                        redirect('a-add-academic');
                    }
                }
                $data = array(
                              'qualification_id' => $this->input->post('qualification'),
                              'passing_year' => $this->input->post('year'),
                              'total_marks' => $this->input->post('total_marks'),
                              'marks_obtained' => $this->input->post('marks_obtained'),
                              'percentage' => $this->input->post('percentage'),
                              'board_id' => $this->input->post('board'),
                              'medium_id' => $this->input->post('medium'),
                              'stream_id' => $this->input->post('stream'),
                              'student_id' => $stu_id,
                              'extra_info' => $this->input->post('extra_info')
                            );

                $res = $this->admin_academic_m->add($data, null);
                $last_academic_id = $this->db->insert_id();
                $this->db->set('academic_status', 1);
                $this->db->where('student_id', $stu_id);
                $this->db->update('student_info');


                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/marksheet';
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 10120;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Max File Size:200, Format: JPG, PNG, JPEG, PDF');
                        $this->data['page_title'] = 'send form to student';
                        $this->view('admin/student/academic/add', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                        $marksheet = array('academic_id' => $last_academic_id, 'marksheet_img' => $_FILES[$key1]['name'], 'student_id' => $stu_id);
                        $this->db->insert('marksheet', $marksheet);
                    }
                    $i++;
                }
                $this->session->set_flashdata('notification', 'Academic details are saved.');
                redirect('student-listing');
            }
        } else {
            $this->data['id'] = $id;
            $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
            $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
            $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
            $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
            $this->data['page_title'] = 'Fill your academic details.';
            $this->view('admin/student/academic/add', $this->data);
        }
    }
    public function edit($id) {
        if ($this->input->post('submit1')) {
            $aid = $id;
            $academic_id = $this->outh_model->Encryptor('decrypt', $id);
            $stu_id = $this->db->get_obj('marksheet','student_id',array('academic_id'=>$academic_id))->row()->student_id;


            $this->form_validation->set_rules($this->app_academic_m->rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('academic_id' => $academic_id))->row();
                $document = $this->db->get_obj('marksheet', 'marksheet_img', array('academic_id' => $academic_id))->result_array();
                $this->data['academic_obj']->document = $document;
                // GETTING ALL ACADEMIC MARKSHEET
                $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
                $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
                $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
                $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
                $this->data['id'] = $aid;
                $this->data['page_title'] = 'academic information';
                $this->view('admin/student/academic/edit', $this->data);
            } else {





                  // CHECK IF DOCUMENT FILES ARE OK TO BE SAVED.
                  foreach ($_FILES as $key1 => $img) {
                      $file_type = pathinfo($img['name'], PATHINFO_EXTENSION);
                      if ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png' && $file_type != 'pdf') {
                          $this->session->set_flashdata('notification', 'Only JPG, JPEG, PNG, PDF are allowed');
                          redirect('a-edit-academic/' . $academic_id);
                      } else if ($img['size'] > 12500000) {
                          $this->session->set_flashdata('notification', 'Only 10Mb file size allowed.');
                          redirect('a-edit-academic/' . $academic_id);
                      }
                  }


                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }


                ;



                $academic_data = array(
                              'qualification_id' => $this->input->post('qualification'),
                              'passing_year' => $this->input->post('year'),
                              'total_marks' => $this->input->post('total_marks'),
                              'marks_obtained' => $this->input->post('marks_obtained'),
                              'percentage' => $this->input->post('percentage'),
                              'board_id' => $this->input->post('board'),
                              'medium_id' => $this->input->post('medium'),
                              'stream_id' => $this->input->post('stream'),
                              'extra_info' => $this->input->post('extra_info')
                            );

                $this->db->set($academic_data);
                $this->db->where('academic_id', $academic_id);
                $this->db->update('student_academic');



                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/marksheet';
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 10120;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Max File Size:10 MB, Format: JPG, PNG, JPEG, PDF');
                        $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('student_id' => $stu_id, 'academic_id' => $id))->row();
                        $document = $this->db->get_obj('marksheet', 'marksheet_img', array('student_id' => $stu_id, 'academic_id' => $id))->result_array();
                        $this->data['academic_obj']->document = $document;
                        $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
                        $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
                        $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
                        $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
                        $this->data['id'] = $academic_id;
                        $this->data['page_title'] = 'Fill your academic details.';
                        $this->view('admin/student/academic/edit', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                        $marksheet = array('academic_id' => $academic_id, 'marksheet_img' => $_FILES[$key1]['name'], 'student_id' => $stu_id);
                        $this->db->insert('marksheet', $marksheet);
                    }
                    $i++;
                }
                $this->session->set_flashdata('notification', 'Academic details are updated.');
                redirect('student-listing');
            }
        } else {
            $aid = $id;
            $academic_id = $this->outh_model->Encryptor('decrypt', $id);
            $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('academic_id' => $academic_id))->row();
            $document = $this->db->get_obj('marksheet', 'marksheet_img,marksheet_id', array('academic_id' => $academic_id))->result_array();
            $this->data['academic_obj']->document = $document;

            // GETTING ALL ACADEMIC MARKSHEET
            $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
            $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
            $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
            $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
            $this->data['id'] = $aid;
            $this->data['page_title'] = 'academic information';
            $this->view('admin/student/academic/edit', $this->data);
        }
    }


    public function viewAcademic($id){
      $stu_id = $this->outh_model->Encryptor('decrypt', $id);
      if($stu_id){
        $this->db->select('sa.academic_id,sa.qualification_id,q.qualification_name');
        $this->db->from('student_academic as sa');
        $this->db->join('qualification as q','sa.qualification_id=q.qualification_id');
        $this->db->where('sa.student_id',$stu_id);
        $this->data['student_academic'] = $this->admin_academic_m->change_keys_to_hashed_key_of_arr($this->db->get()->result_array(), 'academic_id');
        $this->data['page_title'] = 'academic information';
        $this->view('admin/student/academic/view', $this->data);
      }
    }

    public function delete_marksheet(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $marksheet_img = $this->db->get_obj('marksheet','marksheet_img',array('marksheet_id'=>$this->input->post('marksheetId')))->row()->marksheet_img;
        if($marksheet_img){
          unlink("uploads/marksheet/" . $marksheet_img);
          $this->db->where('marksheet_id', $this->input->post('marksheetId'));
          $this->db->delete('marksheet');
          $res = ['status'=>200,'message'=>'Marksheet Deleted Successfully.'];
        }
        else{
          $res = ['status'=>200,'message'=>'Something went wrong'];
        }
      }
      else{
        $res = ['status'=>400,'message'=>'bad request'];
      }
      echo json_encode($res);
    }


    


  //END CLASS
}
