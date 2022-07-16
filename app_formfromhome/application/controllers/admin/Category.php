<?php
defined('BASEPATH') or exit('no direct script access allowed');

class Category extends MY_Controller{

	public function index(){
		$data['drawTable'] 	= $this->categoryTableHead();
		$data['pageTitle']	=	'category list';
		$data['tableId']	=	'categorylist';
		$data['pl']			=	'add-category';
		$this->parsed('admin/category/index', $data);
	}
	public function categoryTableHead(){
	      	$tableHead = array(
						'srno' => 'sr. no.',
						'category' => 'category',
						'action' => 'action'
	  		);
	      return $tableHead;
	}
	public function showcategory(){
		$data = $this->category_m->showcategory();
		echo json_encode($data);
	}
	public function add(){
		if($this->input->post('submit1')){
				$this->form_validation->set_rules('category_name','category','required|trim');
				if($this->form_validation->run() == FALSE){
					$this->data['page_title']	=	'add category';
					$this->view('admin/category/add' , $this->data);
				}
				else{
					$data = array(
								'category_name'	=>$this->input->post('category_name')
							);
					$data = $this->toLowerCase($data);
					$category_count	=	$this->category_m->duplicate('category',array('category_name'=>$this->input->post('category_name')));
					if($category_count > 0){
						$this->session->set_flashdata('notification', 'category is already added.');
						redirect('add-category');
					}else{
						$this->category_m->add($data, null);
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
											'title' => 'category Added.',
											'description' => 'A new category is created.'
										);
						$logdata = $this->toLowerCase($log);
						$this->db->insert('logs',$logdata);
						$this->session->set_flashdata('notification', 'category is added.');
						redirect('view-category');
				}
			}

		}else{
		$this->data['page_title']	=	'add category';
		$this->view('admin/category/add' , $this->data);
		}
	}
	public function edit($categoryid){

		$post = $this->input->post();
		if(isset($post['submit1'])){
			$this->form_validation->set_rules('category_name','category','required|trim|alpha');
			if($this->form_validation->run() == FALSE){
				$category_id = $this->outh_model->Encryptor('decrypt', $categoryid);
				$this->data['category']	= $this->get_an_obj_by_id('category','category_id',$category_id)->category_name;
				$this->data['category_id']	= $categoryid;
				$this->data['page_title']	= 'edit category';
				$this->view('admin/category/edit' , $this->data);
			}
			else{
				$category_id = $this->outh_model->Encryptor('decrypt', $categoryid);
				$data = array(
					'category_name' => $this->input->post('category_name')
				);
				$category_count	=	$this->category_m->duplicate('category',array('category_name'=>$this->input->post('category_name')));
				if($category_count > 0){
					$this->session->set_flashdata('notification', 'category is already added.');
					redirect('add-category');
				}else{
				$data = $this->toLowerCase($data);
				$this->category_m->add($data , $category_id);
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
									'title' => 'category updated.',
									'description' => 'A category is updated.'
								);
				$logdata = $this->toLowerCase($log);
				$this->db->insert('logs',$logdata);
				$this->session->set_flashdata('notification', 'category is updated.');
				redirect('view-category');
			}
		}
		}
		$category_id = $this->outh_model->Encryptor('decrypt', $categoryid);
		$this->data['category']	=	$this->get_an_obj_by_id('category','category_id',$category_id)->category_name;
		$this->data['category_id']	=	$categoryid;
		$this->data['page_title']	=	'edit category';
		$this->view('admin/category/edit' , $this->data);

	}





//Class END
}
