<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Textslider extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$data['tableId'] = 'textSliderListing';
        $data['pageTitle'] = 'text slider list';
        $data['pl'] = 'add-text-slider';
        $data['drawTable'] = $this->textSliderTableHead();
        $this->parsed('admin/textslider/index', $data);
	}

	public function textSliderTableHead(){
      	$tableHead = array(
					'srno' => 'sr. no.',
					'result name' => 'text slider text',
					'action' => 'action'
  		);
      return $tableHead;
    }

  public function showTextslider(){
      $json_data = $this->textslider_m->getAllTextSlider();
      echo json_encode($json_data);
  }

	public function add(){
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->textslider_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['page_title'] = 'add text slider';
				$this->view('admin/textslider/add', $this->data);
			} else {
				$data = array(
							'text_slider_text' => $post['slider_text']
						);
				$data = $this->toLowerCase($data);
				$this->textslider_m->add($data, null);
				$date = date('d/m/Y');
				$currentMonth = date('F');
				$currentYear = date('Y');
				$time = date('H:i:s');

				$log	=	array(
									'date' => $date,
									'time'=>	$time,
									'month'	=>	$currentMonth,
									'year'	=>	$currentYear,
									'user_id' => $this->user_id,
									'title' => 'Text Slider Added.',
									'description' => 'A new text slider is created.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'text slider is added.');
				redirect('view-text-slider');
		}
		}
		else{
			$this->data['page_title'] = 'add text slider';
			$this->view('admin/textslider/add', $this->data);
		}
	}

	public function edit($textSliderId)
	{
		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules($this->textslider_m->rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['textSliderId'] = $textSliderId;
				$textSliderId = $this->outh_model->Encryptor('decrypt', $textSliderId);
				$this->data['text_slider'] = $this->get_an_obj_by_id('text_slider', 'text_slider_id', $textSliderId);
				$this->data['page_title'] = 'edit slider text';
				$this->view('admin/textslider/edit', $this->data);
			} else {
				$textSliderId = $this->outh_model->Encryptor('decrypt', $textSliderId);
				$data = array(
							'text_slider_text' => $post['slider_text'],
						);
				
				$data = $this->toLowerCase($data);
				$this->textslider_m->add($data, $textSliderId);
				$date = date('d/m/Y');
				$currentMonth = date('F');
				$currentYear = date('Y');
				$time = date('H:i:s');
				$log =	array(
							'date' => $date,
							'time'=>	$time,
							'month'	=>	$currentMonth,
							'year'	=>	$currentYear,
							'user_id' => $this->user_id,
							'title' => 'text slider updated.',
							'description' => 'A text slider is updated.'
						);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'text slider is updated.');
				redirect('view-text-slider');
		}
		}
		else{
			$this->data['textSliderId'] = $textSliderId;
			$textSliderId = $this->outh_model->Encryptor('decrypt', $textSliderId);
			$this->data['text_slider'] = $this->get_an_obj_by_id('text_slider', 'text_slider_id', $textSliderId);
			$this->data['page_title'] = 'edit slider text';
			$this->view('admin/textslider/edit', $this->data);
		}
	}

	public function delete($textSliderId){
		$textSliderId = $this->outh_model->Encryptor('decrypt', $textSliderId);
		$this->db->where('text_slider_id', $textSliderId);
		$this->db->delete('text_slider');
		$this->session->set_flashdata('notification', 'text slider is deleted successfully.');
		redirect('view-text-slider');
	}



//CLASS ENDS
}
