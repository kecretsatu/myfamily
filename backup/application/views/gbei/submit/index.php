<!-- Page Content -->
<div class="page-title"><h1>Submit Laporan</h1></div>
<div class="page-content row">
	<div class="col-md-9 no-padding">
		<div id="galeri">
			<?php $this->load->view('templates/text-on-line.php', array('tol_bg' => '#0073b6', 'tol_bgtext' => '#f8f8f8', 'tol_text' => 'Data Galeri', 'tol_colortext' => '#0073b6')); ?>
			<div style="background:#fff">
				<table class="table table-responsive table-bordered">
					<thead>
						<th style="width:40%">Data</th>
						<th style="width:20%">Januari 2017 - Maret 2017</th>
						<th style="width:20%">April 2017</th>
						<th style="width:20%">Akumulasi</th>
					</thead>
					<tbody>
						<tr>
							<td><b>REKENING EFEK</b></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
						</tr>
						<tr>
							<td><b>NILAI TRANSAKSI</b></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" type="text" value="0" /></td>
						</tr>
						<tr>
							<td><b>Total</b></td>
							<td><input class="input-custom-1 input-number" readonly="readonly" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" readonly="readonly" type="text" value="0" /></td>
							<td><input class="input-custom-1 input-number" readonly="readonly" type="text" value="0" /></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<br />
		<div id="kunjungan">
			<?php $this->load->view('templates/text-on-line.php', array('tol_bg' => '#0073b6', 'tol_bgtext' => '#f8f8f8', 'tol_text' => 'Kunjungan', 'tol_colortext' => '#0073b6')); ?>
			
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-custom-2">
						<div class="panel-heading">Rekening Efek</div>
						<div class="panel-body"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-custom-3">
						<div class="panel-heading">Nilai Transaksi</div>
						<div class="panel-body"></div>
					</div>
				</div>
			</div>
		</div>
		<hr />
	</div>
	
	<div class="col-md-3">
		<div class="right-sidebar">
			<ul class="right-sidebar-ul">
				<li><a class="active" href="#">Data Galeri</a></li>
				<li><a href="#">Kunjungan</a></li>
				<li><a href="#">Sosialisasi / Edukasi</a></li>
				<li><a href="#">Layanan Data</a></li>
				<li><a href="#">Publikasi</a></li>
			</ul>
		</div>
	</div>

</div>
<!-- /#page-content -->