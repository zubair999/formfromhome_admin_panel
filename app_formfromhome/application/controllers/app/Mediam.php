<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Mediam extends MY_Controller{


  public function __construct()
  {
    parent::__construct();
  }

  public function all_mediam(){
      $data = $this->db->get_obj('mediam')->result_array();
      echo json_encode($data);
  }
  //CLASS END
}
