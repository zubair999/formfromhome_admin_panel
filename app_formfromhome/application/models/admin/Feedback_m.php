<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_m extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function getAllFeedback() {

        $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = "select * from feedback join student_info on feedback.student_id=student_info.student_id";
        //echo $sql;
        $query = $this->db->query($sql);
        $queryqResults = $query->result();
        $totalData = $query->num_rows(); // rules datatable
        $totalFiltered = $totalData; // rules datatable

        $sql = $sql;
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchValue = $requestData['search']['value'];
            $sql.= " and student_info.student_name like '%" . $searchValue . "%' ";
        }
        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows();
        $sql.= " order by feedback.feedback_id asc limit " . $start . " ," . $requestData['length'] . "   ";
        $query = $this->db->query($sql);
        $SearchResults = $query->result();
        $data = array();
        $counter = 0;
        foreach ($SearchResults as $row) {
            $counter++;
            $nestedData = array();
            $id = $row->feedback_id;
            $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
            // $action = $this->data_table_factory_model->executiveButtonFactory($crypted_id);
            $columnFactory = $this->data_table_factory_model->feedbackColumnFactory($row);
            $tableCol = $this->data_table_factory_model->drawTableData($counter, $crypted_id, $columnFactory);
            $j = 0;
            foreach ($tableCol as $key => $value) {
                $nestedData[] = $tableCol[$j];
                $j++;
            }
            // $nestedData[] = $action['btn'];
            $data[] = $nestedData;
        }
        return $json_data = array("draw" => intval($requestData['draw']), "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), // total number of records after searching,
        "data" => $data
        // total data array
        );
        // FUNCTION ENDS
    }

}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
