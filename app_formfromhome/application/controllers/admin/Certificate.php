<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Certificate extends MY_Controller{

  public function add($stu_id){
    $d_sid =  $this->student_m->outh_model->Encryptor('decrypt',$stu_id);

    if($this->input->post('submit1')){
      $pt = $this->input->post();
      $this->form_validation->set_rules('certificate_name','certificate name','required|alpha_numeric_space');
      if($this->form_validation->run() == FALSE){
        $this->data['page_title'] = 'add certificate/Other docs';
        $this->data['id'] = $stu_id;
        $this->view('admin/student/certificate/add',$this->data);
      }
      else{
        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $i++;
        }

        // CHECKING FILE SIZE
        foreach ($_FILES as $key1 => $img) {
          $file_size = (float)$_FILES[$key1]['size']/1024;
          // if($file_size > 30){
          //   $this->session->set_flashdata('notification', 'Max File Size: 30KB.');
          //   redirect('add-certificate');
          // }
          $i++;
        }

        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $upload_url = 'uploads/certificates';
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $config['upload_path']          = $upload_url;
          $config['allowed_types']        = 'jpg|jpeg|png|pdf';
          $config['max_size']             = 100000;
          $config['max_width']            = 4000;
          $config['max_height']           = 4000;
          $this->load->library('upload', $config);
          if ( ! $this->upload->do_upload($key1)) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('notification', 'Max File Size:10MB, Format: JPG, PNG, JPEG, PDF');
            $this->data['page_title'] = 'send form to student';
            $this->view('admin/student/certificate/add' , $this->data);
          }
          else {
            array('upload_data' => $this->upload->data());
            $data = array(
              'certificate_name'=>$pt['certificate_name'],
              'certificate_img'=> $_FILES[$key1]['name'],
              'student_id' => $d_sid
            );
            $this->db->insert('student_certificate', $data);
            $this->db->set('certificate_status',1);
            $this->db->where('student_id',$d_sid);
            $this->db->update('student_info');
          }
          $i++;
        }
        $this->session->set_flashdata('notification', 'certificate Added Successfully.');
        redirect('student-listing');
      }
    }
    else{
        $this->data['page_title'] = 'add certificate/Other docs';
        $this->data['id'] = $stu_id;
        $this->view('admin/student/certificate/add',$this->data);
    }
  }

  public function edit($certificate_id){
    $certificate_id =  $this->outh_model->Encryptor('decrypt',$certificate_id);

    if($this->input->post('submit1')){

      
      $pt = $this->input->post();
      $this->form_validation->set_rules('certificate_name','certificate name','required|alpha_numeric_space');
      if($this->form_validation->run() == FALSE){
        $this->data['id'] = $stu_id;
         $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id'=>$certificate_id))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->view('admin/student/certificate/edit',$this->data);
      }
      else{

        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $i++;
        }

        // CHECKING FILE SIZE
        foreach ($_FILES as $key1 => $img) {
          $file_size = (float)$_FILES[$key1]['size']/1024;
          // if($file_size > 30){
          //   $this->session->set_flashdata('notification', 'Max File Size: 30KB.');
          //   redirect('add-certificate');
          // }
          $i++;
        }
        $doc_name = $this->db->get_obj('student_certificate', '*', array('stu_certificate_id' => $certificate_id))->row()->certificate_img;
        unlink("uploads/certificates/$doc_name");

        $i = 0;
        foreach ($_FILES as $key1 => $img) {
          $upload_url = 'uploads/certificates';
          $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
          $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() .$i. '.' . $ext;
          $config['upload_path']          = $upload_url;
          $config['allowed_types']        = 'jpg|jpeg|png';
          $config['max_size']             = 100000;
          $config['max_width']            = 4000;
          $config['max_height']           = 4000;
          $this->load->library('upload', $config);
          if ( ! $this->upload->do_upload($key1)) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('notification', 'Max File Size:30KB, Format: JPG, PNG, JPEG');
             $this->data['id'] = $stu_id;
         $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id' => $stu_cer_id,'student_id'=>$d_sid))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->view('admin/student/certificate/edit',$this->data);
          }
          else {
            array('upload_data' => $this->upload->data());
            $data = array(
              'certificate_name'=>$pt['certificate_name'],
              'certificate_img'=> $_FILES[$key1]['name']
            );
            $this->db->where('student_id', $d_sid);
            $this->db->update('student_certificate', $data);
          }
          $i++;
        }
        $this->session->set_flashdata('notification', 'Document Updated Successfully.');
        redirect('student-listing');
      }
    }
    else{
        
         $this->data['id'] = $certificate_id;
         $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id'=>$certificate_id))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->view('admin/student/certificate/edit',$this->data);
    }
  }


  public function viewCertificate($id){
      $stu_id = $this->outh_model->Encryptor('decrypt', $id);
      if($stu_id){
        $certificateArr = $this->db->get_obj('student_certificate','*',array('student_id'=>$stu_id))->result_array();
        $this->data['student_certificate'] = $this->admin_academic_m->change_keys_to_hashed_key_of_arr($certificateArr, 'stu_certificate_id');
        $this->data['page_title'] = 'certificate information';
        $this->view('admin/student/certificate/view', $this->data);
      }
    }

    public function delete_certificate(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $certificate_img = $this->db->get_obj('student_certificate','certificate_img',array('stu_certificate_id'=>$this->input->post('certificateId')))->row()->certificate_img;
        if($certificate_img){
          unlink("uploads/certificates/" . $certificate_img);
          $this->db->where('stu_certificate_id', $this->input->post('certificateId'));
          $this->db->delete('student_certificate');
          $res = ['status'=>200,'message'=>'Certificate Deleted Successfully.'];
        }
        else{
          $res = ['status'=>200,'message'=>'Something went wrong'];
        }
      }
      else{
        $res = ['status'=>400,'message'=>'bad request'];
      }
      $res = ['status'=>200,'message'=>'ok','certificateId'=>$this->input->post('certificateId')];
      echo json_encode($res);
    }

//END CLASS
}
