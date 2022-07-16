<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Qualification extends MY_Controller{

  	public function __construct()
  	{
  		parent::__construct();
  	}

    public function all_qualification(){
	    $data = $this->db->get_obj('qualification')->result_array();
	    echo json_encode($data);
    }


//CLASS END
}
