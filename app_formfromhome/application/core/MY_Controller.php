<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . '/vendor/autoload.php'; // change path as needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Razorpay\Api\Api;
use \SendGrid\Mail\Mail;
use Twilio\Rest\Client;

// use SendGrid\Mail\From;
// use SendGrid\Mail\To;
// use SendGrid\Mail\Mail;
// $email->setTemplateId("d-e245abe502634cc6aa7b8c909eedd1e4");

class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin/auth_m');
        $this->load->model('app/app_auth_m');
        $this->load->model('admin/executive_m');
        $this->load->model('admin/state_m');
        $this->load->model('admin/data_table_factory_model');
        $this->load->model('admin/state_m');
        $this->load->model('admin/selectors_m');
        $this->load->model('admin/charges_m');
        $this->load->model('admin/category_m');
        $this->load->model('admin/admin_academic_m');
        $this->load->model('admin/result_m');
        $this->load->model('admin/admitcard_m');
        $this->load->model('admin/answerkey_m');
        $this->load->model('admin/textslider_m');

        $this->load->model('app/app_exam_m');
        $this->load->model('app/app_academic_m');
        $this->load->model('app/app_payment_m');
        $this->load->model('app/app_application_m');
        $this->load->model('app/app_cart_m');
        $this->load->model('app/app_student_m');
        $this->load->model('app/app_certificate_m');
        $this->load->model('admin/application_m');
        $this->load->model('app/app_auth_m');
        $this->load->model('admin/log_m');
        $this->load->model('admin/feedback_m');
        $this->load->model('admin/exam_m');
        $this->load->model('cart/cart_m');
        $this->load->model('student/student_m');
        $this->load->model('outh_model');
        $this->load->model('apis/auth_model');

        date_default_timezone_set('Asia/Kolkata');
        $this->current_time = date('Y-m-d H:i:s');
        $this->today_date = date('m/d/Y');
        $this->todayDate = date('Y-m-d');
        $this->year = date('Y');
        $this->month = date('F');
        $this->expiry = date("Y-m-d H:i:s", time() + (60*60*8));

        include APPPATH. 'third_party/jwt/JWT.php';
        include(APPPATH.'third_party/phpmailer/src/Exception.php');
        include(APPPATH.'third_party/phpmailer/src/PHPMailer.php');
        include(APPPATH.'third_party/phpmailer/src/SMTP.php');
        include(APPPATH.'third_party/paytm/encdec_paytm.php');
        require(APPPATH.'third_party/razorpay/Razorpay.php');
        require(APPPATH.'third_party/sms_helper/smsalert.php');
        
        $this->user_name = $this->session->userdata('user_name');
        $this->name = $this->session->userdata('name');
        $this->role_id = $this->session->userdata('role_id');
        $this->user_id = $this->session->userdata('user_auth_id');

        // APP SESSION
        $this->student_auth_id = $this->session->userdata('verify_user_auth_id');
        $this->student_username = $this->session->userdata('verify_username');
        $this->student_role_id = $this->session->userdata('verify_role_id');
        $this->student_status = $this->session->userdata('verify_status');
        $this->student_mobile = $this->session->userdata('verify_mobile');
        $this->student_name = $this->session->userdata('verify_name');

        $this->apikey = '61408df730bf1'; // write your apikey in between ''
        $this->senderid = 'AAZAD'; // write your senderid in between ''
        $this->route = 'transactional'; // write your route in between ''
        $this->smsalert = new Smsalert($this->apikey, $this->senderid, $this->route);

        $sid    = "AC5bc8827754762b871f767fda8c0149b5"; 
        $token  = "a5dd0baa56a83dab1ffef3544360d121"; 
        $this->twilio = new Client($sid, $token); 

        $this->client_service = "formfromhomeMoboAppService";
        $this->auth_key = "$2y$10$0.miVyPBnY9R026sH3jbeODHg3gtlX69SX9lIxVyfKCl2GdYyrU9.";
        $this->Myapikey = "12345";

        $this->razorpay = new Api(get_settings('RAZOR_KEY'), get_settings('RAZOR_KEY_SECRET'));
    
        $this->sendgrid = new Mail();
}

