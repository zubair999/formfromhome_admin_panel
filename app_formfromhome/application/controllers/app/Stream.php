<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Stream extends MY_Controller{


  public function __construct()
  {
    parent::__construct();
  }

  public function all_stream(){
      $data = $this->db->get_obj('stream')->result_array();
      echo json_encode($data);
  }
  //CLASS END
}
