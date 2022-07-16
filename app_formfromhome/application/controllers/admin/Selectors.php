<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Selectors extends MY_Controller{

  	public function __construct()
  	{
  		parent::__construct();
  	}

  public function index_board(){
        $data['tableId'] = 'boardListing';
        $data['pageTitle'] = 'board list';
        $data['pl'] = 'add-board';
        $data['drawTable'] = $this->boardTableHead();
        $this->parsed('admin/selectors/index-board', $data);
  }
  public function boardTableHead()
    {
        $tableHead = array(
          'srno' => 'sr. no.',
          'state name' => 'board name',
          'action' => 'action'
      );
      return $tableHead;
    }
  public function showboard(){
   $json_data = $this->selectors_m->showboard();
   echo json_encode($json_data);
  }

  public function add_board(){
    $post = $this->input->post();
    if(isset($post['submit1'])){
      $this->form_validation->set_rules('board_name','board name','trim|required');
      if($this->form_validation->run() == FALSE)
      {
        $this->data['page_title'] = 'add board';
        $this->view('admin/selectors/add-board', $this->data);
      }else{
        $data = array(
              'board_name' => $post['board_name']
        );
        $board_count	=	$this->category_m->duplicate('board',array('board_name'=>$this->input->post('board_name')));
        if($board_count > 0){
          $this->session->set_flashdata('notification', 'board is already added.');
          redirect('add-board');
        }else{
        $data = $this->tolowercase($data);
        $this->db->insert('board',$data);
        $date = date('d/m/Y');
        $currentMonth = date('F');
        $currentYear = date('Y');
        $time = date('H:i:s');
        $log  = array(
                  'date' => $date,
                  'time'=>  $time,
                  'month' =>  $currentMonth,
                  'year'  =>  $currentYear,
                  'user_id' => $this->user_id,
                  'title' => 'board Added.',
                  'description' => 'A new board is created.'
                );
        $logdata = $this->toLowerCase($log);
        $this->db->insert('logs',$logdata);
        $this->session->set_flashdata('notification', 'board is added.');
        redirect('view-board');
      }
      }
    }
    $this->data['page_title'] = 'add board';
    $this->view('admin/selectors/add-board', $this->data);


  }
  public function edit_board($boardId)
  {
    $post = $this->input->post();
    if(isset($post['submit1'])){
      $this->form_validation->set_rules('board_name','board name','trim|required');
      if ($this->form_validation->run() == FALSE) {
        $this->data['boardId'] = $boardId;
        $boardId = $this->outh_model->Encryptor('decrypt', $boardId);
        $this->data['board_name'] = $this->get_an_obj_by_id('board', 'board_id', $boardId)->board_name;
        $this->data['page_title'] = 'edit board';
        $this->view('admin/selectors/edit-board', $this->data);
      } else {
        $boardId = $this->outh_model->Encryptor('decrypt', $boardId);
        $data = array(
              'board_name' => $post['board_name']
            );
        $board_count	=	$this->category_m->duplicate('board',array('board_name'=>$this->input->post('board_name')));
        if($board_count > 0){
          $this->session->set_flashdata('notification', 'board is already added.');
          redirect('add-board');
        }else{
        $data = $this->toLowerCase($data);
        $this->selectors_m->add($data, $boardId);
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
                  'title' => 'board updated.',
                  'description' => 'A board is updated.'
                );
        $logdata = $this->toLowerCase($log);
        $this->db->insert('logs',$logdata);
        $this->session->set_flashdata('notification', 'board is updated.');
        redirect('view-board');
      }
      }
    }
    else{
      $this->data['boardId'] = $boardId;
      $boardId = $this->outh_model->Encryptor('decrypt', $boardId);
      $this->data['board_name'] = $this->get_an_obj_by_id('board', 'board_id', $boardId)->board_name;
      $this->data['page_title'] = 'edit board';
      $this->view('admin/selectors/edit-board', $this->data);
    }
  }

  public function add_stream(){
    $post = $this->input->post();
    if(isset($post['submit1'])){
      $this->form_validation->set_rules('stream_name','board name','trim|required');
      if($this->form_validation->run() == FALSE)
      {
        $this->data['page_title'] = 'add stream';
        $this->view('admin/selectors/add-stream', $this->data);
      }else{
        $data = array(
              'stream_name' => $post['stream_name']
        );
        $stream_count	=	$this->selectors_m->duplicate('stream',array('stream_name'=>$this->input->post('stream_name')));
        if($stream_count > 0){
          $this->session->set_flashdata('notification', 'stream is already added.');
          redirect('add-stream');
        }else{
        $data = $this->tolowercase($data);
        $this->db->insert('stream',$data);
        $date = date('d/m/Y');
        $currentMonth = date('F');
        $currentYear = date('Y');
        $time = date('H:i:s');
        $log  = array(
                  'date' => $date,
                  'time'=>  $time,
                  'month' =>  $currentMonth,
                  'year'  =>  $currentYear,
                  'user_id' => $this->user_id,
                  'title' => 'stream Added.',
                  'description' => 'A new stream is created.'
                );
        $logdata = $this->toLowerCase($log);
        $this->db->insert('logs',$logdata);
        $this->session->set_flashdata('notification', 'stream is added.');
        redirect('view-stream');
      }
      }

    }
    $this->data['page_title'] = 'add stream';
    $this->view('admin/selectors/add-stream', $this->data);


  }
  public function index_stream(){

    $data['tableId'] = 'streamListing';
    $data['pageTitle'] = 'stream list';
    $data['pl'] = 'add-stream';
    $data['drawTable'] = $this->streamTableHead();
    $this->parsed('admin/selectors/index-stream', $data);
  }
  public function streamTableHead()
  {
    $tableHead = array(
      'srno' => 'sr. no.',
      'state name' => 'stream name',
      'action' => 'action'
  );
  return $tableHead;
  }

  public function showstream(){
   $json_data = $this->selectors_m->showstream();
   echo json_encode($json_data);
  }
  public function edit_stream($streamId)
  {
    $post = $this->input->post();
    if(isset($post['submit1'])){
      $this->form_validation->set_rules('stream_name','stream name','trim|required');
      if ($this->form_validation->run() == FALSE) {
        $this->data['streamId'] = $streamId;
        $streamId = $this->outh_model->Encryptor('decrypt', $streamId);
        $this->data['stream_name'] = $this->get_an_obj_by_id('stream', 'stream_id', $streamId)->stream_name;
        $this->data['page_title'] = 'edit stream';
        $this->view('admin/selectors/edit-stream', $this->data);
      } else {
        $streamId = $this->outh_model->Encryptor('decrypt', $streamId);
        $data = array(
              'stream_name' => $post['stream_name']
            );
        $stream_count	=	$this->selectors_m->duplicate('stream',array('stream_name'=>$this->input->post('stream_name')));
        if($stream_count > 0){
          $this->session->set_flashdata('notification', 'stream is already added.');
          redirect('add-stream');
        }else{
        $data = $this->toLowerCase($data);
        $this->db->where('stream_id',$streamId);
        $this->db->update('stream',$data);
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
                  'title' => 'stream updated.',
                  'description' => 'A stream is updated.'
                );
        $logdata = $this->toLowerCase($log);
        $this->db->insert('logs',$logdata);
        $this->session->set_flashdata('notification', 'stream is updated.');
        redirect('view-stream');
      }
      }
    }
    else{
      $this->data['streamId'] = $streamId;
      $streamId = $this->outh_model->Encryptor('decrypt', $streamId);
      $this->data['stream_name'] = $this->get_an_obj_by_id('stream', 'stream_id', $streamId)->stream_name;
      $this->data['page_title'] = 'edit stream';
      $this->view('admin/selectors/edit-stream', $this->data);
    }
  }

    public function add_mediam(){
      $post = $this->input->post();
      if(isset($post['submit1'])){
        $this->form_validation->set_rules('mediam_name','mediam name','trim|required');
        if($this->form_validation->run() == FALSE)
        {
          $this->data['page_title'] = 'add mediam';
          $this->view('admin/selectors/add-mediam', $this->data);
        }else{
          $data = array(
                'mediam_name' => $post['mediam_name']
          );
          $medium_count	=	$this->selectors_m->duplicate('mediam',array('mediam_name'=>$this->input->post('mediam_name')));
          if($medium_count > 0){
            $this->session->set_flashdata('notification', 'medium is already added.');
            redirect('add-mediam');
          }else{
          $data = $this->tolowercase($data);
          $this->db->insert('mediam',$data);
          $date = date('d/m/Y');
          $currentMonth = date('F');
          $currentYear = date('Y');
          $time = date('H:i:s');
          $log  = array(
                    'date' => $date,
                    'time'=>  $time,
                    'month' =>  $currentMonth,
                    'year'  =>  $currentYear,
                    'user_id' => $this->user_id,
                    'title' => 'mediam Added.',
                    'description' => 'A new mediam is created.'
                  );
          $logdata = $this->toLowerCase($log);
          $this->db->insert('logs',$logdata);
          $this->session->set_flashdata('notification', 'mediam is added.');
          redirect('view-mediam');
        }
        }

      }
      $this->data['page_title'] = 'add mediam';
      $this->view('admin/selectors/add-mediam', $this->data);
    }

    public function index_mediam(){

      $data['tableId'] = 'mediamListing';
      $data['pageTitle'] = 'mediam list';
      $data['pl'] = 'add-mediam';
      $data['drawTable'] = $this->mediamTableHead();
      $this->parsed('admin/selectors/index-mediam', $data);
    }
    public function mediamTableHead()
    {
      $tableHead = array(
        'srno' => 'sr. no.',
        'state name' => 'mediam name',
        'action' => 'action'
    );
    return $tableHead;
    }

    public function showmediam(){
     $json_data = $this->selectors_m->showmediam();
     echo json_encode($json_data);
    }

    public function edit_mediam($mediamId)
    {
      $post = $this->input->post();
      if(isset($post['submit1'])){
        $this->form_validation->set_rules('mediam_name','mediam name','trim|required');
        if ($this->form_validation->run() == FALSE) {
          $this->data['mediamId'] = $mediamId;
          $mediamId = $this->outh_model->Encryptor('decrypt', $mediamId);
          $this->data['mediam_name'] = $this->get_an_obj_by_id('mediam', 'mediam_id', $mediamId)->mediam_name;
          $this->data['page_title'] = 'edit mediam';
          $this->view('admin/selectors/edit-mediam', $this->data);
        } else {
          $mediamId = $this->outh_model->Encryptor('decrypt', $mediamId);
          $data = array(
                'mediam_name' => $post['mediam_name']
              );
          $medium_count	=	$this->selectors_m->duplicate('mediam',array('mediam_name'=>$this->input->post('mediam_name')));
          if($medium_count > 0){
            $this->session->set_flashdata('notification', 'medium is already added.');
            redirect('add-mediam');
          }else{
          $data = $this->toLowerCase($data);
          $this->db->where('mediam_id',$mediamId);
          $this->db->update('mediam',$data);
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
                    'title' => 'mediam updated.',
                    'description' => 'A mediam is updated.'
                  );
          $logdata = $this->toLowerCase($log);
          $this->db->insert('logs',$logdata);
          $this->session->set_flashdata('notification', 'mediam is updated.');
          redirect('view-mediam');
        }
      }
      }
      else{
        $this->data['mediamId'] = $mediamId;
        $mediamId = $this->outh_model->Encryptor('decrypt', $mediamId);
        $this->data['mediam_name'] = $this->get_an_obj_by_id('mediam', 'mediam_id', $mediamId)->mediam_name;
        $this->data['page_title'] = 'edit mediam';
        $this->view('admin/selectors/edit-mediam', $this->data);
      }
    }

