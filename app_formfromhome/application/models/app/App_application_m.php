<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_application_m extends MY_Model {
  protected $tbl_name = 'application';
  protected $primary_col = 'application_id';

  public function __construct(){
  	parent::__construct();
  }

  public function get_notification(){

    $sql = "SELECT
            a.application_id,
            e.name_of_post
            FROM application as a
            JOIN exam as e
            ON a.exam_id=e.exam_id
            WHERE a.student_id=$this->student_auth_id
            AND a.email_status = 1
            AND a.application_status = 1
            AND a.viewed_by_student = 0";

    return $this->db->query($sql)->result_array();
  }

  public function get_order_history(){
    $this->db->select(
                    'application.application_id,
                    application.order_id,
                    application.exam_fee,
                    application.service_charge,
                    application.date,
                    application.month,
                    application.year,
                    exam.name_of_post
                    '
                    )
             ->from('application')
             ->join('exam', 'exam.exam_id=application.exam_id');

    return $this->db->get()->result_array();
  }

}
