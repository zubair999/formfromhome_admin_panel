<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}


		public function request($data){
			$cartData = $this->decode($data);
			$AMOUNT = $cartData->data->amount;
			$CUSTID = $cartData->data->student;
			$ITEM = $cartData->data->item;
			$ITEMCOUNT = COUNT($ITEM);
			$ITEM = implode(",",$ITEM);

			$MOBILE = $this->db->get_obj('user_auth_detail','mobile',array('user_auth_id'=>$CUSTID))->row()->mobile;
			$SERVICECHARGE = $this->db->get_obj('service_charges','amount',array('is_active'=>1))->row()->amount;
			$TXNAMOUNT = $AMOUNT + 2 * $SERVICECHARGE;

      // // GENERAING ORDER NO.
      $today = date("Ymd");
      $rand1 = rand(1111111111,time());
      $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
      $ORDER = $today.$rand;
			//
			define("MERCHENTMID", "oPQIBd43653868680784");
			define("ORDERID", $ORDER);
			define("CHANNEL", "WEB");
			define("TXNAMOUNT", $TXNAMOUNT);
			define("WEBSITE", "DEFAULT");
	    define("MOBILE", $MOBILE);
			define("CUSTID", $CUSTID);
			define("INDUSTRYTYPE", "Retail");
			//
			$paytmParams = array();
			$paytmParams["MID"] = MERCHENTMID;
			$paytmParams["ORDER_ID"] = ORDERID;
			$paytmParams["CUST_ID"] = CUSTID;
			$paytmParams["MOBILE_NO"] = MOBILE;
			$paytmParams["CHANNEL_ID"] = CHANNEL;
			$paytmParams["TXN_AMOUNT"] = TXNAMOUNT;
			$paytmParams["WEBSITE"] = WEBSITE;
			$paytmParams["INDUSTRY_TYPE_ID"] = INDUSTRYTYPE;
			$paytmParams["MERC_UNQ_REF"] = $CUSTID;
			$paytmParams["PROMO_CAMP_ID"] = $ITEM;

			$paytmParams["CALLBACK_URL"] = BASE_URL.'/apis/payment/response';
			$this->data['paytmParams'] = $paytmParams;
			$this->data['MKEY'] = '@Pelwdam5tveRwL6';
			$this->data['page_title'] = 'Fill your profile details.';
			$this->load->view('app/cart/payment', $this->data);
		}


		public function response(){
		    if($_POST['RESPCODE'] == 227){
		        $this->session->set_flashdata('notification', 'Payment declined by your bank due to wrong information.');
						redirect('cart');
		    }
				if($_POST['STATUS'] == 'TXN_SUCCESS'){
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
							'CUST_ID' => $_POST['MERC_UNQ_REF'],
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
							'student_id'=>$_POST['MERC_UNQ_REF'],
							'total_payment'=>$_POST['TXNAMOUNT'],
							'date'=>$this->current_time,
							'month'=>strtolower($this->month),
							'year'=>$this->year
						);

						$this->db->insert('application_order', $order);
						$loi = $this->db->insert_id();
						$serviceCharge = $this->db->get_obj('service_charges','amount',array('is_active'=>1))->row()->amount;

						// GETTING CART ITEM
						$items = explode(",",$_POST['PROMO_CAMP_ID']);
						$category_id = $this->db->get_obj('student_info','category_id',array('student_id'=>$_POST['MERC_UNQ_REF']))->row()->category_id;

						foreach ($items as $key => $c) {
							$exam_fee = $this->db->get_where('exam_fee', array('category_id'=>$category_id, 'exam_id'=>$c))->row()->exam_fee;

							$order_item = array(
								'order_id'=>$loi,
								'exam_id'=>$c,
								'student_id'=>$_POST['MERC_UNQ_REF'],
								'exam_fee'=>$exam_fee,
								'service_charge'=>$serviceCharge,
								'date'=>$this->current_time,
								'month'=>strtolower($this->month),
								'year'=>$this->year
							);
							$this->db->insert('application', $order_item);
						}

						$this->session->set_flashdata('notification', 'Payment Success');
						redirect('cart');
			      exit();
				}
				if($_POST['STATUS'] == 'TXN_FAILURE'){
					$this->session->set_flashdata('notification', 'Payment Failure');
					redirect('cart');
					exit();
				}

			}
			else {
				$this->session->set_flashdata('notification', 'Something Went Wrong');
				redirect('cart');
				exit();
				//Process transaction as suspicious.
			}
	  }


//CLASS ENDS
}
















/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */
