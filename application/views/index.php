<?php
if(!isset($this->session->userdata["userlogin"])){
	header("location: ".base_url() . "login");
	exit;
}

$userlogin = $this->session->userdata['userlogin'];

$h = true; $s = true;

if(isset($showHeader)){
	$h = $showHeader;
}
if(isset($showSidebar)){
	$s = $showSidebar;
}

?>

<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap Plugin -->
		<link href="<?php echo base_url() ;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/bootstrap/css/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/bootstrap/css/datepicker.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">

		<script src="<?php echo base_url() ;?>assets/bootstrap/js/jquery.js"></script>
		<script src="<?php echo base_url() ;?>assets/bootstrap/js/jquery.min.js"></script>
		<script src="<?php echo base_url() ;?>assets/bootstrap/js/bootstrap.min.js"></script>				
		<script src="<?php echo base_url() ;?>assets/bootstrap/js/bootstrap-timepicker.js"></script>
		<script src="<?php echo base_url() ;?>assets/bootstrap/js/bootstrap-datepicker.js"></script>
		
		<!-- datepicker -->
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
		<!-- // datepicker -->

		<!-- datatables -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js" ></script>
		<link href="<?php echo base_url() ;?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
		<!-- // datatables -->

		<!-- select2 -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-select.min.js" ></script>
		<link href="<?php echo base_url() ;?>assets/css/bootstrap-select.min.css" rel="stylesheet">
		<!-- // select2 -->

		<!-- sidebar -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/sidebar.js" ></script>
		<link href="<?php echo base_url() ;?>assets/css/sidebar.css" rel="stylesheet">
		<!-- // sidebar -->
		
		<!-- animate -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/wow.min.js" ></script>		
		<link href="<?php echo base_url() ;?>assets/css/animate.min.css" rel="stylesheet">
		<!-- // animate -->
		
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js" ></script>		
		<link href="<?php echo base_url() ;?>assets/css/header.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/css/styles.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/css/mail.css" rel="stylesheet">

		<!-- scrollbar -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/scrollbar.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.scrollbar.js" ></script>
		<link href="<?php echo base_url() ;?>assets/css/scrollbar.css" rel="stylesheet">
		<!-- // scrollbar -->
		
		<!-- charts -->
		<script src="<?php echo base_url() ;?>assets/js/raphael-min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/graph.js" ></script>		
		<script src="<?php echo base_url() ;?>assets/js/morris.js"></script>
		<link rel="stylesheet" href="<?php echo base_url() ;?>assets/css/morris.css">
		<!-- //charts -->
		
		<!--skycons-icons-->
		<script src="<?php echo base_url() ;?>assets/js/skycons.js"></script>
		<!--//skycons-icons-->
		
		<!--web-fonts-->
		<link href='<?php echo base_url() ;?>assets/css/font-Raleway.css' rel='stylesheet' type='text/css'>
		<link href='<?php echo base_url() ;?>assets/css/font-Open-Sans.css' rel='stylesheet' type='text/css'>
		<link href='<?php echo base_url() ;?>assets/css/font-Pompiere.css' rel='stylesheet' type='text/css'>
		<link href='<?php echo base_url() ;?>assets/css/font-Fascinate.css' rel='stylesheet' type='text/css'>
		<!--web-fonts-->
		
		<title><?php echo $title; ?></title>
	</head>
	<body>	
		<div class="body <?php if(!$h){echo "no-header"; } ?>">
			<?php
			
			if($s){
				$this->load->view('templates/sidebar.php');
			}
			if($h){
				$this->load->view('templates/header.php', $userlogin);
			}
			
			if(strpos($body, '.php') !== false){
				$this->load->view($body);
			}
			else{
				$this->load->view($body . '/index.php');
			}
			
			?>
			
			<!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog" style="width:1000px;">
				
				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-body">
					  <p>Please wait...</p>
					</div>
				  </div>
				  
				</div>
			  </div>
			
		</div>
		
	</body>
</html>