<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_student_m extends MY_Model {
	protected $tbl_name = 'student_info';
	protected $primary_col = 'info_id';
	public $rules = array(
		'student_name' => array(
			'field'=>'student_name',
			'lable' => 'student name',
			'rules' => 'trim|required|alpha_numeric_space'
		),
		'father_name' => array(
				'field' =>'father_name',
				'lable' => 'father name',
				'rules' => 'trim|required|alpha_numeric_space'
		),
		'mother_name' => array(
				'field' =>'mother_name',
				'lable' => 'mother name',
				'rules' => 'trim|required|alpha_numeric_space'
		),
		'dob' => array(
				'field' =>'dob',
				'lable' => 'dob',
				'rules' => 'trim|required'
		),
		'gender' => array(
				'field' =>'gender',
				'lable' => 'gender',
				'rules' => 'trim|required|alpha'
		),
		'category_name' => array(
				'field' =>'category_name',
				'lable' => 'category',
				'rules' => 'trim|required|numeric'
		),
		'address' => array(
				'field' =>'address',
				'lable' => 'address',
				'rules' => 'trim|required'
		),
		'mobile' => array(
				'field' =>'mobile',
				'lable' => 'mobile',
				'rules' => 'trim|required|exact_length[10]|is_natural'
		),
		'house' => array(
				'field' =>'house',
				'lable' => 'house',
				'rules' => 'trim|required'
		),
		'block' => array(
				'field' =>'block',
				'lable' => 'block',
				'rules' => 'trim|required'
		),
		'district' => array(
				'field' =>'district',
				'lable' => 'district',
				'rules' => 'trim|required|alpha'
		),
		'state' => array(
				'field' =>'state',
				'lable' => 'state',
				'rules' => 'required|numeric'
		),
		'pincode' => array(
				'field' =>'pincode',
				'lable' => 'pincode',
				'rules' => 'trim|required|is_natural'
		)

	);

	public function __construct(){
		parent::__construct();
	}


	// public function view_profile(){
	// 	$sql = "SELECT s.`student_name` ,
	// 					s.`info_id`,
	// 					s.`student_id`,
	// 					s.`mobile`,
	// 					s.`gender`,
	// 					s.`dob`,
	// 					s.`father_name`,
	// 					s.`mother_name`,
	// 					s.`guardian_name`,
	// 					s.`student_img`,
	// 					s.`signature_img`,
	// 					s.`thumb_img`,
	// 					s.`house`,
	// 					s.`block`,
	// 					s.`district`,
	// 					s.`state`,
	// 					s.`locality`,
	// 					s.`address`,
	// 					s.`pincode`,
	// 					c.`category_name`
	// 					FROM `student_info` as s
	// 					JOIN `category` as c
	// 					on s.`category_id` = c.`category_id`
	// 					where `student_id`= $this->student_auth_id";
	// 	return $this->db->query($sql)->row();
	// }

//academic

	public function view_academic(){
		$sql = "SELECT sa.`passing_year`,
							sa.`total_marks`,
							sa.`marks_obtained`,
							sa.`percentage`,
							sa.`extra_info`,
							q.`qualification_name`,
							b.`board_name`,
							m.`mediam_name`,
							s.`stream_name`,
							sa.`academic_id`,
							sa.`student_id`
							FROM `student_academic` as sa
							JOIN qualification as q
							ON sa.`qualification_id` = q.`qualification_id`
							JOIN board as b
							ON sa.`board_id`=b.`board_id`
							JOIN mediam as m
							ON sa.`medium_id` = m.mediam_id
							JOIN stream as s
							ON sa.`stream_id` = s.stream_id
							WHERE sa.`student_id` =$this->student_auth_id";

		$q_arr = $this->db->query($sql)->result_array();
		$i = 0;
		foreach($q_arr as $value){
			$q_id = $value['academic_id'];
			$s_id = $value['student_id'];
			// $marksheet = $this->get_an_obj('marksheet','marksheet_img',array('student_id'=>$s_id,'academic_id'=>$q_id),'array');
			$marksheet = $this->db->get_obj('marksheet','marksheet_img',array('student_id'=>$s_id,'academic_id'=>$q_id))->result_array();
			$q_arr[$i]['document'] = $marksheet;
		$i++;
		}

		return $this->change_keys_to_hashed_key_of_arr($q_arr, 'academic_id');
	}

//certificates

// public function view_certificate(){
// 	$sql = "SELECT c.`certificate_img`,
// 					sc.`certificate_name`
// 					FROM `certificate` as c
// 					JOIN student_certificate as sc
// 					on c.`stu_certificate_id` = sc.`stu_certificate_id`
// 					WHERE c.`student_id`=$this->student_auth_id";

// 	$q_arr = $this->db->query($sql)->result_array();

// 	return $q_arr;
// }


// public function stu_rows($s_id){
// 	return $this->db->get_where('student_info',array('student_id'=>$s_id))->num_rows();
// }


// CLASS ENDS
}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
