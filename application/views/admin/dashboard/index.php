
<!-- animate -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/wow.min.js" ></script>		
<link href="<?php echo base_url() ;?>assets/css/animate.min.css" rel="stylesheet">
<script>
new WOW().init();
$(window).load(function() {
	setTimeout(function(){
		$(".page-content-body").show();
		refreshGraph();
	}, 200);
});
</script>
<!-- // animate -->
		
<!-- Page Content -->
<div class="page-content">
	<div class="page-content-body">
		Dashboard
		<br />
	</div>
</div>
<!-- /#page-content -->
