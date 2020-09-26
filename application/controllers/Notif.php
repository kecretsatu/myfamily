<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {
	
	public $user = "";
	
	function __construct(){
		parent::__construct();
		$this->load->model('Dashboard_Model');
		$this->load->model('Modul_Model');
		
		$this->user = $this->input->post("user");
		//$this->user = "uqhy@gmail.com";
	}

	public function index()
	{
		//$param = array('title' => 'Dashboard', 'body' => 'admin/dashboard');		
		
		//$this->load->view('index.php', $param);
	}
	
	public function get(){
		
		$result = array(
			"result" => 1, 
			"relative_request" => $this->getRequestRelative(), 
			"relative_request_count" => $this->Modul_Model->read("select count(*) as 'total' from `user` where email in (select `user` from relative where relative = '".$this->user."' and (status = 0 or status = 1))")[0]["total"], 
			"relative_confirm" => $this->getConfirmRelative()
		);
		echo json_encode($result);
	}
	
	public function getRequestRelative(){
		
		$data = $this->Modul_Model->read(" select * from `user` where email in (select `user` from relative where relative = '".$this->user."' and status = 0)");
		
		$query = "update relative set status = 1 where relative = '".$this->user."' and status = 0";
		$this->Modul_Model->execute($query);
		
		return $data;
	}
	
	public function getConfirmRelative(){
		
		$data = $this->Modul_Model->read(" select * from `user` where email in (select `relative` from relative where `user` = '".$this->user."' and status = 10)");
		
		$query = "update relative set status = 11 where `user` = '".$this->user."' and status = 10";
		$this->Modul_Model->execute($query);
		
		return $data;
	}
	
}
