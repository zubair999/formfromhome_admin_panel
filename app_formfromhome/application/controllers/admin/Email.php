<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function compose(){
    	$data['page_title'] = 'compose email';
        $this->view('admin/email/compose', $data);
    }


    
    public function send_email(){
    	$receiver = $this->input->post('to');
    	$subject = $this->input->post('subject');
        $this->data['message'] = $this->input->post('message');
        $html = $this->load->view('admin/components/email/default',$this->data,true);
        $imgUrl = base_url('/uploads/marksheet/');
        $filename = '2020-04-27-084215_1.jpg';
    	$this->sendEmailWithAttachment($html, $receiver, $subject, $imgUrl, $filename);
        $this->session->set_flashdata('notification','Email Sent Successfully');
        redirect('compose');	
    }

    

// CLASS ENDS
}