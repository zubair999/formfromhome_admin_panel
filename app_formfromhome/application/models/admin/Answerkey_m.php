<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answerkey_m extends MY_Model {

    protected $tbl_name = 'answer_key';
    protected $primary_col = 'answer_key_id';
    protected $order_by = 'answer_key_name';


  public $rules = array(
            'answer_key' => array(
                'field'=> 'answer_key',
                'label'=> 'answer key name',
                'rules'=> 'trim|required'
            ),
            'link' => array(
                'field'=> 'link',
                'label'=> 'link',
                'rules'=> 'trim|required'
            )
    );

	public function __construct()
	{
		parent::__construct();
	}

	public function showAnswerkey() {
        $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = "select * from answer_key";
        //echo $sql;
        $query = $this->db->query($sql);
        $queryqResults = $query->result();
        $totalData = $query->num_rows(); // rules datatable
        $totalFiltered = $totalData; // rules datatable

        $sql = $sql;
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchValue = $requestData['search']['value'];
            $sql.= " and answer_key_name like '%" . $searchValue . "%' ";
        }


        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows();
        $sql.= " order by answer_key_name asc limit " . $start . " ," . $requestData['length'] . "   ";
        $query = $this->db->query($sql);
        $SearchResults = $query->result();
        $data = array();
        $counter = 0;

        foreach ($SearchResults as $row) {
            $counter++;
            $nestedData = array();
            $id = $row->answer_key_id;
            $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
            $action = $this->data_table_factory_model->answerKeyButtonFactory($crypted_id);
            $columnFactory = $this->data_table_factory_model->answerKeyColumnFactory($row);
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

}

/* End of file Executive_m.php */
/* Location: ./application/models/admin/Executive_m.php */
