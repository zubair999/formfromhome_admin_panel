<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_m extends MY_Model {
	protected $tbl_name = 'application';
  protected $primary_col = 'application_id';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAllApplication(){

        $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = " SELECT a.`application_id`,
									e.`name_of_post`,
									s.`student_name`,
									a.`student_id`
									FROM `application` as a
									JOIN `exam` as e
									on a.`exam_id` = e.`exam_id`
									JOIN `student_info` as s
									on a.`student_id` =  s.`student_id`";
        //echo $sql;
        $query = $this->db->query($sql);
        $queryqResults = $query->result();
        $totalData = $query->num_rows(); // rules datatable
        $totalFiltered = $totalData; // rules datatable

        $sql = $sql;
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchValue = $requestData['search']['value'];
            $sql.= " where application_id like '%" . $searchValue . "%' ";

        }
        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows();
        $sql.= " order by application_id asc limit " . $start . " ," . $requestData['length'] . "   ";
        $query = $this->db->query($sql);
        $SearchResults = $query->result();
        $data = array();
        $counter = 0;
        foreach ($SearchResults as $row) {
            $counter++;
            $nestedData = array();
            $id = $row->application_id;
						$stu_id = $this->outh_model->Encryptor('encrypt', $row->student_id);
						$app_status = $this->check_status($id)->application_status;
						$email_status = $this->check_status($id)->email_status;
						$crypted_id = $this->outh_model->Encryptor('encrypt', $id);
            $action = $this->data_table_factory_model->applicationButtonFactory($crypted_id,$app_status,$stu_id);
						$status = $this->data_table_factory_model->applicationstatusFactory($crypted_id,$app_status,$email_status);
					  $columnFactory = $this->data_table_factory_model->applicationColumnFactory($row);
            $tableCol = $this->data_table_factory_model->drawTableData($counter, $crypted_id, $columnFactory);
            $j = 0;
            foreach ($tableCol as $key => $value) {
                $nestedData[] = $tableCol[$j];
                $j++;
            }
            $nestedData[] = $status['status'];
			$nestedData[] = $action['btn'];
            $data[] = $nestedData;
        }
        return $json_data = array("draw" => intval($requestData['draw']), "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), // total number of records after searching,
        "data" => $data
        // total data array
        );
        // FUNCTION ENDS

	}

	public function check_status($id){
		return $this->db->get_where('application', array('application_id'=>$id))->row();
	}

	public function get_app_info($a_id){
		$sql  =	"SELECT application.application_id,
							exam.name_of_post,
							user_auth_detail.name,
							application.email_sent_by
							FROM application
							JOIN user_auth_detail
							ON application.form_filled_by = user_auth_detail.user_auth_id
              JOIN exam
							on	application.exam_id = exam.exam_id
              where application.application_id= $a_id";

			return	$this->db->query($sql)->row();

	}

// CLASS ENDS
}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
