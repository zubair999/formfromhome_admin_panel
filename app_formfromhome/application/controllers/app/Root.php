<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Root extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		parent::app_authenticate();
	}

	public function index(){
		$this->data['page_title'] = '';
		$this->app_view('app/root/root', $this->data);
	}



// CLASS ENDS
}
