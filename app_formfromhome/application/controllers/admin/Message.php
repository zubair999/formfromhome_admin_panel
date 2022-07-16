<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function compose(){
    	$data['page_title'] = 'compose notification message';
        $this->view('admin/message/compose', $data);
    }
    public function send_email(){
    	$receiver = $this->input->post('to');
    	$subject = $this->input->post('subject');
    	$message = $this->input->post('message');
    	$this->sendEmail($message,$subject,$receiver);
        $this->session->set_flashdata('notification','Email Sent Successfully');
        redirect('compose');	
    }

// CLASS ENDS
}