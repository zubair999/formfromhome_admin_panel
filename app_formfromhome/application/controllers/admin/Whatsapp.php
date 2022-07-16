<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Whatsapp extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    


    public function sendMsg(){
        
        
        $message = $this->twilio->messages 
                        ->create("whatsapp:+919897753786", // to 
                                array( 
                                    "from" => "whatsapp:+14155238886",       
                                    "body" => "Hello hello helloooolk sdjfkl sdlkfjdsklfjkljkl",
                                    "mediaUrl" => ["https://demo.twilio.com/owl.png"] 
                                ) 
                        ); 
        
        print($message->sid);
    }

    


  //END CLASS
}