//qualification
    public function add_qualification(){
      $post = $this->input->post();
      if(isset($post['submit1'])){
        $this->form_validation->set_rules('qualification_name','qualification name','trim|required');
        if($this->form_validation->run() == FALSE)
        {
          $this->data['page_title'] = 'add qualification';
          $this->view('admin/selectors/add-qualification', $this->data);
        }else{
          $data = array(
                'qualification_name' => $post['qualification_name']
          );
          $qualification_count	=	$this->selectors_m->duplicate('qualification',array('qualification_name'=>$this->input->post('qualification_name')));
          if($qualification_count > 0){
            $this->session->set_flashdata('notification', 'qualification is already added.');
            redirect('add-qualification');
          }else{
          $data = $this->tolowercase($data);
          $this->db->insert('qualification',$data);
          $date = date('d/m/Y');
          $currentMonth = date('F');
          $currentYear = date('Y');
          $time = date('H:i:s');
          $log  = array(
                    'date' => $date,
                    'time'=>  $time,
                    'month' =>  $currentMonth,
                    'year'  =>  $currentYear,
                    'user_id' => $this->user_id,
                    'title' => 'qualification Added.',
                    'description' => 'A new qualification is created.'
                  );
          $logdata = $this->toLowerCase($log);
          $this->db->insert('logs',$logdata);
          $this->session->set_flashdata('notification', 'qualification is added.');
          redirect('view-qualification');
        }
        }

      }
      $this->data['page_title'] = 'add qualification';
      $this->view('admin/selectors/add-qualification', $this->data);
    }

      public function index_qualification(){

        $data['tableId'] = 'qualificationListing';
        $data['pageTitle'] = 'qualification list';
        $data['pl'] = 'add-qualification';
        $data['drawTable'] = $this->qualificationTableHead();
        $this->parsed('admin/selectors/index-qualification', $data);
      }
      public function qualificationTableHead()
      {
        $tableHead = array(
          'srno' => 'sr. no.',
          'state name' => 'qualification name',
          'action' => 'action'
      );
      return $tableHead;
      }

        public function showqualification(){
         $json_data = $this->selectors_m->showqualification();
         echo json_encode($json_data);
        }

        public function edit_qualification($qulId)
        {
          $post = $this->input->post();
          if(isset($post['submit1'])){
            $this->form_validation->set_rules('qualification_name','qualification name','trim|required');
            if ($this->form_validation->run() == FALSE) {
              $this->data['qulId'] = $qulId;
              $qulId = $this->outh_model->Encryptor('decrypt', $qulId);
              $this->data['qualification_name'] = $this->get_an_obj_by_id('qualification', 'qualification_id', $qulId)->qualification_name;
              $this->data['page_title'] = 'edit qualification';
              $this->view('admin/selectors/edit-qualification', $this->data);
            } else {
              $qulId = $this->outh_model->Encryptor('decrypt', $qulId);
              $data = array(
                    'qualification_name' => $post['qualification_name']
                  );
              $qualification_count	=	$this->selectors_m->duplicate('qualification',array('qualification_name'=>$this->input->post('qualification_name')));
              if($qualification_count > 0){
                $this->session->set_flashdata('notification', 'qualification is already added.');
                redirect('add-qualification');
              }else{
              $data = $this->toLowerCase($data);
              $this->db->where('qualification_id',$qulId);
              $this->db->update('qualification',$data);
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
                        'title' => 'mediam updated.',
                        'description' => 'A qualification is updated.'
                      );
              $logdata = $this->toLowerCase($log);
              $this->db->insert('logs',$logdata);
              $this->session->set_flashdata('notification', 'qualification is updated.');
              redirect('view-qualification');
            }
          }
          }
          else{
            $this->data['qulId'] = $qulId;
            $qulId = $this->outh_model->Encryptor('decrypt', $qulId);
            $this->data['qualification_name'] = $this->get_an_obj_by_id('qualification', 'qualification_id', $qulId)->qualification_name;
            $this->data['page_title'] = 'edit qualification';
            $this->view('admin/selectors/edit-qualification', $this->data);
          }
        }

  //END
}
