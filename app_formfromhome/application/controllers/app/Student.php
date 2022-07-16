<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Student extends MY_Controller {

    public function __construct(){
      parent::__construct();
    }

    public function add_student_profile() {
        if ($this->input->post('submit1') == "Save Details") {
            $this->form_validation->set_rules($this->app_student_m->rules);
            $this->form_validation->set_message('alpha_numeric_space', 'Only alphanumeric values allowed. No special Charactor allowed.');
            if ($this->form_validation->run() == FALSE) {
                $this->data['state'] = $this->db->get_obj('state')->result_array();
                $this->data['info_count'] = $this->db->get_where('student_info', array('student_id' => $this->student_auth_id))->num_rows();
                $this->data['student_category'] = $this->db->get_obj('category')->result_array();
                $this->data['page_title'] = 'Fill your profile details.';
                $this->app_view('app/student/profile', $this->data);
            } else {
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }
                // CHECKING IF FILES ARE ALLOWED OR NOT
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                        $this->session->set_flashdata('notification', 'Invalid file format');
                        redirect('student-profile');
                    }
                    // if ($img['size'] > 50000) {
                    //     $this->session->set_flashdata('notification', 'Max File Size allowed: 50KB');
                    //     redirect('student-profile');
                    // }
                }
                $data = array('student_name' => $this->input->post('student_name'), 'mobile' => $this->input->post('mobile'), 'father_name' => $this->input->post('father_name'), 'mother_name' => $this->input->post('mother_name'),'role_id' => 3, 'profile_status' => 1, 'student_id' => $this->student_auth_id, 'dob' => $this->input->post('dob'), 'gender' => $this->input->post('gender'), 'category_id' => $this->input->post('category_name'), 'house' => $this->input->post('house'), 'block' => $this->input->post('block'), 'district' => $this->input->post('district'), 'state' => $this->input->post('state'), 'pincode' => $this->input->post('pincode'), 'address' => $this->input->post('address'), 'student_img' => $_FILES['student_img']['name'], 'signature_img' => $_FILES['student_sign']['name'], 'thumb_img' => $_FILES['thumb_img']['name']);
                $res = $this->app_student_m->add($data, null);
                $data = array('status' => 1);
                $this->app_auth_m->add($data, $this->student_auth_id);
                $this->session->set_flashdata('notification', 'Profile is set now.');
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/student';
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 10000000;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Something went wrong.');
                        $this->data['page_title'] = 'send form to student';
                        $this->app_view('app/student/profile', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                    }
                    $i++;
                }

                $this->db->set('mobile',$this->input->post('mobile'));
                $this->db->where('user_auth_id',$this->student_auth_id);
                $this->db->update('user_auth_detail');

                redirect('app-root');
            }
        } else {
            // CHECKING IF STUDENT PROFILE ALREADY SET.
            $this->data['info_count'] = $this->db->get_where('student_info', array('student_id' => $this->student_auth_id))->num_rows();
            $this->data['state'] = $this->db->get_obj('state')->result_array();
            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
            $this->data['stu_info_id'] = $this->outh_model->Encryptor('encrypt', $this->student_auth_id);
            $this->data['page_title'] = 'Fill your profile details.';
            $this->app_view('app/student/profile', $this->data);
        }
    }
    public function view_profile() {
        $s_id = $this->student_auth_id;
        $this->data['stu_row'] = $this->db->get_where('student_info', array('student_id' => $s_id))->num_rows();
        $this->data['page_title'] = 'personal information.';
        $this->data['student_info'] = $this->db->get_obj('student_info', 'student_info.student_name,
                                                       student_info.info_id,
                                                       student_info.student_id,
                                                       student_info.mobile,
                                                       student_info.gender,
                                                       student_info.dob,
                                                       student_info.father_name,
                                                       student_info.mother_name,
                                                       student_info.student_img,
                                                       student_info.signature_img,
                                                       student_info.thumb_img,
                                                       student_info.house,
                                                       student_info.block,
                                                       student_info.district,
                                                       student_info.state,
                                                       student_info.address,
                                                       student_info.pincode,
                                                       category.category_name
                                                      ', array('student_info.student_id' => $this->student_auth_id), array('category' => 'student_info.category_id=category.category_id'))->row();
        $this->app_view('app/student/view-profile', $this->data);
    }
    public function personal_details() {
        $this->data['page_title'] = 'view profile';
        $this->app_view('app/student/personalDetails', $this->data);
    }
    //academic
    public function view_academic() {
        $s_id = $this->student_auth_id;
        $this->data['stu_row'] = $this->db->get_where('student_info', array('student_id' => $s_id))->num_rows();
        $this->data['page_title'] = 'academic information';
        $this->data['academicArr'] = $this->app_student_m->view_academic();
        $this->app_view('app/student/view-academic', $this->data);
    }
    public function edit_academic($academic_id) {
        if ($this->input->post('submit1') == 'Update Details') {

            $id = $this->outh_model->Encryptor('decrypt', $academic_id);
            $this->form_validation->set_rules($this->app_academic_m->rules);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('notification', 'Fill the form correctly.');
                $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->row();
            $document = $this->db->get_obj('marksheet', 'marksheet_img', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->result_array();
            $this->data['academic_obj']->document = $document;
                $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
                $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
                $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
                $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
                $this->data['id'] = $academic_id;
                $this->data['page_title'] = 'Fill your academic details.';
                $this->app_view('app/student/edit-academic', $this->data);
            } else {

                // DELETING OLD MARKSHEET SAVED IN DATABASE.
                $marksheet_arr = $this->db->get_obj('marksheet', 'marksheet_id,marksheet_img', array('student_id' => $this->student_auth_id,'academic_id'=>$id))->result_array();

                foreach ($marksheet_arr as $key => $value) {
                  unlink("uploads/marksheet/".$value['marksheet_img']);
                }

                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }
                // CHECK IF DOCUMENT FILES ARE OK TO BE SAVED.
                foreach ($_FILES as $key1 => $img) {
                    $file_type = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png') {
                        $this->session->set_flashdata('notification', 'Only JPG, JPEG, PNG, PDF are allowed');
                        redirect('edit-academic/' . $academic_id);
                    } else if ($img['size'] > 12500000) {
                        $this->session->set_flashdata('notification', 'Only 10Mb file size allowed.');
                        redirect('edit-academic/' . $academic_id);
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
                  'extra_info' => $this->input->post('extra_info')
                );

                $this->db->set($data);
                $this->db->where('academic_id', $id);
                $this->db->update('student_academic');

                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/marksheet';
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 10120;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Max File Size:10 MB, Format: JPG, PNG, JPEG, PDF');
                        $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->row();
                    $document = $this->db->get_obj('marksheet', 'marksheet_img', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->result_array();
                    $this->data['academic_obj']->document = $document;
                        $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
                        $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
                        $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
                        $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
                        $this->data['id'] = $academic_id;
                        $this->data['page_title'] = 'Fill your academic details.';
                        $this->app_view('app/student/edit-academic', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                        $marksheet = array('marksheet_img' => $_FILES[$key1]['name']);
                        $this->db->set($marksheet);
                        $this->db->where(['academic_id'=>$id, 'marksheet_id'=>$marksheet_arr[$i]['marksheet_id']]);
                        $this->db->update('marksheet');
                    }
                    $i++;
                }
                $this->session->set_flashdata('notification', 'Academic details are updated.');
                redirect('academic-details');
            }
        } else {
            $id = $this->outh_model->Encryptor('decrypt', $academic_id);
            $this->data['academic_obj'] = $this->db->get_obj('student_academic', '*', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->row();
            $document = $this->db->get_obj('marksheet', 'marksheet_img', array('student_id' => $this->student_auth_id, 'academic_id' => $id))->result_array();
            $this->data['academic_obj']->document = $document;
            // GETTING ALL ACADEMIC MARKSHEET
            $this->data['qualification_arr'] = $this->db->get_obj('qualification')->result_array();
            $this->data['board_arr'] = $this->db->get_obj('board')->result_array();
            $this->data['medium_arr'] = $this->db->get_obj('mediam')->result_array();
            $this->data['stream_arr'] = $this->db->get_obj('stream')->result_array();
            $this->data['id'] = $academic_id;
            $this->data['page_title'] = 'academic information';
            $this->app_view('app/student/edit-academic', $this->data);
        }
    }
    //certificates
    public function view_certificate() {
        $this->data['stu_row'] = $this->db->get_where('student_certificate', array('student_id' => $this->student_auth_id))->num_rows();
        $this->data['page_title'] = 'certificates/Docs information';
        $this->data['certificateArr'] = $this->db->get_obj('student_certificate', '*', array('student_id'=>$this->student_auth_id))->result_array();
        $this->data['certificateArr'] = $this->app_student_m->change_keys_to_hashed_key_of_arr($this->data['certificateArr'],'stu_certificate_id');
        $this->app_view('app/student/view-certificates', $this->data);
    }
    public function edit_profile($id) {
        if ($this->input->post('edit1') == "Update Details") {
            $this->form_validation->set_rules($this->app_student_m->rules);
            $this->form_validation->set_message('alpha_numeric_space', 'Only alphanumeric values allowed. No special Charactor allowed.');
            if ($this->form_validation->run() == FALSE) {
                $this->data['id'] = $id;
                $student_id = $this->outh_model->Encryptor('decrypt', $id);
                $this->data['stu_data'] = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();
                $this->data['student_category'] = $this->db->get_obj('category')->result_array();
                $this->data['state'] = $this->db->get_obj('state')->result_array();
                $this->data['page_title'] = 'edit your profile details.';
                $this->app_view('app/student/edit-profile', $this->data);
            } else {
                // GETTING STUDENT ID.
                $student_id = $this->outh_model->Encryptor('decrypt', $id);
                // DELETING OLD FILES SAVED IN DATABASE.
                $student_info_obj = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();



                unlink("uploads/student/$student_info_obj->student_img");
                unlink("uploads/student/$student_info_obj->signature_img");
                unlink("uploads/student/$student_info_obj->thumb_img");



               
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $i++;
                }
                $data = array('student_name' => $this->input->post('student_name'), 'mobile' => $this->input->post('mobile'), 'father_name' => $this->input->post('father_name'), 'mother_name' => $this->input->post('mother_name'),'dob' => $this->input->post('dob'), 'gender' => $this->input->post('gender'), 'category_id' => $this->input->post('category_name'), 'house' => $this->input->post('house'), 'block' => $this->input->post('block'), 'district' => $this->input->post('district'), 'state' => $this->input->post('state'), 'pincode' => $this->input->post('pincode'), 'address' => $this->input->post('address'), 'student_img' => $_FILES['student_img']['name'], 'signature_img' => $_FILES['student_sign']['name'], 'thumb_img' => $_FILES['thumb_img']['name']);
                $this->db->set($data);
                $this->db->where('student_id', $student_id);
                $this->db->update('student_info');
                $this->session->set_flashdata('notification', 'Profile updated successfully.');
                $i = 0;
                foreach ($_FILES as $key1 => $img) {
                    $upload_url = 'uploads/student';
                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
                    $config['upload_path'] = $upload_url;
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 100000;
                    $config['max_width'] = 4000;
                    $config['max_height'] = 4000;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key1)) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('notification', 'Max File Size:200, Format: JPG, PNG, JPEG');
                        $this->data['page_title'] = 'send form to student';
                        $this->app_view('app/student/profile', $this->data);
                    } else {
                        array('upload_data' => $this->upload->data());
                    }
                    $i++;
                }

                $this->db->set('mobile',$this->input->post('mobile'));
                $this->db->where('user_auth_id',$this->student_auth_id);
                $this->db->update('user_auth_detail');

                redirect('app-root');
            }
        } else {
            $this->data['id'] = $id;
            $student_id = $this->outh_model->Encryptor('decrypt', $id);
            $this->data['stu_data'] = $this->db->get_obj('student_info', '*', array('student_id' => $student_id))->row();
            $this->data['student_category'] = $this->db->get_obj('category')->result_array();
            $this->data['state'] = $this->db->get_obj('state')->result_array();
            $this->data['page_title'] = 'edit your profile details.';
            $this->app_view('app/student/edit-profile', $this->data);
        }
    }

// CLASS ENDS
}
