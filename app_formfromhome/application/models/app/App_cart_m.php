<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_cart_m extends MY_Model {
	protected $tbl_name = 'cart';
	protected $primary_col = 'cart_id';

  public function __construct(){
    parent::__construct();
  }

	public function get_cart_item(){
		$this->db->select('cart.exam_fee, cart.service_charge, cart.cart_id, exam.name_of_post, student_info.student_name')
						 ->from('cart')
						 ->join('exam', 'cart.exam_id = exam.exam_id')
						 ->join('student_info', 'cart.student_id = student_info.student_id');
		$cart_item = $this->db->get()->result_array();
		$cart_arr = $this->change_keys_to_hashed_key_of_arr($cart_item, $this->primary_col);
		$total_ex = round(array_sum(array_column($cart_arr, 'exam_fee')), 2);
		$total_sc = round(array_sum(array_column($cart_arr, 'service_charge')),2);
		$cart_summary = array('te'=>$total_ex, 'ts'=>$total_sc);
		return array('cart_item'=>$cart_arr, 'summary'=>$cart_summary);
	}


// CLASS ENDS
}
