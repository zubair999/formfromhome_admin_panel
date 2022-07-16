<?php
defined('BASEPATH') or exit('no dierct script access allowed');

class Log_m extends MY_Model{

	// protected $tbl_name = 'category';
  //   protected $primary_col = 'category_id';
  //   protected $order_by = 'category_name';

    public function __construct()
	{
		parent::__construct();
	}


	public function showlog(){
		 $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = "SELECT `log_id`,
                `date`,
                `time`,
                `title`,
                `description`,
                `name`
                FROM `logs`
                JOIN user_auth_detail
                on logs.`user_id` = user_auth_detail.user_auth_id";

        //echo $sql;
        $query = $this->db->query($sql);
        $queryqResults = $query->result();
        $totalData = $query->num_rows(); // rules datatable
        $totalFiltered = $totalData; // rules datatable

        $sql = $sql;
        if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchValue = $requestData['search']['value'];
            $sql.= " and log_id like '%" . $searchValue . "%' ";

        }
        $query = $this->db->query($sql);
        $totalFiltered = $query->num_rows();
        $sql.= " order by log_id asc limit " . $start . " ," . $requestData['length'] . "   ";
        $query = $this->db->query($sql);
        $SearchResults = $query->result();
        $data = array();
        $counter = 0;
        foreach ($SearchResults as $row) {
            $counter++;
            $nestedData = array();
            $id = $row->log_id;
            $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
            //$action = $this->data_table_factory_model->categoryButtonFactory($crypted_id);
            $columnFactory = $this->data_table_factory_model->logColumnFactory($row);
            $tableCol = $this->data_table_factory_model->drawTableData($counter, $crypted_id, $columnFactory);
            $j = 0;
            foreach ($tableCol as $key => $value) {
                $nestedData[] = $tableCol[$j];
                $j++;
            }
            //$nestedData[] = $action['btn'];
            $data[] = $nestedData;
        }
        return $json_data = array("draw" => intval($requestData['draw']), "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), // total number of records after searching,
        "data" => $data
        // total data array
        );
        // FUNCTION ENDS
    }






//end class

}
