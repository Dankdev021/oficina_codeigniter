<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('pages/login');
        }
    }

    public function index() {
        $data['view'] = 'pages/dashboard';
        $this->load->view('layouts/main', $data);
    }
}
