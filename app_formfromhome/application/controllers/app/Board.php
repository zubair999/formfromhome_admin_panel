<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Board extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
  }

  public function all_board(){
    $data = $this->db->get_obj('board')->result_array();
    echo json_encode($data);
  }

  //CLASS END
}
