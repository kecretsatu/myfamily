<?php
class Test extends CI_Controller {
	public function index()
	{
		echo "Hello World!";
		$this->load->view('test/test');
		/* SERVERPATH/index.php/test */
	}
	
	public function hello()
	{
		echo "This is hello function.";
		/* SERVERPATH/index.php/test/hello */
	}
}
?>