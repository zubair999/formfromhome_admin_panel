<?php
defined('BASEPATH') or exit('no direct script access allowed');

class Log extends MY_Controller {

  public function index(){
    $data['tableId']  = 'loglisting';
    $data['pageTitle'] = 'activity log';
    $data['drawTable'] 	= $this->logTableHead();
    $data['pl'] = 'added';
    $this->parsed('admin/log/index', $data);
  }
  public function logTableHead(){
    $tableHead = array(
      'srno' => 'sr. no.',
      'activity by' => 'activity by',
      'title' => 'activity',
      'description' => 'description',
      'date' => 'date',
      'time' => 'time'
      );
    return $tableHead;
  }
  public function showlog(){
    $data  = $this->log_m->showlog();
    echo json_encode($data);
  }
  //END
}
