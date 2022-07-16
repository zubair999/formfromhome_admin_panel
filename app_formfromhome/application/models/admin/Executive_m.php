<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Executive_m extends MY_Model {

    protected $tbl_name = 'user_auth_detail';
    protected $primary_col = 'user_auth_id';
    protected $order_by = 'name';
    public $rules = array(
            'executive_name' => array(
                'field'=> 'executive_name',
                'label'=> 'exective name',
                'rules'=> 'trim|required'
            ),
            'email' => array(
                'field'=> 'email',
                'label'=> 'email',
                'rules'=> 'trim|required|valid_email|is_unique[user_auth_detail.user_name]'
            ),
            'mobile' => array(
                'field'=> 'mobile',
                'label'=> 'mobile',
                'rules'=> 'trim|required|is_unique[user_auth_detail.mobile]|exact_length[10]|is_natural'
            )
    );


	public function __construct()
	{
		parent::__construct();

	}

	public function active($executive_id){
        $this->db->set('status', '1');
        $this->db->where('user_auth_id', $executive_id);
        return $this->db->update('user_auth_detail');
    }

    public function inactive($executive_id){
        $this->db->set('status', '0');
        $this->db->where('user_auth_id', $executive_id);
        return $this->db->update('user_auth_detail');
    }

	public function getAllExecutive() {

        $requestData = $_REQUEST;
        $start = (int)$requestData['start'];
        $sql = "select * from user_auth_detail where role_id = 2 ";
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
            $action = $this->data_table_factory_model->executiveButtonFactory($crypted_id,$id);
            $columnFactory = $this->data_table_factory_model->executiveColumnFactory($row);
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
