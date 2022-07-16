<?php
class Data_table_factory_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function drawTableData($counter, $id, $columnFactory){
      $colArr = $columnFactory[1];
      $nestedData[0] = '<div class="nameID_'.$id.'">'.$counter.'</div>';
      $i = 1;
      $j = 0;
      foreach ($colArr as $key => $value) {
        $nestedData[$i] = '<div class="nameID_'.$id.'">'.ucwords($colArr[$j]).'</div>';
        $i++;
        $j++;
      }
      return $nestedData;
    }


    public function textSliderColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->text_slider_text
                    )
                );
    }

    public function textSliderButtonFactory($id){
      $edit =  '<a href="'.base_url('edit-text-slider/'.$id).'" class="btn btn-warning btn-xs text-capitalize">edit</a>';
      $delete =  '<a href="'.base_url('delete-text-slider/'.$id).'" class="btn btn-danger btn-xs text-capitalize">delete</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$edit.'
                                '.$delete.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }


    public function answerKeyColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->answer_key_name,
                      '1' => $row->link,
                    )
                );
    }

    public function answerKeyButtonFactory($id){
      $edit =  '<a href="'.base_url('edit-answer-key/'.$id).'" class="btn btn-warning btn-xs text-capitalize">edit</a>';
      $delete =  '<a href="'.base_url('delete-answer-key/'.$id).'" class="btn btn-danger btn-xs text-capitalize">delete</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$edit.'
                                '.$delete.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
    
    public function admitCardColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->admit_card_name,
                      '1' => $row->link,
                    )
                );
    }

    public function admitCardButtonFactory($id){
      $edit =  '<a href="'.base_url('edit-admit-card/'.$id).'" class="btn btn-warning btn-xs text-capitalize">edit</a>';
      $delete =  '<a href="'.base_url('delete-admit-card/'.$id).'" class="btn btn-danger btn-xs text-capitalize">delete</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$edit.'
                                '.$delete.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }

    public function resultColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->result_name,
                      '1' => $row->link,
                    )
                );
    }

    public function resultButtonFactory($id){
      $edit =  '<a href="'.base_url('edit-result/'.$id).'" class="btn btn-warning btn-xs text-capitalize">edit</a>';
      $delete =  '<a href="'.base_url('delete-result/'.$id).'" class="btn btn-danger btn-xs text-capitalize">delete</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$edit.'
                                '.$delete.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
    
    
    public function feedbackColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->student_name,
                      '1' => $row->feedback,
                    )
                );
    }

    public function examColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->name_of_post,
                      '1' => $row->post_date,
                      '2' => $row->last_date,
                      '3' => $row->month,
                      '4' => $row->year
                    )
                );
    }


    public function examButtonFactory($id){
      $view =  '<a href="javascript:void(0)" class="btn btn-success btn-xs text-capitalize showModal" data-exam="'.$id.'">view</a>';
      $edit =  '<a href="'.base_url('exam-edit/'.$id).'" class="btn btn-warning btn-xs text-capitalize">edit</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$view.'
                                '.$edit.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }

    public function executiveColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->name,
                      '1' => $row->mobile,
                      '2' => $row->user_name,
                    ),
                );
    }

    public function executiveButtonFactory($crypted_id,$id){



      $active =  '<a href="'.base_url('active/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" >active</a>';
      $inactive =  '<a href="'.base_url('inactive/'.$crypted_id).'" class="btn btn-danger btn-xs text-capitalize"  >inactive</a>';
      $edit =  '<a href="'.base_url('exe-edit/'.$crypted_id).'" class="btn btn-warning btn-xs text-capitalize" >Edit</a>';
      $passwordreset =  '<a href="'.base_url('exe-password/'.$crypted_id).'" class="btn btn-warning btn-xs text-capitalize" >Reset password</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$active.'
                                '.$inactive.'
                                '.$edit.'
                                '.$passwordreset.'
                              </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }

    public function stateColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->state_name
                    )
                );
    }

    public function stateButtonFactory($id){
      $edit =  '<a href="'.base_url('edit-state/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >Edit</a>';

      $action[1] =  '<div class="action-buttons">
                                '.$edit.'
                              </div>';


            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );


      return $tableArr[0];
    }

    //student

    public function studentButtonFactory($crypted_id,$id){
      $student_obj = $this->db->get_obj('student_info','academic_status,certificate_status',array('student_id'=>$id))->row();


       $view_profile =  '<a href="'.base_url('edit-student/'.$crypted_id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >View Profile</a>';

       if($student_obj->certificate_status == 1){
           $view_certificate =  '<a href="'.base_url('admin-view-certificate/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >View Certificate</a>';
        }
        else{
          $view_certificate = '';
        }


       if($student_obj->academic_status == 1){
           $view_academic =  '<a href="'.base_url('admin-view-academic/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >View Academic</a>';
        }
        else{
          $view_academic = '';
        }
         // else{
          $add_academic =  '<a href="'.base_url('a-add-academic/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >Add Academic</a>';  
         // }

          $add_certificate =  '<a href="'.base_url('a-add-certificate/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >Add certificate</a>';  
               
         // if($student_obj->certificate_status == 1){
         //   $certificate =  '<a href="'.base_url('a-edit-certificate/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >Edit certificate</a>';
         // }else{
         //  $certificate =  '<a href="'.base_url('a-add-certificate/'.$crypted_id).'" class="btn btn-success btn-xs text-capitalize" id="create_target" >Add certificate</a>';  
         // } 
        
        $delete =  '<a href="'.base_url('student-delete/'.$crypted_id).'" class="btn btn-danger btn-xs text-capitalize" id="create_target" >delete</a>';

      $action[1] =  '<div class="action-buttons">
                      '.$view_profile.'
                      '.$add_academic.'
                      '.$view_academic.'
                      '.$add_certificate.'
                      '.$view_certificate.' 
                      
                     
                    </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }

    public function studentColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->name,
                      '1' => $row->mobile,
                      '2' => $row->user_name,
                      '3' => $row->registered_by,
                      '4' => date('d-m-Y H:i:s', strtotime(str_replace('/', '-', $row->create_date)))
                    ),
                );
    }


    //application

    public function applicationButtonFactory($cid,$app_status,$stu_id){
      $stu_info =  '<a class="btn btn-success btn-xs text-capitalize showStudentInfo" id="create_target" data-stuinfo="'.$stu_id.'" >student info</a>';



      if($app_status == 1){

      $mail =  '<a href="'.base_url('send-email/'.$cid).'"  class="btn btn-warning btn-xs text-capitalize" id="create_target" >send mail</a>';
      $approved_by =  '<a class="btn btn-warning btn-xs text-capitalize" id="create_target" data-approved="'.$cid.'">worked by</a>';
      $action[1] =  '<div class="action-buttons">
                      '.$stu_info.'
                      '.$mail.'
                      '.$approved_by.'
                    </div>';
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
    }
    else{
      $view =  '<div href="#" class="btn btn-success btn-xs text-capitalize changestatus" data-status="'.$cid.'" id="create_target" >Form Filled</div>';
      $action[1] =  '<div class="action-buttons">
                      '.$stu_info.'
                      '.$view.'
                    </div>';
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
    }

      return $tableArr[0];
    }

    public function applicationstatusFactory($id,$app_status,$email_status){ 
      if($app_status == 0){
      $form_pendding =  '<a class="cdn btn btn-danger btn-xs text-capitalize" id="create_target" >form is pendding</a>';
      }else{

        $form_pendding =  '<div class="cdn btn btn-success btn-xs text-capitalize" id="create_target" >form is filled</div>';
      }
      if($email_status == 0){
      $email_pending =  '<a class="cdn btn btn-danger btn-xs text-capitalize" id="create_target" >email is pending</a>';
      }else{
        $email_pending =  '<a class="cdn btn btn-success btn-xs text-capitalize" id="create_target" >email sent</a>';
      }
      $action[1] =  '<div class="action-buttons">
                      '.$email_pending.'
                      '.$form_pendding.'
                    </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'status' => $action[1]
                ),
                $business = array('status' => $action[1])
            );
      // }

      return $tableArr[0];
    }

    public function applicationColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->name_of_post,
                      '1' => $row->student_name,
                    ),
                );
    }

    //service charges
    public function servicechargesButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-service-charges/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function servicechargesColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->amount
                    ),
                );
    }


