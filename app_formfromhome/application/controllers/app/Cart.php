<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends MY_Controller{

  public function __construct(){
    parent::__construct();
  }

  // public function view_cart(){
  //   $this->data['cartCount'] = $this->db->get_where('cart', array('student_id'=>$this->student_auth_id))->num_rows();
  //   $this->data['cart_item'] = $this->app_cart_m->get_cart_item()['cart_item'];
  //   $this->data['summary'] = $this->app_cart_m->get_cart_item()['summary'];
  //   $this->data['page_title'] = 'my cart';
  //   $this->app_view('app/cart/cart',$this->data);
  // }

  public function view_cart(){
    $this->data['page_title'] = 'my cart';
    $this->load->view('app/cart/new_cart',$this->data);
  }

  public function save_item_to_cart(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $exam_id = $this->outh_model->Encryptor('decrypt', $this->input->post('exam_id'));
      if($exam_id == false){
        $res = ['status'=>422,'message'=>'action not valid.'];
        echo json_encode($res);
      }
      else{
        // CHECK IF STUDENT ALREADY ADDED THE EXAM.
        $exam_obj = $this->get_an_obj('cart', '*', array('exam_id'=>$exam_id, 'student_id'=>$this->student_auth_id), 'row');
        if(is_object($exam_obj)){
          $res = ['status'=>101,'message'=>'this exam is already added to your cart.'];
          echo json_encode($res);
          exit();
        }
        else{
          // GETTING STDUENT CATEGORY.
          $cid = $this->get_an_obj('student_info', 'category_id', array('student_id'=>$this->student_auth_id), 'row')->category_id;
          // GETTING EXAM FEE ACCORDING TO STDUENT CATEGORY.
          $ef = $this->get_an_obj('exam_fee', 'exam_fee', array('category_id'=>$cid,'exam_id'=>$exam_id), 'row')->exam_fee;
          // GETTING SERVICE CHARGE.
          $sc = $this->get_an_obj('service_charges', 'amount', null, 'row')->amount;
          $data = array('exam_id' => $exam_id, 'student_id'=>$this->student_auth_id,'exam_fee' => $ef, 'service_charge'=>$sc);
          // SAVING ITEM TO CART
          $this->app_cart_m->add($data, null);
          $res = ['status'=>200,'message'=>'item added to cart.'];
          echo json_encode($res);
          exit();
        }
      }
    }
    else{
      $res = ['status'=>400,'message'=>'bad request.'];
      echo json_encode($res);
    }
  }

  public function delete_cart_item(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $cart_id = $this->outh_model->Encryptor('decrypt', $this->input->post('cart_item'));
      if($cart_id == false){
        $res = ['status'=>422,'message'=>'action not valid.'];
        echo json_encode($res);
      }
      else{
        $res = $this->app_cart_m->delete(array('cart_id'=>$cart_id));
        $res = ['status'=>200,'message'=>$res];
        echo json_encode($res);
      }
    }
    else{
      $res = ['status'=>404,'message'=>'bad request.'];
      echo json_encode($res);
    }
  }

  //CLASS END
}
