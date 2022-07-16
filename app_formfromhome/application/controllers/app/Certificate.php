<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Certificate extends MY_Controller{

  public function add(){
    if($this->input->post('submit1')){
      $pt = $this->input->post();
      $this->form_validation->set_rules('certificate_name','certificate name','required|alpha_numeric_space');
      if($this->form_validation->run() == FALSE){
        $this->data['page_title'] = 'certificate';
        $this->app_view('app/certificate/add',$this->data);
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
            $this->data['page_title']	= 'send form to student';
            $this->view('app/certificate/add' , $this->data);
          }
          else {
            array('upload_data' => $this->upload->data());
            $data = array(
              'certificate_name'=>$pt['certificate_name'],
              'certificate_img'=> $_FILES[$key1]['name'],
              'student_id' => $this->student_auth_id
            );
            $this->app_certificate_m->add($data, null);
          }
          $i++;
        }
        $this->session->set_flashdata('notification', 'Document Added Successfully.');
        redirect('add-certificate');
      }
    }
    else{
        $this->data['page_title'] = 'add certificate/Other docs';
        $this->app_view('app/certificate/add',$this->data);
    }
  }

  public function edit($certificate_id){
    $id =  $this->student_m->outh_model->Encryptor('decrypt',$certificate_id);

    if($this->input->post('submit1')){
      $pt = $this->input->post();
      $this->form_validation->set_rules('certificate_name','certificate name','required|alpha_numeric_space');
      if($this->form_validation->run() == FALSE){
        $this->data['certificate_id'] = $certificate_id;
         $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id'=>$id))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->app_view('app/certificate/edit',$this->data);
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
        $doc_name = $this->db->get_obj('student_certificate', '*', array('stu_certificate_id' => $id))->row()->certificate_img;
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
             $this->data['certificate_id'] = $certificate_id;
         $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id'=>$id))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->app_view('app/certificate/edit',$this->data);
          }
          else {
            array('upload_data' => $this->upload->data());
            $data = array(
              'certificate_name'=>$pt['certificate_name'],
              'certificate_img'=> $_FILES[$key1]['name']
            );
            $this->app_certificate_m->add($data, $id);
          }
          $i++;
        }
        $this->session->set_flashdata('notification', 'Document Updated Successfully.');
        redirect('edit-certificate/'.$certificate_id);
      }
    }
    else{
        $this->data['certificate_id'] = $certificate_id;
        $this->data['certificate_obj'] = $this->db->get_obj('student_certificate','*',array('stu_certificate_id'=>$id))->row();
        $this->data['page_title'] = 'edit certificate/Other docs';
        $this->app_view('app/certificate/edit',$this->data);
    }
  }





//END CLASS
}
