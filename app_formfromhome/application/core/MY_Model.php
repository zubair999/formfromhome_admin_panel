<?php defined('BASEPATH') or exit ('No direct script access allowed');

class MY_Model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function add($data, $id = NULL){
        if($id !== NULL){
            $this->db->set($data);
            $this->db->where($this->primary_col, $id);
            return $this->db->update($this->tbl_name);
        }else{
            if(!($this->db->insert($this->tbl_name, $data))){
                $error = $this->db->error();
                if($error['code'] == 1062){
                    return "Already Exist!";
                }
            }
        }
    }


    public function change_indexed_hashed_keys_to_primary_key($arr){
        $i=0;
        foreach ($arr as $primary_hashed_key) {
            $primaryid = $this->outh_model->Encryptor('decrypt', $primary_hashed_key);
            $arr[$i] = $primaryid;
        $i++;
        }
        return $arr;
    }

    public function change_keys_to_hashed_key_of_arr($arr, $primaryColumnName){
        $i = 0;
        foreach ($arr as $value) {
            $primaryid = $value[$primaryColumnName];
            $crypted_id = $this->outh_model->Encryptor('encrypt', $primaryid);
            $arr[$i][$primaryColumnName.'Id'] = $crypted_id;
            $arr[$i][$primaryColumnName] = '';
            $i++;
        }
        return $arr;
    }

    public function get_an_obj($tbl, $col, $where, $method){
        if($col == '*'){
          if($method == 'row'){
            if($where == null){
              return $this->db->get($tbl)->row();
            }
            else{
              return $this->db->get_where($tbl, $where)->row();
            }
          }
          else if($method == 'array'){
            if($where == null){
              return $this->db->get($tbl)->result_array();
            }
            else{
              return $this->db->get_where($tbl, $where)->result_array();
            }
          }
        }
        else {
          if($method == 'row'){
            if($where == null){
              return $this->db->get($tbl)->row();
            }
            else {
              return $this->db->get_where($tbl, $where)->row();
            }
          }
          else if($method == 'array'){
            if($where == null){
              return $this->db->get($tbl)->result_array();
            }
            else{
              return $this->db->get_where($tbl, $where)->result_array();
            }
          }
        }
    }

    public function delete($where){
		    return $this->db->delete($this->tbl_name, $where);
	  }

    public function duplicate($tbl,$where){
        return $this->db->get_where($tbl,$where)->num_rows();
      }
    //CLASS END
}
