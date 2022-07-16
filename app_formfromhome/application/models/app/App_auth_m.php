<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_auth_m extends MY_Model {
  protected $tbl_name = 'user_auth_detail';
  protected $primary_col = 'user_auth_id';


  public $rules = array(
  	'loginid' => array(
  		'field' => 'loginid',
  		'label' => 'login id',
  		'rules' => 'trim|required'
  	),
    'pass' => array(
      'field' => 'pass',
      'label' => 'mobile',
      'rules' => 'trim|required'
    )
  );

  public function __construct() {
      parent::__construct();
  }



//CLASS ENDS
}
