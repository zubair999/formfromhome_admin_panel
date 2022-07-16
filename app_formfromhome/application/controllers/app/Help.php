<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Help extends MY_Controller{

  public function __construct(){
    parent:: __construct();
  }

  public function index(){
    $this->data['page_title'] = 'help.';
    $this->app_view('app/help/help', $this->data);
  }
  //CLASS END
}
