<nav class="header navbar navbar-default">
	<div class="col-md-6">
		<div class="bars">
			<a id="sidebar-button" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group">
			<input class="form-control input-sm">
			<span class="input-group-btn">
				<button class="btn btn-sm btn-search"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</div>
	<div class="col-md-3">
		<div class="header-right">
			<ul class="nofitications-dropdown">
				<li id="nofitications-message" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope" style="color:red"></i><span class="badge">0</span></a>
					<ul class="dropdown-menu nofitications-box">
						<li>
							<div class="notification-header">
								<h3>You have 0 new messages</h3>
							</div>
						</li>
						<div class="notification-list">
						
						</div>
						<li>
							<div class="notification-bottom">
								<a href="<?php echo base_url();?>message/inbox?page=1">See all messages</a>
							</div> 
						</li>
					</ul>
				</li>
				<li id="nofitications-report" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell" style="color:blue"></i><span class="badge">0</span></a>
					<ul class="dropdown-menu nofitications-box">
						<li>
							<div class="notification-header">
								<h3>You have 0 new reports</h3>
							</div>
						</li>
						<div class="notification-list">
						
						</div>
					</ul>
				</li>
				<li class="dropdown notification-profile">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<div class="profile-img">
							<img src="<?php echo base_url(); ?>assets/images/blank-user.png" alt="" />
							<div class="clearfix"></div>	
						</div>	
					</a>
					<ul class="dropdown-menu drp-mnu nofitications-box">
						<li>
							<div class="notification-header">
								<h3 style="font-family:Raleway"><?php echo $this->session->userdata['userlogin']->nama ; ?></h3>
							</div>
						</li>
						<li> <a href="#"><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Profile</a> </li> 
						<li> <a href="#"><i class="fa fa-cog"></i>&nbsp;&nbsp;&nbsp;Settings</a> </li> 
						<li> <a href="<?php echo base_url(); ?>auth/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;&nbsp;Keluar</a> </li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	
</nav>
<style>
.header .header-right .nofitications-dropdown .dropdown span.badge{
display:none;
}
</style>
<script>

$(document).ready(function(e){
	setTimeout(function(){
		getNotif();	
	}, 2000);
});

function getNotif(){
	$.ajax({type: "POST", url: "<?php echo base_url(); ?>notif", dataType: 'json', data: {}, 
		success: function(data){
			var message = data.message;
			if(message.count > 0){
				$(".nofitications-dropdown #nofitications-message .badge").html(message.count);
				$(".nofitications-dropdown #nofitications-message .notification-header h3").html("You have "+message.count+" new messages");
				$(".nofitications-dropdown #nofitications-message .badge").show();
				
				$.each(message.data, function(index, array){
					if($('#m'+array["key"]+'').length <= 0){
						var items = '';
						items += '<li id="m'+array["key"]+'"><a href="#">';
						items += '<div class="notification-img"><img src="<?php echo base_url(); ?>assets/images/blank-user.png" alt=""></div>';
						items += '<div class="notification-desc"><b>'+array["nama"]+'</b><p>'+array["subject"]+'</p><p><span>'+array["date"]+'</span></p></div>';
						items += '<div class="clearfix"></div>';
						items += '</a></li>';
						$(".nofitications-dropdown #nofitications-message .notification-list").prepend(items);
					}
				});
			}
			
			var report = data.report;
			if(report.count > 0){
				$(".nofitications-dropdown #nofitications-report .badge").html(report.count);
				$(".nofitications-dropdown #nofitications-report .notification-header h3").html("You have "+report.count+" new report");
				$(".nofitications-dropdown #nofitications-report .badge").show();
				
				$.each(report.data, function(index, array){
					if($('#r'+array["key"]+'').length <= 0){
						var items = '';
						items += '<li id="r'+array["key"]+'"><a href="#">';
						items += '<div class="notification-img"><img src="<?php echo base_url(); ?>assets/images/blank-user.png" alt=""></div>';
						items += '<div class="notification-desc"><b>'+array["nama"]+'</b><p>Submit Laporan '+array["bulan"]+' '+array["tahun"]+'</p><p><span>'+array["date"]+'</span></p></div>';
						items += '<div class="clearfix"></div>';
						items += '</a></li>';
						$(".nofitications-dropdown #nofitications-report .notification-list").prepend(items);
					}
				});
			}
			
			
		},
		error: function (data) {
		}
	})
	.done(function(data){
		setTimeout(function(){
			getNotif();	
		}, 5000);
	});
}
</script>
