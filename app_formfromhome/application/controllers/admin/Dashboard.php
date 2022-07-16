<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{
		$this->data['unviewed'] = $this->db->get_obj('application','*',array('email_status'=>0,'application_status'=>0))->num_rows();
		$this->data['email_pending'] = $this->db->get_obj('application','*',array('email_status'=>0))->num_rows();
		$this->data['form_pending'] = $this->db->get_obj('application','*',array('application_status'=>0))->num_rows();
		$this->data['form_filled'] = $this->db->get_obj('application','*',array('application_status'=>1))->num_rows();
		$this->data['active_application'] = $this->db->get_obj('exam', 'exam_id, name_of_post', array('last_date >=' =>$this->todayDate))->num_rows();
		$this->data['expired_application'] = $this->db->get_obj('exam', 'exam_id, name_of_post', array('last_date <' =>$this->todayDate))->num_rows();

		$this->db->select_sum('total_amount');
		$this->data['total_income'] = $this->db->get_obj('payment_main')->row();

		$this->db->select_sum('service_charge');
		$this->data['commission'] = $this->db->get_obj('application')->row();

		$this->db->select_sum('exam_fee');
		$this->data['total_exam_fee'] = $this->db->get_obj('application')->row();


		$this->data['page_title'] = 'dashboard';
		$this->view('admin/dashboard/dashboard', $this->data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
