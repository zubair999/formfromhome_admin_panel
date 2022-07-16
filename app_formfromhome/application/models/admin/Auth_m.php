<?php
class Auth_m extends MY_Model
{
    protected $tbl_name = 'user_auth_detail';
    protected $primary_col = 'user_auth_id';

    public $rules = array(
      'loginid' => array(
        'field'=>'loginid',
        'lable' => 'login id',
        'rules' => 'trim|required|valid_email'
      ),
      'pass' => array(
          'field' =>'pass',
          'lable' => 'mobile no',
          'rules' => 'trim|required'
      )
    );

    public $rules1 = array(
      'pass' => array(
          'field' =>'pass',
          'lable' => 'new password',
          'rules' => 'trim|required'
      )
    );

    function __construct()
    {
        parent::__construct();
    }


    public function authenticate_user($user_name, $pwd){
      $userObj = $this->db->get_where('user_auth_detail', array('user_name'=>$user_name, 'status'=>'1'))->row();

      if($userObj === null){
        return 403;
      }
      else{
          $hashedPwd = $userObj->user_auth_pwd;
          if(password_verify($pwd, $hashedPwd)){

            $session = array(
              'name' => $userObj->name,
              'user_name' => $user_name,
              'role_id' => $userObj->role_id,
              'user_auth_id' => $userObj->user_auth_id,
              'status'  =>  $userObj->status,
            );
            
          $this->session->set_userdata($session);
          return true;
        }
        else{
          return false;
        }
      }



    }


}
