<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Zip extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $directory = 'uploads/student';
        $data["images"] = glob($directory . "/*.jpg");
        $this->load->view('admin/zip/download', $data);
    }
    public function download() {
        if ($this->input->post('images')) {
            $this->load->library('zip');
            $images = $this->input->post('images');
            foreach ($images as $image) {
                $this->zip->read_file($image);
            }
            $this->zip->download('' . time() . '.zip');
        }
    }
    // CLASS ENDS
    
}
