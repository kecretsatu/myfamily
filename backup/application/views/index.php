
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

		<script type="text/javascript" src="<?php echo base_url();?>assets/js/sidebar.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js" ></script>
		
		<link href="<?php echo base_url() ;?>assets/css/sidebar.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/css/header.css" rel="stylesheet">
		<link href="<?php echo base_url() ;?>assets/css/styles.css" rel="stylesheet">
		
		<!-- charts -->
		<script src="<?php echo base_url() ;?>js/raphael-min.js"></script>
		<script src="<?php echo base_url() ;?>js/morris.js"></script>
		<link rel="stylesheet" href="<?php echo base_url() ;?>css/morris.css">
		<!-- //charts -->
		<!--skycons-icons-->
		<script src="<?php echo base_url() ;?>js/skycons.js"></script>
		<!--//skycons-icons-->
		
		<title><?php echo $title; ?></title>
	</head>
	<body>	
		<div class="body">
			<?php
			$this->load->view('templates/sidebar.php');
			$this->load->view('templates/header.php');
			$this->load->view($body . '/index.php');
			?>
		</div>
	</body>
	
</html>