<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function request(){
		if($this->input->post('submit1')){
          // GETTING CART ITEM
          $cart_item = $this->db->get_obj('cart', '*', array('student_id'=>$this->student_auth_id))->result_array();
          $tef = round(array_sum(array_column($cart_item, 'exam_fee')), 2);
          $tsc = round(array_sum(array_column($cart_item, 'service_charge')), 2);
          $TXNAMOUNT = (float)$tef+$tsc;

          // GENERAING ORDER NO.
          $today = date("Ymd");
          $rand1 = rand(1111111111,time());
          $randBytes = rand(1111111111,time());
          $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
          $ORDER = $today.$rand.$rand1.$randBytes;

					define("MERCHENTMID", "oPQIBd43653868680784");
					define("ORDERID", $ORDER);
					define("CHANNEL", "WEB");
					define("TXNAMOUNT", $TXNAMOUNT);
					define("WEBSITE", "DEFAULT");
			    	define("MOBILE", $this->student_mobile);
					define("CUSTID", $this->student_auth_id);
					define("INDUSTRYTYPE", "Retail");

					$paytmParams = array();
					$paytmParams["MID"] = MERCHENTMID;
					$paytmParams["ORDER_ID"] = ORDERID;
					$paytmParams["CUST_ID"] = CUSTID;
					$paytmParams["MOBILE_NO"] = MOBILE;
					$paytmParams["CHANNEL_ID"] = CHANNEL;
					$paytmParams["TXN_AMOUNT"] = TXNAMOUNT;
					$paytmParams["WEBSITE"] = WEBSITE;
					$paytmParams["INDUSTRY_TYPE_ID"] = INDUSTRYTYPE;
					// $paytmParams['MERC_UNQ_REF'] = $ap;

					$paytmParams["CALLBACK_URL"] = BASE_URL.'/app/payment/response';
					$this->data['paytmParams'] = $paytmParams;
					$this->data['MKEY'] = '@Pelwdam5tveRwL6';
          			$this->data['page_title'] = 'Fill your profile details.';
          			$this->app_view('app/cart/payment', $this->data);
					// $transactionURL = "https://securegw.paytm.in/theia/processTransaction"; // for production
				}
		}

		public function response(){
		    if($_POST['RESPCODE'] == 227){
		        $this->session->set_flashdata('notification', 'Payment declined by your bank due to wrong information.');
				redirect('cart');
		    }
		    
			$paytmChecksum = "";
			$paramList = array();
			$isValidChecksum = "FALSE";
			define('KEY', '@Pelwdam5tveRwL6');
			$paramList = $_POST;
			$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
			//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
			$isValidChecksum = verifychecksum_e($paramList, KEY, $paytmChecksum); //will return TRUE or FALSE string.

			if($isValidChecksum == "TRUE"){
				$payment = array(
					'CUST_ID' => $this->student_auth_id,
					'ORDERID' => $_POST['ORDERID'],
					'MID' => $_POST['MID'],
					'TXNID' => $_POST['TXNID'],
					'TXNAMOUNT' => $_POST['TXNAMOUNT'],
					'PAYMENTMODE' => $_POST['PAYMENTMODE'],
					'CURRENCY' => $_POST['CURRENCY'],
					'TXNDATE' => $_POST['TXNDATE'],
					'STATUS' => $_POST['STATUS'],
					'RESPCODE' => $_POST['RESPCODE'],
					'RESPMSG' => $_POST['RESPMSG'],
					'GATEWAYNAME' => $_POST['GATEWAYNAME'],
					'BANKTXNID' => $_POST['BANKTXNID'],
					'BANKNAME' => $_POST['BANKNAME'],
					'CHECKSUMHASH' => $_POST['CHECKSUMHASH']
				);

				$this->app_payment_m->add($payment,null);
				$lpi = $this->db->insert_id();

				$order = array(
					'payment_id'=>$lpi,
					'student_id'=>$this->student_auth_id,
					'total_payment'=>$_POST['TXNAMOUNT'],
					'date'=>$this->current_time,
					'month'=>strtolower($this->month),
					'year'=>$this->year
				);

				$this->db->insert('application_order', $order);
				$loi = $this->db->insert_id();

				// GETTING CART ITEM
				$cart_arr = $this->get_an_obj('cart', '*', array('student_id'=>$this->student_auth_id),'array');
				foreach ($cart_arr as $key => $c) {
					$order_item = array(
						'order_id'=>$loi,
						'exam_id'=>$c['exam_id'],
						'student_id'=>$this->student_auth_id,
						'exam_fee'=>$c['exam_fee'],
						'service_charge'=>$c['service_charge'],
						'date'=>$this->current_time,
						'month'=>strtolower($this->month),
						'year'=>$this->year
					);
					$this->db->insert('application', $order_item);
				}

				$this->app_cart_m->delete(array('student_id'=>$this->student_auth_id));
				$this->session->set_flashdata('notification', 'Your payment of '.$_POST['TXNAMOUNT'].' is processed successfully.');
				redirect('cart');
	      		exit();
			}
			else {
				echo "somethiong went wrong";
				//Process transaction as suspicious.
			}
	  }


	  
//CLASS ENDS
}
















/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */
