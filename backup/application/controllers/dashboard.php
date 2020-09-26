<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
	
		
		$param = array('title' => 'Dashboard', 'body' => 'gbei/dashboard');
		$this->load->view('index.php', $param);
	}
}
