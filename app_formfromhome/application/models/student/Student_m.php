<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}
  protected $tbl_name = 'user_auth_detail';
  protected $primary_col = 'user_auth_id';
	public $rules = array(
		'student_name' => array(
			'field'=>'student_name',
			'lable' => 'student_name',
			'rules' => 'trim|required|alpha_numeric_spaces'
		),
		'user_name' => array(
			'field'=>'user_name',
			'lable' => 'user name',
			'rules' => 'required|valid_email'
		),
		'father_name' => array(
				'field' =>'father_name',
				'lable' => 'father name',
				'rules' => 'trim|required|alpha_numeric_spaces'
		),
		'mother_name' => array(
				'field' =>'mother_name',
				'lable' => 'mother name',
				'rules' => 'trim|required|alpha_numeric_spaces'
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
				'rules' => 'trim|required|numeric'
		)
	);




	public function getAllStudents(){

		        $requestData = $_REQUEST;
		        $start = (int)$requestData['start'];
		        $sql = "select user_auth_id,name,mobile,user_name,registered_by,create_date from user_auth_detail where role_id=3";
		        //echo $sql;
		        $query = $this->db->query($sql);
		        $queryqResults = $query->result();
		        $totalData = $query->num_rows(); // rules datatable
		        $totalFiltered = $totalData; // rules datatable

		        $sql = $sql;
		        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
		            $searchValue = $requestData['search']['value'];
		            $sql.= " and name like '%" . $searchValue . "%' ";

		        }
		        $query = $this->db->query($sql);
		        $totalFiltered = $query->num_rows();
		        $sql.= " order by name asc limit " . $start . " ," . $requestData['length'] . "   ";
		        $query = $this->db->query($sql);
		        $SearchResults = $query->result();
		        $data = array();
		        $counter = 0;
		        foreach ($SearchResults as $row) {
		            $counter++;
		            $nestedData = array();
		            $id = $row->user_auth_id;
		            $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
		            $action = $this->data_table_factory_model->studentButtonFactory($crypted_id,$id);
		            $columnFactory = $this->data_table_factory_model->studentColumnFactory($row);
		            $tableCol = $this->data_table_factory_model->drawTableData($counter, $crypted_id, $columnFactory);
		            $j = 0;
		            foreach ($tableCol as $key => $value) {
		                $nestedData[] = $tableCol[$j];
		                $j++;
		            }
		            $nestedData[] = $action['btn'];
		            $data[] = $nestedData;
		        }
		        return $json_data = array("draw" => intval($requestData['draw']), "recordsTotal" => intval($totalData), // total number of records
		        "recordsFiltered" => intval($totalFiltered), // total number of records after searching,
		        "data" => $data
		        // total data array
		        );
	}


	public function showprofile($stu_id){
		return $this->db->get_where('student_info',array('student_id'=>$stu_id))->row();
	}


		public function student_info($stuId){
			$this->db->select('
								s.student_name ,
								s.gender,
								s.dob,
								s.father_name,
								s.mother_name,
								s.address,
								s.guardian_name,
								s.student_img,
								s.signature_img,
								s.thumb_img,
								s.house,
								s.block,
								s.district,
								s.pincode,
								s.locality,
								s.adhar_no,
								c.category_name,
								st.state_name,
								ua.user_name,
								ua.mobile
								'
							);
			$this->db->from('student_info as s');
			$this->db->join('category as c','s.category_id = c.category_id');
			$this->db->join('user_auth_detail as ua','ua.user_auth_id = s.student_id');
			$this->db->join('state as st','st.state_id = s.state');
			$this->db->where('s.student_id',$stuId);
			return $this->db->get()->row();
		}


	public function get_student_academic_info($stuId){
		$this->db->select('
							sa.passing_year,
							sa.total_marks,
							sa.marks_obtained,
							sa.percentage,
							sa.extra_info,
							q.qualification_name,
							b.board_name,
							m.mediam_name,
							s.stream_name,
							sa.academic_id,
							sa.student_id
						');
		$this->db->from('student_academic as sa');
		$this->db->join('qualification as q','sa.qualification_id = q.qualification_id');
		$this->db->join('board as b','sa.board_id=b.board_id');
		$this->db->join('mediam as m','sa.medium_id = m.mediam_id');
		$this->db->join('stream as s','sa.stream_id = s.stream_id');
		$this->db->where('sa.student_id',$stuId);
		return $this->db->get()->result_array();
	}

	public function get_student_certificate_info($stuId){
		// $sql = "SELECT c.`certificate_img`,
		// 				c.`certificate_name`
		// 				FROM `student_certificate` as c
		// 				WHERE c.`student_id`=$stuId";
		// 				$q_arr = $this->db->query($sql)->result_array();
		// 				return $q_arr;

		$tbl = 'student_certificate';
		$select = 'certificate_img,certificate_name';
		$where = array('student_id'=> $stuId);
		$cer_count = $this->db->get_obj($tbl,$select,$where)->num_rows();
		if($cer_count < 1){
			return false;
		}
		else{
			return $this->db->get_obj('student_certificate', 'certificate_img,certificate_name')->result_array();
		}
	}




// CLASS ENDS
}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
