<!-- Sidebar -->
<div class="sidebar">
	<ul class="sidebar-nav">
		<li>
			<a href="<?php echo base_url() ;?>dashboard"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a>
		</li>
		<li><label>Master</label></li>
		<li>
			<a href="<?php echo base_url() ;?>user"><i class="fa fa-vcard" aria-hidden="true"></i><span>User</span></a>
		</li>
		<li><label>Akun</label></li>
		<li>
			<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Profil</span></a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Keluar</span></a>
		</li>
	</ul>
</div>
<!-- /#sidebar -->

<style>
.sidebar li i:not(.fa-bars){
	*visibility:hidden;
}
</style>