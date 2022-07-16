<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'feedbackListing';
		$data['pageTitle'] = 'feedback list';
		$data['pl'] = null;
		$data['drawTable'] = $this->feedbackTableHead();
		$this->parsed('admin/feedback/index', $data);
	}

	public function feedbackTableHead(){
				$tableHead = array(
					'srno' => 'sr. no.',
					'student name' => 'student name',
					'feedback' => 'feedback',

			);
			return $tableHead;
	}
	public function showFeedback(){
		$json_data = $this->feedback_m->getAllFeedback();
		echo json_encode($json_data);
	}


// CLASS ENDS
}
