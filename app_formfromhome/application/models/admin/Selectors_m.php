<?php
defined('BASEPATH') or exit ('No direct script access allowed');

Class Selectors_m extends MY_Model{

	protected	$tbl_name = 'board';
	protected	$primary_col =	'board_id';


  public function showboard(){
    $requestData = $_REQUEST;
    $start = (int)$requestData['start'];
    $sql = "select * from board";
    //echo $sql;
    $query = $this->db->query($sql);
    $queryqResults = $query->result();
    $totalData = $query->num_rows(); // rules datatable
    $totalFiltered = $totalData; // rules datatable

    $sql = $sql;
    if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $searchValue = $requestData['search']['value'];
        $sql.= " and board_name like '%" . $searchValue . "%' ";

    }
    $query = $this->db->query($sql);
    $totalFiltered = $query->num_rows();
    $sql.= " order by board_name asc limit " . $start . " ," . $requestData['length'] . "   ";
    $query = $this->db->query($sql);
    $SearchResults = $query->result();
    $data = array();
    $counter = 0;
    foreach ($SearchResults as $row) {
        $counter++;
        $nestedData = array();
        $id = $row->board_id;
        $crypted_id = $this->outh_model->Encryptor('encrypt', $id);
        $action = $this->data_table_factory_model->boardButtonFactory($crypted_id);
        $columnFactory = $this->data_table_factory_model->boardColumnFactory($row);
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

	public function showstream(){
		$requestData = $_REQUEST;
		$start = (int)$requestData['start'];
		$sql = "select * from stream";
		//echo $sql;
		$query = $this->db->query($sql);
		$queryqResults = $query->result();
		$totalData = $query->num_rows(); // rules datatable
		$totalFiltered = $totalData; // rules datatable

		$sql = $sql;
		if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$searchValue = $requestData['search']['value'];
				$sql.= " and stream_name like '%" . $searchValue . "%' ";

		}
		$query = $this->db->query($sql);
		$totalFiltered = $query->num_rows();
		$sql.= " order by stream_name asc limit " . $start . " ," . $requestData['length'] . "   ";
		$query = $this->db->query($sql);
		$SearchResults = $query->result();
		$data = array();
		$counter = 0;
		foreach ($SearchResults as $row) {
				$counter++;
				$nestedData = array();
				$id = $row->stream_id;
				$crypted_id = $this->outh_model->Encryptor('encrypt', $id);
				$action = $this->data_table_factory_model->streamButtonFactory($crypted_id);
				$columnFactory = $this->data_table_factory_model->streamColumnFactory($row);
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

	public function showmediam(){
		$requestData = $_REQUEST;
		$start = (int)$requestData['start'];
		$sql = "select * from mediam";
		//echo $sql;
		$query = $this->db->query($sql);
		$queryqResults = $query->result();
		$totalData = $query->num_rows(); // rules datatable
		$totalFiltered = $totalData; // rules datatable

		$sql = $sql;
		if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$searchValue = $requestData['search']['value'];
				$sql.= " and mediam_name like '%" . $searchValue . "%' ";

		}
		$query = $this->db->query($sql);
		$totalFiltered = $query->num_rows();
		$sql.= " order by mediam_name asc limit " . $start . " ," . $requestData['length'] . "   ";
		$query = $this->db->query($sql);
		$SearchResults = $query->result();
		$data = array();
		$counter = 0;
		foreach ($SearchResults as $row) {
				$counter++;
				$nestedData = array();
				$id = $row->mediam_id;
				$crypted_id = $this->outh_model->Encryptor('encrypt', $id);
				$action = $this->data_table_factory_model->mediamButtonFactory($crypted_id);
				$columnFactory = $this->data_table_factory_model->mediamColumnFactory($row);
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


		public function showqualification(){
			$requestData = $_REQUEST;
			$start = (int)$requestData['start'];
			$sql = "select * from qualification";
			//echo $sql;
			$query = $this->db->query($sql);
			$queryqResults = $query->result();
			$totalData = $query->num_rows(); // rules datatable
			$totalFiltered = $totalData; // rules datatable

			$sql = $sql;
			if (!empty($requestData['search']['value'])) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$searchValue = $requestData['search']['value'];
					$sql.= " and qualification_name like '%" . $searchValue . "%' ";

			}
			$query = $this->db->query($sql);
			$totalFiltered = $query->num_rows();
			$sql.= " order by qualification_name asc limit " . $start . " ," . $requestData['length'] . "   ";
			$query = $this->db->query($sql);
			$SearchResults = $query->result();
			$data = array();
			$counter = 0;
			foreach ($SearchResults as $row) {
					$counter++;
					$nestedData = array();
					$id = $row->qualification_id;
					$crypted_id = $this->outh_model->Encryptor('encrypt', $id);
					$action = $this->data_table_factory_model->qualificationButtonFactory($crypted_id);
					$columnFactory = $this->data_table_factory_model->qualificationColumnFactory($row);
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



//END
}