//category

    public function categoryButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-caterory/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function categoryColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->category_name
                    ),
                );
    }

    public function logColumnFactory($row){
      return array(
                  '1'=>array(
                    '0'=> $row->name,
                    '1'=> $row->title,
                    '2'=> $row->description,
                    '3'=> $row->date,
                    '4'=> $row->time
                  ),
              );
    }

    //board
    public function boardButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-board/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function boardColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->board_name
                    ),
                );
    }



    //stream
    public function streamButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-stream/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function streamColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->stream_name
                    ),
                );
    }

    //mediam
    public function mediamButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-mediam/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function mediamColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->mediam_name
                    ),
                );
    }

    //qualification
    public function qualificationButtonFactory($id){
       $edit =  '<a href="'.base_url('edit-qualification/'.$id).'" class="btn btn-warning btn-xs text-capitalize" id="create_target" >edit</a>';

      $action[1] =  '<div class="action-buttons">
                        '.$edit.'
                     </div>';

      // if(isset($this->roleId)){
            $tableArr = array(
                $admin = array(
                    'btn' => $action[1]
                ),
                $business = array('btn' => $action[1])
            );
      // }

      return $tableArr[0];
    }
     public function qualificationColumnFactory($row){
      return array(
                    '1' => array(
                      '0' => $row->qualification_name
                    ),
                );
    }

//end
}
