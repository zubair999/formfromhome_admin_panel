<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model {

    public $student_login_rules = array(
        'mobile' => array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required|exact_length[10]|is_natural'
        )
    );

    public $student_forget_password_rules = array(
        'phone' => array(
            'field' => 'phone',
            'label' => 'Mobile No.',
            'rules' => 'trim|required|exact_length[10]|is_natural',
            'errors' => array('exact_length' => 'Please enter exactly 10 digits.', 'numeric' => 'Only numeric value allowed.' )
        ),
    );

    public $change_password_rules = array(
        'oldPassword' => array(
            'field' => 'oldPassword',
            'label' => 'Old Password',
            'rules' => 'required|trim'
        ),
        'newPassword' => array(
            'field' => 'newPassword',
            'label' => 'New Password',
            'rules' => 'required|trim'
        ),
    );

    public function __construct() {
        parent::__construct();
    }


    public function check_auth_client($header) {
        $client_service = $header['Client-Service'];
        $auth_key = $header['Auth-Key'];
        $Myapikey = $header['Myapikey'];
        if ($client_service == $this->client_service && $Myapikey == $this->Myapikey && $auth_key == $this->auth_key ) {
            return true;
        } else {
            return ['status' => 401, 'message' => 'Unauthorized.'];
        }
    }

    public function login($username, $password) {
        $student_count = $this->db->get_obj('user_auth_detail','user_auth_id',array('user_name'=>$username))->num_rows();
        if($student_count > 0){
            $is_verified = $this->db->get_obj('user_auth_detail','status',array('user_name'=>$username,'status'=>1))->num_rows();
            if($is_verified === 0){
                return ['status' => 404, 'message' => 'please verify your account'];
            }
            else{
                $student_obj = $this->db->get_obj('user_auth_detail','*',array('user_name'=>$username))->row();
                $hashpwd = $student_obj->user_auth_pwd;
                if(password_verify($password,$hashpwd)){
                    return ['status' => 200, 'message' => 'login permission granted.','studentId'=>$student_obj->user_auth_id];
                }
                else{
                    return ['status' => 404, 'message' => 'wrong password.'];
                }
            }
        }
        else{
            return ['status' => 404, 'message' => 'user does not exists.'];
        }
    }










    public function logout() {
        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $role_id = $this->input->get_request_header('Role-ID', TRUE);
        $token = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id', $users_id, 'role_id', $role_id)->where('token', $token)->delete('users_authentication');
        return array('status' => 200, 'message' => 'Successfully logout.');
    }








    public function auth() {
        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $role_id = $this->input->get_request_header('Role-ID', TRUE);
        $token = $this->input->get_request_header('Authorization', TRUE);
        $q = $this->db->select('expired_at')->from('users_authentication')->where('users_id', $users_id, 'role_id', $role_id)->where('token', $token)->get()->row();
        if ($q == "") {
            return $this->json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
        } else {
            if ($q->expired_at < date('Y-m-d H:i:s')) {
                return $this->json_output(401, array('status' => 401, 'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('users_id', $users_id)->where('token', $token)->update('users_authentication', array('expired_at' => $expired_at, 'updated_at' => $updated_at));
                return array('status' => 200, 'message' => 'Authorized.', 'users_id' => $users_id, 'role_id' => $role_id);
            }
        }
    }



//CLASS ENDS
}
