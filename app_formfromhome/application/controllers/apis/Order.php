<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Order extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
    }

    public function createorder_post(){
        $method = $this->_detect_method();
        if (!$method == 'POST') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){                
                $totalAmount = $this->getTotalAmount($this->input->post('student_category'));
                $orderId = 'ORDER'.md5(uniqid(mt_rand(), true));
                $order = $this->razorpay->order->create(['receipt'=>$orderId,'amount'=>$totalAmount['total_chargeble_amount']*100,'currency'=>'INR']);
                $res = ['status'=>200,'message'=>'success','order'=>$order->id, 'amount'=>$totalAmount['total_chargeble_amount']];
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function authenticateorder_post(){
		$generated_signature = hash_hmac('sha256', $this->input->post('order_id'). "|" . $this->input->post('payment_id'), get_settings('RAZOR_KEY_SECRET'));
		if ($generated_signature == $this->input->post('signature')) {
			$product = $this->sanitize_array($this->input->post('product'));
			if($product === FALSE){
				$res = ['status'=>404,'message'=>'Invalid product detail.'];
			}
			else{
				$this->save_razorpay_detail();
				$this->save_main_payment($this->db->insert_id());
                $this->save_application_order($this->db->insert_id());
                $this->save_application_order_item($this->db->insert_id());
				$res = ['status'=>200,'message'=>'success'];
			}
		}
		else{
			$res = ['status'=>200,'message'=>'signature failure'];
		}
		echo json_encode($res);
	}

    private function sanitize_array(array $course) {
		if(is_array($course)){
			if(array_filter($course) == []){
				return false;
			}
			else{
				foreach ($course as $c){
					if(is_int($c) && (int)$c > 0 || ctype_digit($c)){
						return $course;
					}
					else{
						return false;
					}
				}
			}
		}
		else{
			return false;
		}
	}

	public function getorder_get(){
        $method = $this->_detect_method();
        if (!$method == 'GER') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $res = $this->db->get_obj('application_order','*',array('student_id'=>$this->head()['Student-Id']))->result_array();
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }

    public function getApplication_get(){
        $method = $this->_detect_method();
        if (!$method == 'GET') {
            $this->response(['status' => 400, 'message' => 'Bad request.'], REST_Controller::HTTP_OK);
        }
        else{
            $check_auth_client = $this->auth_model->check_auth_client($this->head());
            if($check_auth_client === true){
                $application_count = $this->db->get_obj('application','application_id',array('student_id'=>$this->head()['Student-Id']))->num_rows();
                if($application_count > 0){
                    $select = '
                            application.application_id,
                            application.exam_fee,
                            application.service_charge,
                            application.date,
                            application.application_status,
                            exam.name_of_post
                        ';
                    $join = array(
                            'exam'=>'exam.exam_id=application.exam_id'
                        );
                    $res = $this->db->get_obj('application',$select,array('application.student_id'=>$this->head()['Student-Id']),$join)->result_array();
                }
                else{
                    $res = ['status'=>200,'message'=>'No application found.'];
                }
                $this->response($res, REST_Controller::HTTP_OK);
            }
            $this->response($check_auth_client, REST_Controller::HTTP_OK);
        }
    }
    
    private function getTotalAmount($student_category){
        $total_product_fee = 0;
        $total_amount = 0;
        $total_service_charge = 0;
        $total_amount_with_gst = 0;

        
        $total_product_fee = $this->product_fee();
        $service_charge = $this->getServiceCharge();
        $product_count = count($this->input->post('product'));
        $total_service_charge = (float)$service_charge*(int)$product_count;
        $total_amount = $total_product_fee + $total_service_charge;
        // $total_amount_with_gst = $total_amount + (float)(get_settings('gst')/100)*(float)$total_amount;
        return ['total_chargeble_amount' => $total_amount];
    }

    private function product_fee(){
        $total_product_fee = 0;
        foreach($this->input->post('product') as $p){
            $product = $this->getProductDetail($p,$this->input->post('student_category'));
            $total_product_fee += (float)$product->exam_fee;
        }
        return $total_product_fee;
    }
      
    private function getServiceCharge(){
        return $this->db->get_where('service_charges', array('is_active'=>1))->row()->amount;
    }

    private function getProductDetail($id,$student_category){
        $this->db->select('*');
        $this->db->from('exam_fee');
        $this->db->where('exam_id', $id);
        $this->db->where('category_id', $student_category);
        return $this->db->get()->row();
    }


    private function save_razorpay_detail(){
        $application_filling_charge = count($this->input->post('product'))*(float)$this->getServiceCharge();
        $amount_paid = ($this->product_fee() + $application_filling_charge) + ($this->product_fee() + $application_filling_charge)*(float)(get_settings('gst')/100);
        $paymentRazorpay = array(
            'order_id' => $this->input->post('order_id'),
            'payment_id' => $this->input->post('payment_id'),
            'signature' => $this->input->post('signature'),
            'is_verified' => 1,
            'user_id' => $this->head()['Student-Id'],
            'total_amount' => $this->product_fee(),
            'application_filling_charge' => $application_filling_charge,
            'gst' => (float)get_settings('gst'),
            'amount_paid' => $amount_paid
        );
		return $this->db->insert('payment_by_razorpay', $paymentRazorpay);
	}

	private function save_main_payment($razorPayId){
        $application_filling_charge = count($this->input->post('product'))*(float)$this->getServiceCharge();
        $amount_paid = ($this->product_fee() + $application_filling_charge) + ($this->product_fee() + $application_filling_charge)*(float)(get_settings('gst')/100);
        $paymentMain = array(
            'user_id' => $this->head()['Student-Id'],
            'transaction_id' => $razorPayId,
            'transaction_name' => $this->input->post('payment_id'),
            'payment_method_id' => 7,
            'total_amount' => $this->product_fee(),
            'application_filling_charge' => $application_filling_charge,
            'gst' => (float)get_settings('gst'),
            'amount_paid' => $amount_paid,
        );
		$this->db->insert('payment_main', $paymentMain);
	}

    private function save_application_order($paymentId){
        $application_filling_charge = count($this->input->post('product'))*(float)$this->getServiceCharge();
        $amount_paid = ($this->product_fee() + $application_filling_charge) + ($this->product_fee() + $application_filling_charge)*(float)(get_settings('gst')/100);
        $applicationOrder = array(
            'payment_id' => $paymentId,
            'student_id' => $this->head()['Student-Id'],
            'total_payment' => $amount_paid,
            'date' => $this->current_time,
            'month' => strtolower($this->month),
            'year' => $this->year
        );
		$this->db->insert('application_order', $applicationOrder);
	}

    private function save_application_order_item($orderId){
        $service_charge = $this->getServiceCharge();
        foreach($this->input->post('product') as $p){
            $product = $this->getProductDetail($p,$this->input->post('student_category'));
            $application = array(
                'order_id' => $orderId,
                'exam_id' => $product->exam_id,
                'student_id' => $this->head()['Student-Id'],
                'exam_fee' => $product->exam_fee,
                'service_charge' => $service_charge,
                'year' => $this->year
            );
            $this->db->insert('application', $application);
        }
	}
    
// CLASS ENDS    	
}