<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Application extends MY_Controller{

  public function __construct(){
    parent::__construct();
  }

    public function get_all_notification(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($this->student_username){
          // GETTING ALL NOTIFICATION.
          $notification_arr  = $this->app_application_m->get_notification();
          $res = ['status'=>200, 'message'=>$notification_arr];
          echo json_encode($res);
        }
        else{
          $res = ['status'=>400, 'message'=>'bad request.'];
          echo json_encode($res);
        }
      }
      else{
        $res = ['status'=>400, 'message'=>'bad request.'];
        echo json_encode($res);
      }
  }



    public function index(){
      $this->data['order_history'] = $this->app_application_m->get_order_history();
      $this->data['page_title'] = 'Your order history';
      $this->app_view('app/order/order',$this->data);
    }

//END class
}