//CLASS ENDS
    public function toLowerCase($data){
      foreach ($data as $key => $value) {
        $data[$key] = strtolower($value);
      }
      return $data;
     }

    public function allowedFiles($files){
        foreach ($files as $key1 => $img) {
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
                return false;
            }
            else{
                return true;
            }
        }
    }

    public function allowedFilesAcademic($files){
        foreach ($files as $key1 => $img) {
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'pdf') {
                return false;
            }
            else{
                return true;
            }
        }
    }

     public function create_url($string) {
      $string = strtolower($string);
      $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
      $string = preg_replace("/[\s-]+/", " ", $string);
      $string = preg_replace("/[\s_]/", "-", $string);
      return $string;
    }

    public function doUpload($files,$upload_url){
        $i = 1;
        foreach ($files as $key1 => $img) {
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            // $filename = preg_replace("/[^a-z0-9_\s-]/", "", date('Y-m-d h:i:s'));
            // $filename = preg_replace("/[\s-]+/", " ", $filename);
            // $filename = preg_replace("/[\s_]/", "-", $filename);
            // $_FILES[$key1]['name'] = $filename . '_'. $i . '.' . $ext;
            $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
            $config['upload_path'] = $upload_url;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 4000;
            $config['max_height'] = 4000;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($key1)) {
                return array('error' => $this->upload->display_errors());
            } else {
                array('upload_data' => $this->upload->data());
            }
            $i++;
        }
        return $_FILES;
    }


     public function doUpload1($upload_path,$filename){
      if(is_array($_FILES[$filename]['name'])){
        $multipleimage = '';
        for( $i=0;$i<(count($_FILES[$filename]['name']));$i++ ){
          //set files array
          $_FILES['file']['name'] = $_FILES[$filename]['name'][$i];
          $_FILES['file']['type'] = $_FILES[$filename]['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES[$filename]['tmp_name'][$i];
          $_FILES['file']['size'] = $_FILES[$filename]['size'][$i];
          $_FILES['file']['error'] = $_FILES[$filename]['error'][$i];
          //
          //
          $config['upload_path']          = './uploads/'.$filename.'/';
          $config['allowed_types']        = 'jpg|png|jpeg';
          $config['max_size']             = 5000;
          $config['max_width']            = 5000;
          $config['max_height']           = 5000;
          $config['file_name'] = $filename . '_' . date('Y-m-d h:i:s');
          $this->load->library('upload', $config, $filename);
          $this->$filename->initialize($config);
          if ( !$this->$filename->do_upload('file')){
            $error = $this->$filename->display_errors();
            $this->session->set_flashdata($filename . '_error', $error);
            return false;
          }
          else {
            $data = array('upload_data' => $this->$filename->data());
            $image = strtolower($data['upload_data']['file_name']);
            $image = addslashes($image);
            $multipleimage .= $image .',';
          }
        }
        return $multipleimage;
      }
      else{

        // $config['upload_path']          = $upload_path;
        // $config['allowed_types']        = 'jpg|png|jpeg';
        // $config['max_size']             = 2800;
        // $config['max_width']            = 2000;
        // $config['max_height']           = 2000;
        // $config['file_name'] = $filename . '_' . date('Y-m-d h:i:s');
        // $this->load->library('upload', $config, $filename);
        // $this->$filename->initialize($config);
        // if ($this->$filename->do_upload($filename)){
        //   $data = array('upload_data' => $this->$filename->data());
        //   $image = strtolower($data['upload_data']['file_name']);
        //   $image = addslashes($image);
        //   return $image;
        // }
        // else{
        //   print_r($this->$filename->display_errors());
        //   die;
        //   $this->session->set_flashdata($filename . '_error', $error);
        //   return false;
        // }

        $upload_url = 'uploads/student';
        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        $_FILES[$key1]['name'] = md5(date('Y-m-d H:i:s:u')) . time() . $i . '.' . $ext;
        $config['upload_path'] = $upload_url;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 10000000;
        $config['max_width'] = 4000;
        $config['max_height'] = 4000;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($key1)) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('notification', 'Something went wrong.');
            $this->data['page_title'] = 'send form to student';
            $this->app_view('app/student/profile', $this->data);
        } else {
            array('upload_data' => $this->upload->data());
        }
        $i++;





      }

    }


    public function dmy_to_ymd($date){
        return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
    }

    public function ymd_to_dmy($date){
        return date('d-m-Y', strtotime(str_replace('/', '-', $date)));
    }

    public function toUpperCaseObj($data){
        foreach ($data as $key => $value) {
          $data->$key = strtoupper($value);
        }
        return $data;
       }

    public function authenticate(){
        if(!$this->session->userdata('user_name')){
            redirect('login-auth');
        }
        else{
          return;
        }
    }

    public function app_authenticate(){
        if(!$this->session->userdata('verify_username')){
            redirect('app-login');
        }
        else{
          return;
        }
    }

    public function header(){
        $this->data['notifications'] = '5';
        $this->data['header_title'] = 'header';
        $this->load->view('admin/includes/header', $this->data);
    }

    public function view($template_view, $data){
        $this->authenticate();
        $this->header();
        $this->load->view($template_view, $data);
        $this->load->view('admin/includes/footer');
    }

    public function parsed($template_view, $data){
        $this->authenticate();
        $this->header();
        $this->parser->parse($template_view, $data);
        $this->load->view('admin/includes/footer');
    }

    public function app_header(){
        $this->data['notificationCount'] = $this->db->get_where('application', array('student_id'=>$this->student_auth_id, 'email_status'=>1, 'application_status'=>1))->num_rows();
        $this->data['header_title'] = 'header';
        $this->load->view('app/includes/header', $this->data);
    }

    public function app_view($template_view, $data){
        $this->app_header();
        $this->load->view($template_view, $data);
        $this->load->view('app/includes/footer');
    }

    public function decode($token){
        $jwt = new JWT();
        return $jwt->decode($token, SECRETKEY, ['HS256']);
    }

    public function encode($payload){
        $jwt = new JWT();
        return $jwt->encode($payload, SECRETKEY);
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

    public function get_an_obj_by_id($tbl, $col, $id){
        return $this->db->get_where($tbl, array($col=>$id))->row();
    }

    public function get_arr_of_obj($tbl){
        return $this->db->get($tbl)->result_array();
    }

    public function sendEmail($html, $subject, $receiver_mail){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "formfromhome.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@formfromhome.com'; // SMTP USER NAME (THE ONE WHO'S SMTP ACCOUNT WILL BE USED TO SEND EMAIL)
        $mail->Password = 'a!OCpq#laB16'; // PASSWORD

        $mail->setFrom('admin@formfromhome.com', 'Form From Home'); // EMAIL SENDER (THE ONE WHO FILL CONTACT FORM AND SENDS)
        $mail->addAddress($receiver_mail, 'Form From Home'); // EMAIL RECEIVER (THE ONE WHO RECIEVED EMAIL FROM THE CONTACT FORM)
        $mail->Subject = $subject;
        $mail->msgHTML($html); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        // $mail->AltBody = 'HTML messaging not supported';
        // $mail->addAttachment("https://formfromhome.com/resources/admin//dist/img/login/1.jpg"); //Attach an image file

        if(!$mail->send()){
            return false;
        }else{
            return true;
        }
    }

    public function sendEmailWithAttachment($html, $receiver_mail, $subject, $imgUrl, $filename){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "formfromhome.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@formfromhome.com'; // SMTP USER NAME (THE ONE WHO'S SMTP ACCOUNT WILL BE USED TO SEND EMAIL)
        $mail->Password = 'a!OCpq#laB16'; // PASSWORD

        $mail->setFrom('admin@formfromhome.com', 'Form From Home'); // EMAIL SENDER (THE ONE WHO FILL CONTACT FORM AND SENDS)
        $mail->addAddress($receiver_mail, 'Form From Home'); // EMAIL RECEIVER (THE ONE WHO RECIEVED EMAIL FROM THE CONTACT FORM)
        $mail->Subject = $subject;
        $mail->msgHTML($html); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        // $mail->AltBody = 'HTML messaging not supported';
        $mail->addAttachment("http://localhost/swati_ffh/uploads/form/affd6dcf47cbf8efda9738cb2e3375481589565792.pdf"); //Attach an image file
        if(!$mail->send()){
            return false;
        }else{
            return true;
        }
    }



}






class TableFactory
{

	public function renderTableHead($tableHeadArr, $pageTitle, $tableId, $pl){
		?>
			<div class="box" id = "allclient">
                <div class="box-header">
                    <div class="col-md-6 flex align-center hper-100">
                        <h3 class="box-title"><?php echo ucwords($pageTitle); ?></h3>
                    </div>
                    <div class="col-md-6 flex justify-content-end">
                      <?php
                        if($pl != null){
                          ?>
                            <a href="<?php echo base_url($pl); ?>" class="btn btn-primary">Add</a>
                          <?php
                        }
                      ?>
                    </div>


                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap p-lr-0">
                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
                    <div class="col-sm-12 table-responsive paddingNull p-lr-0">
                        <table id="<?php echo $tableId; ?>" class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr role="row" class="odd">
                                    <?php
                                        foreach ($tableHeadArr as $key) {
                                            ?>
                                                <th><?php echo ucwords($key); ?></th>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            </table>
                    </div>
                </div>
            </div>


		<?php
	}




}
