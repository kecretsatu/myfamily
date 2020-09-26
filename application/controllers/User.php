<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Modul_Model');
	}

	public function index()
	{
		$param = array(
			'title' => $this->my('title'), 
			'body' => $this->my('bodyPath'), 
			'getURL' => $this->my('getURL'), 
			'addURL' => $this->my('addURL'),
			'editURL' => $this->my("editURL"), 
			'viewURL' => $this->my("viewURL") 
		);
		$this->load->view('index.php', $param);
	}
	
	public function get(){
		if($this->input->get("key")){
			$user = $this->input->get("key");
			$group = $this->Modul_Model->read("select `group` from person where `key` = '".$user."'")[0]["group"];
	
			$person = $this->Modul_Model->read("select * from person where `group` = '".$group."' order by `index`");
			$result	= $this->Modul_Model->read("select email as 'key', email as '1', first_name as '2', marga as '3' from `user` where email in (select `key` from person where `group` = '".$group."') or email in (select `couple` from person where `group` = '".$group."') ");
		}
		else{	
			$result = $this->Modul_Model->read($this->my("getQuery"));
		}	
		echo json_encode($result);
		
	}
	
	public function buildNumber($n, $length){
		$v = "";
		for($i = 1; $i <= $length - strlen($n); $i++){
			$v .= "0";
		}
		$v .= $n;
		return $v;
	}

	public function add()
	{				
		$param = array(
			'title' => $this->my("title"), 
			'body' => $this->my("formPath"), 
			'area' => $this->my("area"),
			'data' => false,
			'form' => "add", 
			'postURL' => $this->my("postURL"), 
			'listFiles' => null
		);
		$this->load->view('index.php', $param);
	}

	public function edit()
	{		
		$id = $this->input->get('key');
		$data = $this->Modul_Model->read("select * from user where email = '".$id."'");
		
		$param = array(
			'key' => $id, 
			'title' => $this->my("title"), 
			'body' => $this->my("formPath"), 
			'data' => $data,
			'form' => "edit", 
			'postURL' => $this->my("postURL"), 
			'listFiles' => null
		);
		$this->load->view('index.php', $param);
	}
	
	public function post()
	{	
		$data = $this->my("postData");
		
		$key = ""; 
		
		if($this->input->post('crud') == "add"){			
			$result = $this->Modul_Model->insert($this->my("tableName"), $data);
		}
		else if($this->input->post('crud') == "edit"){
			$key = $this->input->post('key');
			$result = $this->Modul_Model->update($this->my("tableName"), $data, "id", $key);
		}
		
		if($result){			
			echo '[{"status":"1", "msg":"Data berhasil disimpan"}]';
		}
		else{
			echo '[{"status":"0", "msg":"Maaf, Data gagal disimpan. '.$result.'"}]';
		}
	}
	
	public function my($str){
		if($str == "title"){
			$t = "User";
			if($this->input->get("key")){
				$t .= " | " .$this->input->get("key");
			}
			return $t;
		}
		else if($str == "bodyPath"){
			return 'admin/user';
		}
		else if($str == "getQuery"){
			$query = "select email as 'key', email as '1', first_name as '2', marga as '3' from user where is_user = 1";					
			return $query;
		}
		else if($str == "formPath"){
			return 'admin/user/edit.php';
		}
		else if($str == "addURL"){
			return base_url().'user/add';
		}
		else if($str == "editURL"){
			return base_url().'user/edit';
		}
		else if($str == "viewURL"){
			return base_url().'user';
		}
		else if($str == "getURL"){
			$t = base_url().'user/get';
			if($this->input->get("key")){
				$t .= "?key=" . $this->input->get("key");
			}
			return $t;
		}
		else if($str == "postURL"){
			return base_url().'ab/post';
		}
		else if($str == "tableName"){
			return "user";
		}
		else if($str == "postData"){
			$data = array(
				'id_wilayah'	=> $this->input->post('id_wilayah'),
				'nama'			=> $this->input->post('nama')
			);
			return $data;
		}
		else if($str == "area"){
			$query = "select *, (select nama from gbei_wilayah where id = id_wilayah) as 'wilayah' from gbei_area order by id_wilayah, nama";
			$result = $this->Modul_Model->read($query);
			return $result;
		}
	}
}
