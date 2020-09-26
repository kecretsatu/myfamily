<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if(isset($this->session->userdata["userlogin"])){
			header("location: ".base_url());
		}
		else{
			$this->load->view('login.php');
		}
	}
}
