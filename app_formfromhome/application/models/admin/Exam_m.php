<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_m extends MY_Model {

    protected $tbl_name = 'exam';
    protected $primary_col = 'exam_id';
    protected $order_by = 'post_date';
    public $rules = array(
            'name_of_post' => array(
                'field'=> 'name_of_post',
                'label'=> 'name of post',
                'rules'=> 'trim|required'
            ),
            'post_date' => array(
                'field'=> 'post_date',
                'label'=> 'post date',
                'rules'=> 'trim|required'
            ),
            'state_name' => array(
                'field'=> 'state_name',
                'label'=> 'state name',
                'rules'=> 'trim|required'
            ),
            'last_date' => array(
                'field'=> 'last_date',
                'label'=> 'last date',
                'rules'=> 'trim|required'
            ),
            'category[]'  => array(
                'field'=> 'category_id[]',
                'label'=> 'category',
                'rules'=> 'required'
            ),
            'fee[]'  => array(
                'field'=> 'exam_fee[]',
                'label'=> 'fee',
                'rules'=> 'required'
            ),
    );


	public function __construct()
	{
		parent::__construct();
	}

	public function getAllExam() {
        $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = "select * from exam ";
        //echo $sql;
        $query = $this->db->query($sql);
        $queryqResults = $query->result();
        $totalData = $query->num_rows(); // rules datatable
        $totalFiltered = $totalData; // rules datatable

        $sql = $sql;
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchValue = $requestData['search']['value'];
            $sql.= " and name_of_post like '%" . $searchValue . "%' ";

        }
        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows();
        $sql.= " order by post_date desc limit " . $start . " ," . $requestData['length'] . "   ";
        $query = $this->db->query($sql);
        $SearchResults = $query->result();
        $data = array();
        $counter = 0;
        foreach ($SearchResults as $row) {
            $counter++;
            $nestedData = array();
            $id = $row->exam_id;
            $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
            $action = $this->data_table_factory_model->examButtonFactory($crypted_id);
            $columnFactory = $this->data_table_factory_model->examColumnFactory($row);
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
        // FUNCTION ENDS
    }
    public function check_exam_fee_changes($exam_fee_arr,$category_arr,$exam_id){
        // GET CATEGORY ID BY EXAM ID.
        $exam_fee_category_arr = $this->db->get_obj('exam_fee','category_id',array('exam_id'=>$exam_id))->result_array();
        $this->db->where('exam_id',$exam_id);
        $this->db->delete('exam_fee');
        $exam_fee_arr = array_diff($exam_fee_arr, [0]); 
        $combine_arr = array_combine($category_arr, $exam_fee_arr);
        foreach ($combine_arr as $key => $value) {
            $arrayName = array(
                'category_id' => $key,
                'exam_fee' => $value,
                'exam_id' => $exam_id
            );
            $this->db->insert('exam_fee', $arrayName);
        }
        return;
    }


//CLASS ENDS
}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
