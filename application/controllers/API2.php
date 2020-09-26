<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Modul_Model');
	}

	public function index()
	{
		//$param = array('title' => 'Dashboard', 'body' => 'admin/dashboard');		
		
		//$this->load->view('index.php', $param);
		
		$email = "uqhy@gmail.com";
		$data = $this->Modul_Model->read("select * from `user` where email = '".$email."'");
		$result = array("result" => 1, "data" => $data[0]);	
		echo json_encode($result);
	}
	
	public function relation(){
		$user = $this->input->post("user");
		//$user = 'uqhy@gmail.com';
		
		$group = $this->Modul_Model->read("select `group` from person where `key` = '".$user."'")[0]["group"];
		
		$person = $this->Modul_Model->read("select * from person where `group` = '".$group."' order by `index`");
		$user	= $this->Modul_Model->read("select * from `user` where email in (select `key` from person where `group` = '".$group."' order by `index`) or email in (select `couple` from person where `group` = '".$group."') ");
		
		$result = array("data" => $user, "person" => $person);
		echo json_encode($result);
	}
	
	public function getRelative(){
		$user = $this->input->post("user");
		//$user = 'uqhy@gmail.com';
		
		$target = $user;
		if($this->input->post("target")){
			$target = $this->input->post("target");
			$group = $this->Modul_Model->read("select `group` from person where `key` = '".$target."'")[0]["group"];
			$user	= $this->Modul_Model->read("select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status',
						(select `key` from person where `index` = 0 and `group` = (select `group` from person where `key` = u.email or `couple` = u.email limit 0, 1)) as 'master' 
						from `user` u where u.email <> '".$target."' and u.email in (select `key` from person where `group`  = '".$group."' order by `index` ) ");
		}
		else{
			$user	= $this->Modul_Model->read("select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status',
						(select `key` from person where `index` = 0 and `group` = (select `group` from person where `key` = u.email or `couple` = u.email limit 0, 1)) as 'master' 
						from `user` u where u.email in (select `relative` from relative where `user`  = '".$user."' ) order by tanggal_lahir ");
		}
		
		if(count($user) > 0){
			for($i = 0; $i < count($user); $i++){
				if($this->input->post("target")){
					$user[$i]["master_detail"] = $this->Modul_Model->read("select * from `user` where email =  '".$user[$i]["master"]."'")[0];
				}
				
				$path	= "./assets/images/person/small/" . $user[$i]["email"] . ".jpg";
				if(file_exists($path)){ $thumb 					= file_get_contents($path); $thumb = base64_encode($thumb); $user[$i]["thumb"] = $thumb; }
				else{ $user[$i]["thumb"] = ""; }
			}
		}
		
		/*$x = $user[0];
		for($i = 1; $i < 30; $i++){
			array_push($user, $x);
		}*/
		
		$result = array("data" => $user, "msg" => "", "result" => 1);
		echo json_encode($result);
	}
	
	public function getRequestRelative(){
		$user = $this->input->post("user");
		//$user = 'uqhy@gmail.com';
		$user	= $this->Modul_Model->read("select u.* 
							from `user` u where u.email in (select `user` from relative where `relative`  = '".$user."' and (status = 0 or status = 1)) ");
		
		/*$x = $user[0];
		for($i = 1; $i < 30; $i++){
			array_push($user, $x);
		}*/
		
		$result = array("data" => $user, "msg" => "", "result" => 1);
		echo json_encode($result);
	}
	
	public function getPerson(){
		$user = $this->input->post("user");
		//$user = "uqhy@gmail.com";
		$data = $this->Modul_Model->read("select * from `user` where `email` = '".$user."'");
		
		$result = array("data" => $data);
		echo json_encode($result);
	}
	
	public function getPersonDetail(){
		$user = $this->input->post("user");
		$user = 'uqhy@gmail.com';
		
		$target = $this->input->post("target");
		//$target = "uqhy@gmail.com_4078245";
		$target = "uqhy@gmail.com";
		
		$myself		= $this->Modul_Model->read("select * from `user` where `email` = '".$target."'");
		$parentKey	= $this->Modul_Model->read("select `parent` from person where `key` = '".$target."'")[0]["parent"];
		$group		= $this->Modul_Model->read("select `group` from person where `key` = '".$target."'")[0]["group"];
		$child		= $this->Modul_Model->read("select * from `user` where email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$target."') order by tanggal_lahir ");
		
		$parent 	= [];
		$sibling 	= [];
		$couple 	= [];
		if($parent != "-"){
			$parent		= $this->Modul_Model->read("select * from `user` where email = '".$parentKey."' ");	
			$mother		= $this->Modul_Model->read("select * from `user` where email = (select couple from person where `key` = '".$parentKey."') ");	
			$sibling	= $this->Modul_Model->read("select * from `user` where email <> '".$target."' and email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$parentKey."') order by tanggal_lahir ");	
			$couple		= $this->Modul_Model->read("select * from `user` where email in (select `couple` from person where `group` = '".$group."' and `key`  = '".$target."') order by tanggal_lahir ");	
						
			/*$child		= $this->Modul_Model->read("select * from `user` where email <> '".$target."' and
							(email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$target."') or 
							email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$parentKey."'))
							and tanggal_lahir >= '".$myself[0]["tanggal_lahir"]."'
							order by tanggal_lahir ");*/
							
			
			$q = "	select *, tanggal_lahir as 'tanggal', 'child' as 'of' from `user` 
					where email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$target."')
					union
					select *, tanggal_lahir as 'tanggal', 'sibling' as 'of' from `user` where email <> '".$target."' and tanggal_lahir >= '".$myself[0]["tanggal_lahir"]."' and 
					email in (select `key` from person where `group` = '".$group."' and `parent`  = '".$parentKey."')
					";
					
			if($myself[0]["tanggal_menikah"] != "0000-00-00"){
				$q .= " union select *, tanggal_menikah as 'tanggal', 'marriage' as 'of' from `user` where email = '".$target."' ";
			}
			if($parent[0]["tanggal_meninggal"] != "0000-00-00" && $parent[0]["hidup"] != "0"){
				$q .= " union select *, tanggal_meninggal as 'tanggal', 'father_died' as 'of' from `user` where email = '".$parent[0]["email"]."' ";
			}
			if($mother[0]["tanggal_meninggal"] != "0000-00-00" && $mother[0]["hidup"] != "0"){
				$q .= " union select *, tanggal_meninggal as 'tanggal', 'mother_died' as 'of' from `user` where email = '".$mother[0]["email"]."' ";
			}
			if($myself[0]["tanggal_meninggal"] != "0000-00-00" && $myself[0]["hidup"] != "0"){
				$q .= " union select *, tanggal_meninggal as 'tanggal', 'me_died' as 'of' from `user` where email = '".$target."' ";
			}
			
			$q .= " order by tanggal ";
			//echo $q;
			$child  = $this->Modul_Model->read($q);
		}
		
		$sonCount		= 0;
		$daughterCount	= 0;
		$brotherCount	= 0;
		$sisterCount	= 0;
		
		foreach($child as $c){
			if($c["jenkel"] == 1){
				$sonCount++;
			}
			else{
				$daughterCount++;
			}
		}
		
		foreach($sibling as $s){
			if($s["jenkel"] == 1){
				$brotherCount++;
			}
			else{
				$sisterCount++;
			}
		}
		
		$result = array("myself" => $myself, "parent" => $parent, "mother" => $mother, "couple" => $couple, "child" => $child, "sibling" => $sibling, 
						"sonCount" => $sonCount, "daughterCount" => $daughterCount, 
						"brotherCount" => $brotherCount, "sisterCount" => $sisterCount, 
						"msg" => "", "result" => 1);
		echo json_encode($result);
	}
	
	public function register(){
		$email		= $this->input->post("email");
		$first_name	= $this->input->post("first_name");
		$last_name	= $this->input->post("last_name");
		$password	= $this->input->post("password");
		
		$crud		= $this->input->post("crud");
		
		$query = "insert into user (email, first_name, last_name, jenkel, hidup, is_user, status, user_saved, date_saved) 
					values ('".$email."', '".$first_name."', '".$last_name."', '1', '1', '1', '1', '".$email."', now())";
		
		$result = array("result" => 0);
		
		$user = $email;
		if($this->Modul_Model->execute($query)){
			$query = "insert into user_login (uname, upwd) 
					values ('".$email."', '".$password."')";
			if($this->Modul_Model->execute($query)){
				$group = $this->buildNewGroup();
				
				$emailF = $this->buildCustomID($user);
				$emailM = $this->buildCustomID($user);
				
				$query = "insert into person (`key`, `parent`, `couple`, `group`, `index`) 
						values ('".$email."', '".$emailF."', '-', '".$group."', 0)";
				$this->Modul_Model->execute($query);
				
				$queryP = "insert into person (`key`, `parent`, `couple`, `group`, `index`) 
						values ('".$emailF."', '-', '".$emailM."', '".$group."', -1)";
				$queryF = "insert into `user` (email, first_name, jenkel, hidup, status, user_saved, date_saved) 
									values ('".$emailF."', 'Father', '1', '1', '2', '".$user."', now())";
				$queryM = "insert into `user` (email, first_name, jenkel, hidup, status, user_saved, date_saved) 
									values ('".$emailM."', 'Mother', '0', '1', '2', '".$user."', now())";
				
				$this->Modul_Model->execute($queryP);
				$this->Modul_Model->execute($queryF);
				$this->Modul_Model->execute($queryM);
						
				$data = $this->Modul_Model->read("select * from user where email = '".$email."'");
				$me = $this->Modul_Model->read("select * from person where `key` = '".$email."'");
				
				$result = array("result" => 1, "data" => $data[0], "me" => $me[0], "msg" => "Register Berhasil");	
			}
		}
		
		echo json_encode($result);
	}
	
	public function login(){
		//$this->writeFile("files/register.txt", json_encode($_POST));//$this->input->post
		$email		= $this->input->post("email");
		$password	= $this->input->post("password");
		
		$result = array("result" => 0,"msg" => "Username tidak ditemukan");
		
		$data = $this->Modul_Model->read("select * from user_login where (uname = '".$email."' or uname2 = '".$email."')");
		
		if(count($data) > 0){
			$data = $data[0];
			if($data["upwd"] != $password){
				$result = array("result" => -1, "msg" => "Username atau password salah");
			}
			else{
				$email = $data["uname"];
				$uname2 = $data["uname2"];
				$data = $this->Modul_Model->read("select * from `user` where email = '".$email."'");
				
				$me = $this->Modul_Model->read("select * from person where `key` = '".$email."'");
				
				$result = array("result" => 1, "data" => $data[0], "me" => $me[0], "uname2" => $uname2, "msg" => "Login Berhasil");	
			}
		}
		
		echo json_encode($result);
	}
	
	public function changePassword(){
		$email		= $this->input->post("email");
		$oldpwd		= $this->input->post("old");
		$pwd		= $this->input->post("pwd");
		$pwd2		= $this->input->post("pwd2");
		
		$user		= $this->Modul_Model->read("select * from `user_login` where uname = '".$email."'");
		
		$result = array("result" => 0,"msg" => "Username tidak ditemukan");
		
		if(count($user) <= 0){
			echo json_encode($result);
			exit;
		}
		$user = $user[0];
		if($user["upwd"] != $oldpwd){
			$result = array("result" => 0,"msg" => "Old Password Not Valid");
		}
		else if($pwd != $pwd2){
			$result = array("result" => 0,"msg" => "Confirm Password Not Valid");
		}
		else{
			$query = "update `user_login` set upwd = '".$pwd2."' where uname = '".$email."'  ";
			if($this->Modul_Model->execute($query)){
				$result = array("result" => 1,"msg" => "Change Password Success");
			}
			else{
				$result = array("result" => 0,"msg" => "Something wrong, Change Password Failed. Please try again later");	
			}
		}
		
		echo json_encode($result);
	}
	
	public function changeUsername(){
		$email		= $this->input->post("email");
		$newName	= $this->input->post("newName");
		
		$user		= $this->Modul_Model->read("select * from `user_login` where uname = '".$email."'");
		
		$result = array("result" => 0,"msg" => "Username tidak ditemukan");
		
		if(count($user) <= 0){
			echo json_encode($result);
			exit;
		}
		
		$user = $user[0];
		if($user["uname2"] == $newName){
			$result = array("result" => 0,"msg" => "Username tidak berubah");
		}
		else{
			$userExist		= $this->Modul_Model->read("select * from `user_login` where (uname = '".$newName."' or uname2 = '".$newName."')");
			if(count($userExist) > 0){
				$result = array("result" => 0,"msg" => "Username telah terpakai");
				echo json_encode($result);
				exit;
			}
			
			$query = "update `user_login` set uname2 = '".$newName."' where uname = '".$email."'  ";
			if($this->Modul_Model->execute($query)){
				$result = array("result" => 1,"msg" => "Edit Username Success");
			}
			else{
				$result = array("result" => 0,"msg" => "Something wrong, Edit Username Failed. Please try again later");	
			}
		}
		
		echo json_encode($result);
	}
	
	public function person(){		
		//$this->writeFile("files/person.txt", json_encode($_POST));//$this->input->post
		$data = array(); $dataC = array(); $person = array(); $msg = ""; $r = 0;
		
		$ACTION_TYPE	= $this->input->post("ACTION_TYPE");
		
		$first_name		= $this->input->post("first_name");
		$last_name		= $this->input->post("last_name");
		$marga			= $this->input->post("marga");
		$jenkel			= $this->input->post("jenkel");
		$hidup			= $this->input->post("hidup");
		$tanggal_lahir	= $this->input->post("tanggal_lahir");
		$tempat_lahir	= $this->input->post("tempat_lahir");
		$tanggal_meninggal	= $this->input->post("tanggal_meninggal");
		$tempat_meninggal	= $this->input->post("tempat_meninggal");
		$alamat			= $this->input->post("alamat");
		$kota			= $this->input->post("kota");
		
		$parent			= $this->input->post("parent");
		$key			= $this->input->post("key");
		$user			= $this->input->post("user");
		
		$keep			= $this->input->post("keep");
				
		if($ACTION_TYPE != 11){
			if($keep == 0){
				$queryExist = "select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status'  
					from `user` u where u.first_name like '%".$first_name."%' and u.marga like '%".$marga."%'  ";
				
				$dataExist = $this->Modul_Model->read($queryExist);
				if(count($dataExist) > 0){
					for($i = 0; $i < count($dataExist); $i++){
						$path	= "./assets/images/person/small/" . $dataExist[$i]["email"] . ".jpg";
						if(file_exists($path)){ $thumb 					= file_get_contents($path); $thumb = base64_encode($thumb); $dataExist[$i]["thumb"] = $thumb; }
						else{ $dataExist[$i]["thumb"] = ""; }
						
						array_push($data, $dataExist[$i]);
					}
					
					$result = array("result" => 10, "data" => $dataExist, "msg" => $msg);
					echo json_encode($result);
					exit;
				}
			}
		}
		
		if($ACTION_TYPE == 11){
			$profile		= $this->Modul_Model->read("select * from person where `key` = '".$key."' or `couple` = '".$key."' ");
		
			if(count($profile) > 0){
				$query = "update `user` set first_name = '".$first_name."', last_name = '".$last_name."', marga = '".$marga."', jenkel = '".$jenkel."', hidup = '".$hidup."', 
							tanggal_lahir = '".$tanggal_lahir."', tempat_lahir = '".$tempat_lahir."', 
							tanggal_meninggal = '".$tanggal_meninggal."', tempat_meninggal = '".$tempat_meninggal."', alamat = '".$alamat."', kota = '".$kota."', 
							status = 2, user_saved = '".$user."', date_saved = now() where email = '".$key."' ";
				
				if($this->Modul_Model->execute($query)){
					if($profile[0]["key"] == $user){
						if($profile[0]["group"] == "-"){
							$group = $this->buildNewGroup();
							$query = "update person set `group` = '".$group."' where `key` = '".$user."' ";
							$this->Modul_Model->execute($query);
						}
					}
					
					$data	= $this->Modul_Model->read("select * from user where email = '".$key."'")[0];
					$person	= $this->Modul_Model->read("select * from person where `key` = '".$profile[0]["key"]."'")[0];
					$r 		= 1; $msg = "Edit Profile Success ";
				}
				
				$this->upload($key, "file-1");
			}
		}
		if($ACTION_TYPE == 12){			
			$profile		= $this->Modul_Model->read("select * from person where `key` = '".$key."' ");
			
			if(count($profile) > 0){
				$email = $this->buildCustomID($user);
				$query = "insert into `user` (email, first_name, last_name, marga, jenkel, hidup, tanggal_lahir, tempat_lahir, tanggal_meninggal, tempat_meninggal, 
								alamat, kota, status, user_saved, date_saved) 
								values ('".$email."', '".$first_name."', '".$last_name."', '".$marga."', '".$jenkel."', '".$hidup."', '".$tanggal_lahir."', '".$tempat_lahir."', 
								'".$tanggal_meninggal."', '".$tempat_meninggal."', '".$alamat."', '".$kota."', '2', '".$user."', now())";
				if($this->Modul_Model->execute($query)){
					$query = "update person set `couple` = '".$email."' where `key` = '".$key."' ";
					$this->Modul_Model->execute($query);
					
					$data	= $this->Modul_Model->read("select * from user where email = '".$email."'")[0];
					$person	= $this->Modul_Model->read("select * from person where `key` = '".$key."'")[0];
					$r 		= 1; $msg = "Add Couple Success ";
				}
				
				$this->upload($email, "file-1");
			}
		}
		if($ACTION_TYPE == 13 || $ACTION_TYPE == 14){
			if($ACTION_TYPE == 14){
				$key = $parent;
			}
			$profile		= $this->Modul_Model->read("select * from person where `key` = '".$key."' ");
			
			if(count($profile) > 0){
				$email = $this->buildCustomID($user);
				$query = "insert into `user` (email, first_name, last_name, marga, jenkel, hidup, tanggal_lahir, tempat_lahir, tanggal_meninggal, tempat_meninggal, 
								alamat, kota, status, user_saved, date_saved) 
								values ('".$email."', '".$first_name."', '".$last_name."', '".$marga."', '".$jenkel."', '".$hidup."', '".$tanggal_lahir."', '".$tempat_lahir."', 
								'".$tanggal_meninggal."', '".$tempat_meninggal."', '".$alamat."', '".$kota."', '2', '".$user."', now())";
				if($this->Modul_Model->execute($query)){
					$parent	= $profile[0]["key"];
					$group	= $profile[0]["group"];
					$index	= $this->Modul_Model->read("select max(`index`)+1 as 'index' from person where `group` = '".$group."' ")[0]["index"];
					
					$query = "insert into person (`key`, parent, couple, `group`, `index`) values ('".$email."', '".$parent."', '-', '".$group."', '".$index."')";
					$this->Modul_Model->execute($query);
					
					$data	= $this->Modul_Model->read("select * from user where email = '".$email."'")[0];					
					$person	= $this->Modul_Model->read("select * from person where `key` = '".$email."' and `parent` = '".$parent."' 
								and `index` = '".$index."' and `group` = '".$group."' ")[0];
								
					$r 		= 1; $msg = "Add Child Success ";
					if($ACTION_TYPE == 14){
						$msg = "Add Sibling Success ";
					}
				}
				
				$this->upload($email, "file-1");
			}
		}
		if($ACTION_TYPE == 15){
			$profile		= $this->Modul_Model->read("select * from person where `key` = '".$key."' ");
			
			if(count($profile) > 0){
				$email = $this->buildCustomID($user);
				$query = "insert into `user` (email, first_name, last_name, marga, jenkel, hidup, tanggal_lahir, tempat_lahir, tanggal_lahir, tempat_lahir, alamat, kota, status, user_saved, date_saved) 
								values ('".$email."', '".$first_name."', '".$last_name."', '".$marga."', '".$jenkel."', '".$hidup."', '".$tanggal_lahir."', '".$tempat_lahir."', 
								'".$tanggal_meninggal."', '".$tempat_meninggal."', '".$alamat."', '".$kota."', '2', '".$user."', now())";
								
				if($this->Modul_Model->execute($query)){
					$emailCouple = $this->buildCustomID($user);
					$queryCouple = "insert into `user` (email, first_name, status, user_saved, date_saved) 
									values ('".$emailCouple."', '".$first_name."\' Couple', '2', '".$user."', now())";
					$this->Modul_Model->execute($queryCouple);
					
					$parent	= "-";
					$group	= $profile[0]["group"];
					$index	= $this->Modul_Model->read("select min(`index`)-1 as 'index' from person where `group` = '".$group."' ")[0]["index"];
					
					$query = "insert into person (`key`, parent, couple, `group`, `index`) values ('".$email."', '".$parent."', '".$emailCouple."', '".$group."', '".$index."')";
					$this->Modul_Model->execute($query);
					
					$query = "update person set parent = '".$email."' where `key` = '".$profile[0]["key"]."' ";
					$this->Modul_Model->execute($query);
					
					$data		= $this->Modul_Model->read("select * from user where email = '".$email."'")[0];
					$dataC		= $this->Modul_Model->read("select * from user where email = '".$emailCouple."'")[0];
					
					$person		= $this->Modul_Model->read("select * from person where `key` = '".$email."'")[0];
					$r 		= 1; $msg = "Add Parent Success ";
				}
				
				$this->upload($email, "file-1");
			}
		}
		
		$result = array("result" => $r, "data" => $data, "dataC" => $dataC, "person" => $person, "msg" => $msg);
		echo json_encode($result);
		
		/*private static final int EDIT_PROFILE = 11; String EDIT_PROFILE_TEXT = "Edit Profile";
		private static final int ADD_COUPLE = 12; String ADD_COUPLE_TEXT = "Add Couple";
		private static final int ADD_CHILD = 13; String ADD_CHILD_TEXT = "Add Child";
		private static final int ADD_SIBLING = 14; String ADD_SIBLING_TEXT = "Add Sibling";
		private static final int ADD_PARENT = 15; String ADD_PARENT_TEXT = "Add Parent ( boy )";*/
	}
	
	public function personByID(){
		$data = array(); $dataC = array(); $person = array(); $msg = ""; $r = 0;
		
		$ACTION_TYPE	= $this->input->post("ACTION_TYPE");
		
		$parent			= $this->input->post("parent");
		$key			= $this->input->post("key");
		$user			= $this->input->post("user");
		$email 			= $this->input->post("ID");
		
		if($ACTION_TYPE == 12){}
		if($ACTION_TYPE == 13){
			$profile		= $this->Modul_Model->read("select * from person where `key` = '".$key."' ");
			
			if(count($profile) > 0){
				$parent	= $profile[0]["key"];
				$group	= $profile[0]["group"];
				$index	= $this->Modul_Model->read("select max(`index`)+1 as 'index' from person where `group` = '".$group."' ")[0]["index"];
				
				$query = "insert into person (`key`, parent, couple, `group`, `index`) values ('".$email."', '".$parent."', '-', '".$group."', '".$index."')";
				$this->Modul_Model->execute($query);
				
				$data	= $this->Modul_Model->read("select * from user where email = '".$email."'")[0];
				$person	= $this->Modul_Model->read("select * from person where `key` = '".$email."' and `parent` = '".$parent."' 
							and `index` = '".$index."' and `group` = '".$group."' ")[0];
				$r 		= 1; $msg = "Add Child Success ";
			}
		}
		if($ACTION_TYPE == 15){}
		
		$result = array("result" => $r, "data" => $data, "dataC" => $dataC, "person" => $person, "msg" => $msg);
		echo json_encode($result);
	}
	
	public function upload($filename, $postname){
		$filepath = './assets/images/person/'; //
		$filepathS = './assets/images/person/small/'; //
		//$filename = $lastID . "_" . $i;
					
		//$postname = 'file-'.$i;
		if(isset($_FILES[$postname])){
			$path = $_FILES[$postname]['name'];
			//$ext = pathinfo($path, PATHINFO_EXTENSION);
			$ext = "png";
			
			$target_path = $filepath. $filename . "." . $ext;
			$target_path2 = $filepathS. $filename . "." . $ext;
			move_uploaded_file($_FILES[$postname]['tmp_name'], $target_path);
			//move_uploaded_file($_FILES[$postname]['tmp_name'], $target_path2);
			$this->Img_Resize($target_path, $target_path2, 300);
			
			//$ext = $this->do_upload($filepath, $filename, $postname);	
			//$images .= $filename . "." .$ext . ";";
		}
		else{
			//if ( ! write_file(APPPATH."kecret".$i.".txt", $postname));
			$this->writeFile("files/upload.txt", json_encode($_FILES));//$this->input->post
		}
	}
	
	public function addRelative(){
		$user		= $this->input->post("user");
		$relative	= $this->input->post("relative");
		
		$is_user	= $this->Modul_Model->read("select is_user from `user` where email = '".$relative."'")[0]["is_user"];
		
		$status		= 0;
		
		if($is_user != 1){
			$status = 11;
		}
		
		$query		= "insert into relative (user, relative, status) values ('".$user."', '".$relative."', ".$status.") ";
		$result		= array();
		if($this->Modul_Model->execute($query)){
			//$query		= "insert into relative (user, relative, status) values ('".$relative."', '".$user."', 0) ";
			//$this->Modul_Model->execute($query);
			
			$data = $this->Modul_Model->read("select * from `user` where `email` = '".$relative."'")[0];
			$result = array("result" => 1, "data" => $data, "msg" => "Add Relative Success");
		}
		else{
			$result = array("result" => 0, "msg" => "Add Relative Failed");
		}
		echo json_encode($result);
	}
	
	public function confirmRelative(){
		$user		= $this->input->post("user");
		$relative	= $this->input->post("relative");
		$confirm	= $this->input->post("confirm");
		
		if($confirm == -1){
			$query		= "update relative set status = 40 where relative = '".$user."' and `user` = '".$relative."' ";
			if($this->Modul_Model->execute($query)){
				$result = array("result" => 1, "msg" => "Denied Relative Success");
			}
			else{
				$result = array("result" => 0, "msg" => "Something wrong, Please try again later");
			}
			echo json_encode($result);
			exit;
		}
		if($confirm == 0){
			$query		= "update relative set status = 15 where relative = '".$user."' and `user` = '".$relative."' ";
			if($this->Modul_Model->execute($query)){
				$query		= "insert into relative (user, relative, status) values ('".$user."', '".$relative."', 15) ";
				$this->Modul_Model->execute($query);
				
				$result = array("result" => 1, "msg" => "Maybe Relative Success");
			}
			else{
				$result = array("result" => 0, "msg" => "Something wrong, Please try again later");
			}
			echo json_encode($result);
			exit;
		}
		
		//$query		= "insert into relative (user, relative, status) values ('".$user."', '".$relative."', 0) ";
		$query		= "update relative set status = 10 where relative = '".$user."' and `user` = '".$relative."' ";
		$result		= array();
		if($this->Modul_Model->execute($query)){
			$query		= "insert into relative (user, relative, status) values ('".$user."', '".$relative."', 11) ";
			$this->Modul_Model->execute($query);
			
			$data = $this->Modul_Model->read("select * from `user` where `email` = '".$relative."'")[0];
			$result = array("result" => 1, "data" => $data, "msg" => "Confirm Relative Success");
		}
		else{
			$result = array("result" => 0, "msg" => "Add Relative Failed");
		}
		echo json_encode($result);
	}
	
	public function searchRelative(){
		
		$user = $this->input->post("user");
		//$user = 'uqhy@gmail.com';
		$keyword = $this->input->post("keyword");
		//$keyword = "ask";
		$keyword = strtolower($keyword);
		
		$lastEmail = "";
		$data = array();
						
		$query1 = "select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status',
						(select `key` from person where `index` = 0 and `group` = (select `group` from person where `key` = u.email or `couple` = u.email limit 0, 1)) as 'master'
						from `user` u where u.email <>  '".$user."' and ( lower(u.first_name) like '%".$keyword."%' or lower(u.last_name) like '%".$keyword."%' or lower(u.marga) like '%".$keyword."%' )
						and (u.email in (select relative from relative where `user` = '".$user."') 
							or u.email in (select relative from relative where `user` in ( select relative from relative where `user` = '".$user."')) ) ";
						
		$query2 = "select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status' ,
						(select `key` from person where `index` = 0 and `group` = (select `group` from person where `key` = u.email or `couple` = u.email)) as 'master'
						from `user` u where u.email <>  '".$user."' and  ( lower(u.first_name) like '%".$keyword."%' or lower(u.last_name) like '%".$keyword."%' or lower(u.marga) like '%".$keyword."%' )
						and u.email in (select relative from relative where `user` = '".$user."') ";
		
		$query3 = "select u.*, ifnull((select `status` from `relative` where `relative` = u.email and `user` = '".$user."' ), -1) as 'relative_status' ,
						(select `key` from person where `index` = 0 and `group` = (select `group` from person where `key` = u.email or `couple` = u.email)) as 'master'
						from `user` u where u.email <>  '".$user."' and  ( lower(u.first_name) like '%".$keyword."%' or lower(u.last_name) like '%".$keyword."%' or lower(u.marga) like '%".$keyword."%' ) ";

		
		$person1 = $this->Modul_Model->read($query1); 
		if(count($person1) > 0){
			for($i = 0; $i < count($person1); $i++){
				$person1[$i]["master_detail"] = $this->Modul_Model->read("select * from `user` where email =  '".$person1[$i]["master"]."'")[0];
				
				$path	= "./assets/images/person/small/" . $person1[$i]["email"] . ".jpg";
				if(file_exists($path)){ $thumb 					= file_get_contents($path); $thumb = base64_encode($thumb); $person1[$i]["thumb"] = $thumb; }
				else{ $person1[$i]["thumb"] = ""; }
				
				$lastEmail .= "'" . $person1[$i]["email"] . "',"; array_push($data, $person1[$i]);
			}
		}
		
		if(count($data) <= 10){
			if(strlen($lastEmail) > 0){
				if(substr($lastEmail, strlen($lastEmail)-1, 1)  == ","){
					$lastEmail = substr($lastEmail, 0, strlen($lastEmail)-1);
				}
				$query2 .= " and u.email not in (".$lastEmail.") ";
			}
			
			$person2 = $this->Modul_Model->read($query2); 
			if(count($person2) > 0){
				for($i = 0; $i < count($person2); $i++){
					$person2[$i]["master_detail"] = $this->Modul_Model->read("select * from `user` where email =  '".$person2[$i]["master"]."'")[0];
				
					$path	= "./assets/images/person/small/" . $person2[$i]["email"] . ".jpg";
					if(file_exists($path)){ $thumb 					= file_get_contents($path); $thumb = base64_encode($thumb); $person2[$i]["thumb"] = $thumb; }
					else{ $person2[$i]["thumb"] = ""; }
					
					$lastEmail .= "'" . $person2[$i]["email"] . "',"; array_push($data, $person2[$i]);
				}
			}
		}
		
		if(count($data) <= 10){
			if(strlen($lastEmail) > 0){
				if(substr($lastEmail, strlen($lastEmail)-1, 1)  == ","){
					$lastEmail = substr($lastEmail, 0, strlen($lastEmail)-1);
				}
				$query3 .= " and u.email not in (".$lastEmail.") ";
			}
			$person3 = $this->Modul_Model->read($query3); 
			if(count($person3) > 0){
				for($i = 0; $i < count($person3); $i++){
					$person3[$i]["master_detail"] = $this->Modul_Model->read("select * from `user` where email =  '".$person3[$i]["master"]."'");
				
					if(count($person3[$i]["master_detail"]) > 0){
						$person3[$i]["master_detail"] = $person3[$i]["master_detail"][0];
						$path	= "./assets/images/person/small/" . $person3[$i]["email"] . ".jpg";
						if(file_exists($path)){ $thumb 					= file_get_contents($path); $thumb = base64_encode($thumb); $person3[$i]["thumb"] = $thumb; }
						else{ $person3[$i]["thumb"] = ""; }
						
						$lastEmail .= "'" . $person3[$i]["email"] . "',"; array_push($data, $person3[$i]);
					}
				}
			}
		}
		
		$result = json_encode(array("result" => 1, "data" => $data, "msg" => ""));
		$this->writeFile("result.txt", $result);
		echo $result;
	}
	
	public function seemRelative(){
		$user = $this->input->post("user");
		//$user = 'arista@gmail.com';
		//$user = 'uqhy@gmail.com';
		
		$data = array();
		$me			= $this->Modul_Model->read("select * from person where `key` = '".$user."' ");
		
		if(count($me) <= 0){
			echo json_encode($data);
			exit;
		}
		$me = $me[0];
		
		$myRelative	= $this->Modul_Model->read(" select * from `user` where email in ( select `key` from person where `group` = '".$me["group"]."' )");
		
		
		$listEmail = ""; foreach($myRelative as $m)$listEmail .= "'".strtolower($m["email"])."',"; $listEmail = substr($listEmail, 0, strlen($listEmail)-1); 
		$listEmail = str_replace(",''", "", $listEmail );
		
		$listFirstName = ""; foreach($myRelative as $m)$listFirstName .= "'".strtolower($m["first_name"])."',"; $listFirstName = substr($listFirstName, 0, strlen($listFirstName)-1); 
		$listFirstName = str_replace(",''", "", $listFirstName ); $listFirstName = str_replace(",'father'", "", $listFirstName );$listFirstName = str_replace("'father'", "", $listFirstName );
		$listFirstName = str_replace("''", "", $listFirstName );
		
		$listLastName = ""; foreach($myRelative as $m)$listLastName .= "'".strtolower($m["last_name"])."',"; $listLastName = substr($listLastName, 0, strlen($listLastName)-1);  
		$listLastName = str_replace(",''", "", $listLastName );$listLastName = str_replace("''", "", $listLastName );
		
		$listMarga = ""; foreach($myRelative as $m)$listMarga .= "'".strtolower($m["marga"])."',"; $listMarga = substr($listMarga, 0, strlen($listMarga)-1);  
		$listMarga = str_replace(",''", "", $listMarga ); $listMarga = str_replace("''", "", $listMarga );
		
		$subFilter = "";
		
		if(strlen($listFirstName) > 0){
			$subFilter .= " first_name in (".$listFirstName.") or";
		}
		if(strlen($listLastName) > 0){
			$subFilter .= " last_name in (".$listLastName.") or";
		}
		if(strlen($listMarga) > 0){
			$subFilter .= " marga in (".$listMarga.") or";
		}
		
		
		if(strlen($subFilter) > 0){
			$subFilter = substr($subFilter, 0, strlen($subFilter) - 2);
			//$subFilter = " and (".$subFilter.")";
			$subFilter = " and email in (select `key` from person where `group` in (select `group` from person where `key` in (select email from `user` where  ".$subFilter." )))";
			
		}
		
		$query = " select * from `user` where is_user = 1 and email <> '".$user."' 
					and email not in (".$listEmail.") 
					".$subFilter." ";
		//echo $query. "<br /><br />";
		
		$data = $this->Modul_Model->read($query);
		
		if(count($data) > 0){
			for($i = 0; $i < count($data); $i++){				
				$path	= "./assets/images/person/small/" . $data[$i]["email"] . ".jpg";
				if(file_exists($path)){ $thumb = file_get_contents($path); $thumb = base64_encode($thumb); $data[$i]["thumb"] = $thumb; }
				else{ $data[$i]["thumb"] = ""; }
				
			}
		}
		
		$result = json_encode(array("result" => 1, "data" => $data, "msg" => ""));
		$this->writeFile("result.txt", $result);
		echo $result;
	}
	
	public function convertImage(){
		$data = $this->Modul_Model->read("select * from user");
		for($i = 0; $i < count($data); $i++){
			$path	= "./assets/images/person/" . $data[$i]["email"] . ".png";
			$fixed	= "./assets/images/person/fixed/" . $data[$i]["email"] . ".png";
			$small	= "./assets/images/person/small/" . $data[$i]["email"] . ".png";
			$thumb	= "./assets/images/person/thumb/" . $data[$i]["email"] . ".png";
			$icon	= "./assets/images/person/icon/" . $data[$i]["email"] . ".png";
			
			if(file_exists($path)){
				$this->Img_Resize($path, $fixed, 1000);
				$this->Img_Resize($path, $small, 300);
				$this->Img_Resize($path, $thumb, 100);	
				$this->Img_Resize($path, $icon, 50);	
			}
		}
	}
	
function Img_Resize($path, $target, $maxsize) 
{
	//copy($path, $target);
	//$path = $target;
	$source         = $path;
	$destination    = $target;

	$size = getimagesize($source);
	$width_orig = $size[0];
	$height_orig = $size[1];
	unset($size);
	$height = $maxsize+1;
	$width = $maxsize;
	while($height > $maxsize){
		$height = round($width*$height_orig/$width_orig);
		$width = ($height > $maxsize)?--$width:$width;
	}
	unset($width_orig,$height_orig,$maxsize);
	$images_orig    = imagecreatefromstring( file_get_contents($source) );
	$photoX         = imagesx($images_orig);
	$photoY         = imagesy($images_orig);
	$images_fin     = imagecreatetruecolor($width,$height);
	imagesavealpha($images_fin,true);
	$trans_colour   = imagecolorallocatealpha($images_fin,0,0,0,127);
	imagefill($images_fin,0,0,$trans_colour);
	unset($trans_colour);
	ImageCopyResampled($images_fin,$images_orig,0,0,0,0,$width+1,$height+1,$photoX,$photoY);
	unset($photoX,$photoY,$width,$height);
	imagepng($images_fin,$destination);
	unset($destination);
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);

}
	
	function buildCustomID($str){
		$id = "";
		$continue = true;
		while($continue){
			$id = $str . "_" . rand(1, 9999999);
			$isExist = $this->Modul_Model->read("select count(*) as 'total' from `user` where `email` = '".$id."' ")[0];
			if($isExist["total"] <= 0){
				$continue = false;
			}
		}
		
		return $id;
	}
	
	function buildNewGroup(){
		$group = "";
		$continue = true;
		while($continue){
			$group = rand(10000, 99999);
			$isExist = $this->Modul_Model->read("select count(*) as 'total' from person where `group` = '".$group."' ")[0];
			if($isExist["total"] <= 0){
				$continue = false;
			}
		}
		
		return $group;
	}
	
	function writeFile($path, $content){
		/*$this->load->helper('file');
		$data = $content;

		if ( !write_file($path, $data)){
			 echo 'Unable to write the file';
		}*/
	}
}
