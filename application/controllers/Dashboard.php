<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Dashboard_Model');
		$this->load->model('Modul_Model');
	}

	public function index()
	{
		$param = array('title' => 'Dashboard', 'body' => 'admin/dashboard');		
		
		$this->load->view('index.php', $param);
	}
}
