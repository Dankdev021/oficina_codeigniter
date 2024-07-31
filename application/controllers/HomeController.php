<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function index()
	{
		//$this->load->view('layouts/header');
        $this->load->view('pages/carrossel');
        //$this->load->view('layouts/footer');
	}

}