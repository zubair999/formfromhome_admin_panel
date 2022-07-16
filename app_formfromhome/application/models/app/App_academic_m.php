<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_academic_m extends MY_Model {
  protected $tbl_name = 'student_academic';
  protected $primary_col = 'qualification_id';
  public $rules = array(
  	'qualification' => array(
  		'field' => 'qualification',
  		'label' => 'qualification',
  		'rules' => 'trim|required|numeric'
  	),
    'year' => array(
      'field' => 'year',
      'label' => 'year',
      'rules' => 'trim|required|numeric'
    ),
    'board' => array(
      'field' => 'board',
      'label' => 'board',
      'rules' => 'trim|required|numeric'
    ),
    'medium' => array(
      'field' => 'medium',
      'label' => 'medium',
      'rules' => 'trim|required|numeric'
    ),
    'stream' => array(
      'field' => 'stream',
      'label' => 'stream',
      'rules' => 'trim|required|numeric'
    ),
    'total_marks' => array(
      'field' => 'total_marks',
      'label' => 'total_marks',
      'rules' => 'trim|required|numeric'
    ),
    'marks_obtained' => array(
      'field' => 'marks_obtained',
      'label' => 'marks_obtained',
      'rules' => 'trim|required|numeric'
    ),
    'percentage' => array(
      'field' => 'percentage',
      'label' => 'percentage',
      'rules' => 'trim|required|numeric'
    ),
  );

  public function __construct() {
      parent::__construct();
  }



//CLASS ENDS
}
