<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submit extends CI_Controller {

	public function index()
	{
		$param = array('title' => 'Dashboard', 'body' => 'gbei/submit');
		$this->load->view('index.php', $param);
	}
}
